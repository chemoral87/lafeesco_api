<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataSetResource;
use App\Models\FaithHouse;
use Illuminate\Http\Request;

class FaithHouseController extends Controller {
  const PATH_S3 = "faith_house/";

  public function index(Request $request) {
    // DB::enableQueryLog();<
    $query = queryServerSide($request, FaithHouse::query());
    $active_faith_house = $request->get('active_faith_house');

    $filter = $request->get("filter");
    if ($active_faith_house == 'true') {
      // end_date is null
      $query->whereNull("end_date");
      // $query->where("end_date", $active_faith_house);
    }
    if ($filter) {
      $query->where(function ($query) use ($filter) {
        $query->where("exhibitor", "like", "%" . $filter . "%")
          ->orWhere("name", "like", "%" . $filter . "%")
          ->orWhere("host", "like", "%" . $filter . "%");
      });

    }

    $faith_houses = $query->paginate($request->get('itemsPerPage'));

    return new DataSetResource($faith_houses);
  }

  public function show(Request $request, $id) {
    $faith_house = FaithHouse::with('contacts')->find($id);

    if ($faith_house == null) {
      abort(405, 'Faith House not found');
    }

    return response()->json($faith_house);
  }

  public function create(Request $request) {
    // $faith_house = FaithHouse::create($request->all());

    $host_photo = $request->hasFile('host_photo') ? saveS3Blob($request->file('host_photo'), self::PATH_S3) : null;

    $exhibitor_photo = $request->hasFile('exhibitor_photo') ? saveS3Blob($request->file('exhibitor_photo'), self::PATH_S3) : null;

    $faith_house = FaithHouse::create(
      [
        'name' => $request->get('name'),
        // 'host' => $request->get('host'),
        // 'host_phone' => $request->get('host_phone'),
        // 'host_photo' => $host_photo,
        // 'exhibitor' => $request->get('exhibitor'),
        // 'exhibitor_phone' => $request->get('exhibitor_phone'),
        // 'exhibitor_photo' => $exhibitor_photo,
        'address' => $request->get('address'),
        'schedule' => $request->get('schedule'),
        'allow_matching' => $request->get('allow_matching'),
        'lat' => $request->get('lat'),
        'lng' => $request->get('lng'),
        'end_date' => $request->get('end_date'),
        'order' => $request->get('order'),
      ]
    );
    return ['success' => __('messa.faith_house_create')];
  }

  public function update(Request $request, $id) {

    $faith_house = FaithHouse::find($id);
    // if ($request->has('host_photo')) {
    //   try {
    //     deleteS3($faith_house->real_host_photo);
    //   } catch (Throwable $e) {
    //     Log::error(sprintf("%s - func %s - line %d - ", __CLASS__, __FUNCTION__, __LINE__) . $e->getMessage());
    //   }
    //   $host_photo = saveS3Blob($request->file('host_photo'), self::PATH_S3);
    //   $faith_house->host_photo = $host_photo;
    // }

    // if ($request->has('exhibitor_photo')) {
    //   try {
    //     deleteS3($faith_house->real_exhibitor_photo);
    //   } catch (Throwable $e) {
    //     Log::error(sprintf("%s - func %s - line %d - ", __CLASS__, __FUNCTION__, __LINE__) . $e->getMessage());
    //   }
    //   $exhibitor_photo = saveS3Blob($request->file('exhibitor_photo'), self::PATH_S3);
    //   $faith_house->exhibitor_photo = $exhibitor_photo;
    // }

    $faith_house->update([
      'name' => $request->get('name'),
      // 'host' => $request->get('host'),
      // 'host_phone' => $request->get('host_phone'),
      // 'exhibitor' => $request->get('exhibitor'),
      // 'exhibitor_phone' => $request->get('exhibitor_phone'),
      'address' => $request->get('address'),
      'schedule' => $request->get('schedule'),
      'allow_matching' => $request->get('allow_matching'),
      'lat' => $request->get('lat'),
      'lng' => $request->get('lng'),
      'end_date' => $request->get('end_date'),
      'order' => $request->get('order'),
    ]);
    return [
      'success' => __('messa.faith_house_update'),
    ];
  }

  public function delete($id) {
    FaithHouse::find($id)->delete();
    return ['success' => __('messa.faith_house_delete')];
  }

}
