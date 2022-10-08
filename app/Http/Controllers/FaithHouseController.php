<?php

namespace App\Http\Controllers;

use App\Models\FaithHouse;
use Illuminate\Http\Request;
use App\Http\Resources\DataSetResource;

class FaithHouseController extends Controller
{
    public function index(Request $request) {
        $query = queryServerSide($request, FaithHouse::from("faith_houses"));

        $faith_houses = $query->paginate($request->get('itemsPerPage'));

        // return response()->json([
        //   'faith_houses' => $faith_houses->items(),
        //   'total' => $faith_houses->total(),
        // ], 200, [], JSON_NUMERIC_CHECK);

        return new DataSetResource($faith_houses);
    }

    public function show(Request $request, $id) {
        $faith_house = FaithHouse::find($id);

        if ($faith_house == null) {
          abort(405, 'Faith House not found');
        }

        return response()->json($faith_house);
      }

    public function create(Request $request) {
        $house_faith = FaithHouse::create($request->all());
        return ['success' => __('messa.house_faith_create')];
    }

    public function update(Request $request, $id) {
        $house_faith = FaithHouse::where("id", $id)->update([
            'name' => $request->get('name'),
            'host' => $request->get('host'),
            'host_phone' => $request->get('host_phone'),
            'exhibitor' => $request->get('exhibitor'),
            'exhibitor_phone' => $request->get('exhibitor_phone'),
            'address' => $request->get('address'),
            'lat' => $request->get('lat'),
            'lng' => $request->get('lng'),
        ]);
        return [
            'success' => __('messa.house_faith_update'),
          ];
    }

    public function delete($id) {
        FaithHouse::find($id)->delete();
        return ['success' => __('messa.house_faith_delete')];
      }
}
