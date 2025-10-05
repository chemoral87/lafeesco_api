<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataSetResource;
use App\Models\FaithHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaithHouseController extends Controller {
  const PATH_S3 = "faith_house/";

  public function index(Request $request) {

    $query = queryServerSide($request, FaithHouse::query());
    $org_ids = auth()->user()->getOrgsByPermission("parking-car-index");

    $query->whereIn('org_id', $org_ids);

    $active_faith_house = $request->get('active_faith_house');
    $with_contacts = $request->get('with_contacts');

    $query->with('contacts');

    $filter = $request->get("filter");
    if ($active_faith_house == 'true') {
      // end_date is null
      $query->whereNull("end_date");
    }
    if ($filter) {
      $query->where("name", "like", "%" . $filter . "%");
      // filter by contacts
      if ($with_contacts == 1) {
        $query->orWhereHas('contacts', function ($query) use ($filter) {
          $query->where(DB::raw("CONCAT(name,' ',paternal_surname)"), "like", "%" . $filter . "%");

        });
      }
    }
    $faith_houses = $query->paginate($request->get('itemsPerPage'));
    return new DataSetResource($faith_houses);
  }

  public function show(Request $request, $id) {

// filter by my orgs
    $orgs = auth()->user()->profiles->pluck('org_id');

    $faith_house = FaithHouse::with('contacts')
      ->whereIn('org_id', $orgs)
      ->find($id);

    if ($faith_house == null) {
      abort(404, 'Faith House not found');

    }

    return response()->json($faith_house);
  }

  public function create(Request $request) {

    $faith_house = FaithHouse::create(
      [
        'name' => $request->get('name'),
        'address' => $request->get('address'),
        'schedule' => $request->get('schedule'),
        'allow_matching' => $request->get('allow_matching'),
        'lat' => $request->get('lat'),
        'lng' => $request->get('lng'),
        'end_date' => $request->get('end_date'),
        'order' => $request->get('order'),
        'org_id' => $request->get('org_id'),
      ]
    );
    return ['success' => __('messa.faith_house_create'), 'id' => $faith_house->id];
  }

  public function update(Request $request, $id) {

    $faith_house = FaithHouse::find($id);

    $faith_house->update([
      'name' => $request->get('name'),
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
