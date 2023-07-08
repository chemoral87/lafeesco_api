<?php

namespace App\Http\Controllers;

use App\Models\ChurchService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChurchServiceController extends Controller {
  public function index(Request $request) {

    $start_date = $request->get("start_date") ? $request->get("start_date") : Carbon::now()->subDays(2)->format('Y-m-d');

    $end_date = Carbon::parse($start_date)->addMonths(3)->format('Y-m-d');

    $payload = [];
    $churchServices = ChurchService::with(['church_service_attendant.ministry' => function ($query) {
      $query->select("id", "name");
    }], ['church_service_attendant.attendant' => function ($query) {
      $query->select("id", "name", "paternal_surname");
    }])
      ->select("id", "event_date")
      ->orderBy('event_date')
      ->whereBetween('event_date', [$start_date, $end_date])
      ->get();

    foreach ($churchServices as $churchService) {
      $ministries = $churchService->church_service_attendant
        ->groupBy(function ($item, $key) {
          return $item['ministry']['id'];
        })
        ->map(function ($item, $ministryId) {
          $sortedAttendants = $item->map(function ($item, $key) {
            return [
              'id' => $item['attendant']['id'],
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
        })
        ->sortBy('order')
        ->values();

      $payload[] = [
        'church_service_id' => $churchService->id,
        'event_date' => $churchService->event_date,
        'ministries' => $ministries,
        'x' => $churchServices,
      ];
    }

    return $payload;

  }

  public function show(Request $request, $id) {
    $churchService = ChurchService::with(['church_service_attendant.attendant' => function ($query) {
      $query->select("id", "name", "paternal_surname", "photo");
    }], ['church_service_attendant.ministry' => function ($query) {
      $query->select("id", "name");
    }])
      ->find($id);

    $ministries = $churchService->church_service_attendant
      ->groupBy(function ($item, $key) {
        return $item['ministry']['id'];
      })
      ->map(function ($item, $ministryId) {
        $sortedAttendants = $item->map(function ($item, $key) {
          return [
            'id' => $item['attendant']['id'],
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
      })
      ->sortBy('order')
      ->values();

    $result = [
      'church_service_id' => $churchService->id,
      'event_date' => $churchService->event_date,
      'ministries' => $ministries,
    ];

    if ($churchService == null) {
      abort(405, 'Church Service not found');
    }

    return response()->json($result);

  }

  public function create(Request $request) {
    $church_service = ChurchService::create($request->all());
    return ['success' => __('messa.church_service_create')];
  }

}
