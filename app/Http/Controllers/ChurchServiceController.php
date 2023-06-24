<?php

namespace App\Http\Controllers;

use App\Models\ChurchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChurchServiceController extends Controller {
  public function index() {
    $query = new ChurchService;
    $church_services = $query->get();
    return [
      'church_services' => $church_services,
    ];
  }

  public function show(Request $request, $id) {
    // $church_service = ChurchService::with('attendant', 'ministry')->find($id);
    // $church_service = ChurchService::with('ministries.attendants')->find($id);
    // $church_service = ChurchService::with('ministries')->find($id);
    $churchService = ChurchService::with('church_service_attendant.ministry', 'church_service_attendant.attendant')
      ->find($id);

    $ministries = collect([]); // Create an empty collection to hold the ministries

    foreach ($churchService->church_service_attendant as $church_service_attendant) {

      // check if ministry and attendant are not null
      if ($church_service_attendant->ministry && $church_service_attendant->attendant) {

        // find if this ministry already exists in the collection
        // $ministry = $ministries->firstWhere('name', $church_service_attendant->ministry->name);
        $existingMinistryKey = $ministries->search(function ($ministry) use ($church_service_attendant) {
          return $ministry['name'] == $church_service_attendant->ministry->name;
        });

        // prepare the attendant data
        $attendant = [
          'name' => $church_service_attendant->attendant->name,
          'seq' => $church_service_attendant->seq,
        ];

        if ($existingMinistryKey !== false) { // if the ministry already exists in the collection
          // push the attendant into the existing ministry's attendants array
          Log::info("cis");
          Log::info($attendant);
          $currentMinistry = $ministries->get($existingMinistryKey);
          $currentMinistry['attendants'][] = $attendant;
          $ministries->put($existingMinistryKey, $currentMinistry);
          //   $ministry['attendants'][] = $attendant;
          //   $ministries[$existingMinistryKey]['attendants'][] = $attendant;
        } else { // if the ministry doesn't exist in the collection
          // push the ministry into the collection
          $ministries->push([
            'name' => $church_service_attendant->ministry->name,
            'attendants' => [$attendant], // put the attendant inside an array
          ]);
        }
      }
    }

    $result = [
      'church_service_id' => $churchService->id,
      'event_date' => $churchService->event_date,
      'ministries' => $ministries,
    ];

    // $result = $church_service->map(function ($church_service) {
    //   $ministries = $church_service->ministries->unique('name')->map(function ($ministry) {
    //     $attendants = $ministry->attendants->map(function ($attendant) {
    //       return [
    //         'name' => $attendant->name,
    //         'paternal_surname' => $attendant->paternal_surname,
    //         'seq' => $attendant->pivot->seq,
    //       ];
    //     });

    //     return [
    //       'name' => $ministry->name,
    //       'id' => $ministry->id,
    //       'attendants' => $attendants,
    //     ];
    //   });

    //   return [
    //     'church_service_id' => $church_service->id,
    //     'event_date' => $church_service->event_date,
    //     'ministries' => $ministries->values(),
    //   ];
    // });

    if ($churchService == null) {
      abort(405, 'Church Service not found');
    }

    return response()->json($result);
    // return response()->json($church_service);
  }

//   public function show(Request $request, $id) {
//     $church_service = ChurchService::with('attendant', 'ministry')->find($id);

//     if ($church_service == null) {
//       abort(405, 'Church Service not found');
//     }

//     return response()->json($church_service);
//   }

  public function create(Request $request) {

    $church_service = ChurchService::create($request->all());
    return ['success' => __('messa.church_service_create')];
  }

}
