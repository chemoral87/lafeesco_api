<?php

namespace App\Http\Controllers;

use App\Models\ChurchService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChurchServiceController extends Controller {
  public function index(Request $request) {

    $start_date = $request->get("start_date") ? $request->get("start_date") : Carbon::now()->subDays(2)->format('Y-m-d');

    $end_date = Carbon::parse($start_date)->addMonths(3)->format('Y-m-d');

    $payload = [];
    $churchServices = ChurchService::with('ministries', 'attendants')
      ->whereBetween('event_date', [$start_date, $end_date])
      ->select("id", "event_date")
      ->get();

    $churchServices->transform(function ($churchService) {
      $churchService->ministries->map(function ($ministry) use ($churchService) {
        $ministry->attendants = $churchService->attendants->where('pivot.ministry_id', $ministry->id)->map(function ($attendant) {
          return [
            'id' => $attendant->id,
            'name' => $attendant->name,
            'paternal_surname' => $attendant->paternal_surname,
            'photo' => $attendant->photo,
            'seq' => $attendant->pivot->seq, // Assuming 'seq' is a field in the pivot table
          ];
        });
        return $ministry;
      });
      // Remove the 'attendants' attribute from the 'churchService' level
      unset($churchService->attendants);
      return $churchService;
    });

    return $churchServices;
  }

  public function show(Request $request, $id) {
    // $churchService = ChurchService::with(['church_service_attendant.attendant' => function ($query) {
    //   $query->select("id", "name", "paternal_surname", "photo");
    // }], ['church_service_attendant.ministry' => function ($query) {
    //   $query->select("id", "name");
    // }])
    //   ->find($id);

    $churchService = ChurchService::with('ministries', 'attendants')
      ->select("id", "event_date")
      ->find($id);

    $churchService->ministries->transform(function ($ministry) use ($churchService) {
      $ministry->attendants = $churchService->attendants->where('pivot.ministry_id', $ministry->id)->map(function ($attendant) {
        return [
          'id' => $attendant->id,
          'name' => $attendant->name,
          'paternal_surname' => $attendant->paternal_surname,
          'photo' => $attendant->photo,
          'seq' => $attendant->pivot->seq, // Assuming 'seq' is a field in the pivot table
        ];
      })->values();
      return $ministry;
    });

    // Remove the 'attendants' attribute from the 'churchService' level
    unset($churchService->attendants);

    if ($churchService == null) {
      abort(405, 'Church Service not found');
    }

    return response()->json($churchService);

  }

  public function create(Request $request) {
    $church_service = ChurchService::create($request->all());
    return ['success' => __('messa.church_service_create')];
  }

  public function generate() {
    $today = Carbon::today()->toDateString();
    $endDate = Carbon::today()->addMonths(3);

    $churchServices = ChurchService::where('event_date', '>', $today)
      ->select("event_date")
      ->get()
      ->pluck('event_date')
      ->map(function ($date) {
        return Carbon::parse($date)->format('Y-m-d H:i');
      })
      ->toArray();

    $sundayTimes = ['09:00', '11:30', '18:00'];
    $wednesdayTime = '19:30';
    $churchServicesToCreate = [];
    // Log::info($churchServices);

    $startDate = Carbon::today();

    while ($startDate <= $endDate) {
      if ($startDate->isSunday()) {
        foreach ($sundayTimes as $time) {
          $eventDateTime = $startDate->format('Y-m-d') . ' ' . $time;
          //   if (!isset($existingChurchServices[$startDate->toDateString()][$time])) {
          if (!in_array($eventDateTime, $churchServices)) {
            $churchServicesToCreate[] = [
              'event_date' => $eventDateTime,
              // Add any other fields as needed
            ];
          }
        }
      } elseif ($startDate->isWednesday()) {
        $eventDateTime = $startDate->format('Y-m-d') . ' ' . $wednesdayTime;
        if (!in_array($eventDateTime, $churchServices)) {
          $churchServicesToCreate[] = [
            'event_date' => $eventDateTime,
            // Add any other fields as needed
          ];
        }
      }

      // Move to the next day
      $startDate->addDay();
    }

    // Batch insert the church services
    ChurchService::insert($churchServicesToCreate);

    Log::info("Created " . count($churchServicesToCreate) . " church services");
  }

//   public function generate() {
//     $today = Carbon::today()->toDateString();

//     $startDate = Carbon::today();
//     $endDate = $startDate->copy()->addMonths(3);
//     $churchServices = ChurchService::where('event_date', '>', $today)->get();

//     $wednesday = Carbon::WEDNESDAY;
//     $sunday = Carbon::SUNDAY;

//     while ($startDate <= $endDate) {
//       // Check if it's Wednesday and there is no church service at 19:30
//       if ($startDate->dayOfWeek === $wednesday && !$this->eventExists($churchServices, $startDate, '19:30')) {
//         $this->createChurchService($startDate, '19:30');
//       }

//       // Check if it's Sunday and there are no church services at 9:00, 11:30, and 18:00
//       if ($startDate->dayOfWeek === $sunday) {
//         foreach (['09:00', '11:30', '18:00'] as $time) {
//           if (!$this->eventExists($churchServices, $startDate, $time)) {
//             $this->createChurchService($startDate, $time);
//           }
//         }
//       }

//       // Move to the next day
//       $startDate->addDay();
//     }
//   }

//   private function eventExists($churchServices, $date, $time) {
//     // Check if there is a church service at the given date and time
//     return $churchServices->contains(function ($churchService) use ($date, $time) {
//       return Carbon::parse($churchService->event_date)->toDateString() === $date->toDateString() &&
//       Carbon::parse($churchService->event_date)->format('H:i') === $time;
//     });
//   }

//   private function createChurchService($date, $time) {
//     $eventDateTime = $date->format('Y-m-d') . ' ' . $time;

//     // Create a new church service
//     ChurchService::create([
//       'event_date' => $eventDateTime,
//       // Add any other fields as needed
//     ]);
//   }

}
