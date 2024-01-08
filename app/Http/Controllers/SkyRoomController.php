<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataSetResource;
use App\Models\SkyRoom;
use Illuminate\Http\Request;

class SkyRoomController extends Controller {

  public function index(Request $request) {
    $filter = $request->get("filter");
    $query = queryServerSide($request, SkyRoom::query());
    if ($filter) {
      $query->where("name", "like", "%" . $filter . "%");
    }
    $sky_rooms = $query->paginate($request->get('itemsPerPage'));
    return new DataSetResource($sky_rooms);
  }

  public function show($id) {
    $sky_room = SkyRoom::where("id", $id)->first();
    if ($sky_room == null) {
      abort(405, 'SkyRoom not found');
    }
    return response()->json($sky_room);
  }

  public function create(Request $request) {
    $sky_room = SkyRoom::create([
      'name' => $request->get('name'),
      'min_age' => $request->get('min_age'),
      'max_age' => $request->get('max_age'),
      'active' => $request->get('active'),
    ]);
    return ['success' => __('messa.sky_room_create')];
  }

  public function update(Request $request, $id) {
    $sky_room = SkyRoom::find($id);
    $sky_room->name = $request->get('name');
    $sky_room->min_age = $request->get('min_age');
    $sky_room->max_age = $request->get('max_age');
    $sky_room->active = $request->get('active');
    $sky_room->save();
    return ['success' => __('messa.sky_room_update')];
  }

  public function delete($id) {
    $sky_room = SkyRoom::find($id);
    $sky_room->delete();
    return ['success' => __('messa.sky_room_delete')];
  }
}
