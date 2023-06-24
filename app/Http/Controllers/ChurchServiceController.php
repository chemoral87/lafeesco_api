<?php

namespace App\Http\Controllers;

use App\Models\ChurchService;
use Illuminate\Http\Request;

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

    $ministries = $churchService->church_service_attendant
      ->groupBy(function ($item, $key) {
        return $item['ministry']['id'];
      })
      ->map(function ($item, $ministryId) {
        $sortedAttendants = $item->map(function ($item, $key) {
          return [
            'name' => $item['attendant']['name'],
            'paternal_surname' => $item['attendant']['paternal_surname'],
            'photo' => $item['attendant']['photo'],
            'seq' => $item['seq'],
          ];
        })
          ->sortBy('seq');

        return [
          'ministry_id' => $ministryId,
          'name' => $item[0]['ministry']['name'],
          'order' => $item[0]['ministry']['order'],
          'attendants' => array_values($sortedAttendants->toArray()),
        ];
        // return [
        //   'name' => $key,
        //   'attendants' => $item->transform(function ($item, $key) {
        //     return [
        //       'name' => $item['attendant']['name'],
        //       'paternal_surname' => $item['attendant']['paternal_surname'],
        //       'seq' => $item['seq'],
        //     ];
        //   })
        //     ->toArray(),
        // ];
      })
      ->sortBy('order')
      ->values();

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
