<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataSetResource;
use App\Models\ParkingCar;
use App\Models\ParkingCarContact;
use Illuminate\Http\Request;

class ParkingCarController extends Controller {

  public function index(Request $request) {
    $filter = $request->get("filter");
    $query = queryServerSide($request, ParkingCar::query());
    if ($filter) {
      $query->where("name", "like", "%" . $filter . "%");
    }
    $parking_cars = $query->paginate($request->get('itemsPerPage'));
    return new DataSetResource($parking_cars);
  }

  public function filter(Request $request) {
    $filter = $request->get("filter");

    $org_ids = auth()->user()->getOrgsByPermission("parking-car-index");

    $query = ParkingCar::query();
// search last plates
// top 10  parking_cars
    $parking_cars = $query->where("plate_number", "like", "%" . $filter)
      ->whereIn("org_id", $org_ids)
      ->orderBy("id", "desc")
      ->take(10)
      ->get();

    return $parking_cars;
  }

  public function show($id) {
    $org_ids = auth()->user()->getOrgsByPermission("parking-car-index");

    $parking_car = ParkingCar::where("id", $id)
      ->whereIn('org_id', $org_ids)
      ->first();

    if ($parking_car == null) {
      // return response()->json(['message' => 'Auto no encontrado'], 404);
      abort(404, __('messa.parking_car_not_found'));
    }
// include contacts
    $parking_car->contacts;

    return response()->json($parking_car);
  }

  public function create(Request $request) {

    $org_ids = auth()->user()->getOrgsByPermission("parking-car-insert");

    if (!in_array($request->get('org_id'), $org_ids)) {
      return response()->json(['message' => 'Permiso denegado'], 422);
    }

    $parking_car = ParkingCar::create([
      'org_id' => $request->get('org_id'),
      'plate_number' => $request->get('plate_number'),
      'brand' => $request->get('brand'),
      'model' => $request->get('model'),
      'color' => $request->get('color'),
    ]);

    if ($request->get('contacts')) {
      foreach ($request->get('contacts') as $contact) {

        $parking_car->contacts()->create([
          'name' => $contact['name'],
          'phone' => $contact['phone'],
        ]);
      }
    }

    return ['success' => __('messa.parking_car_create')];
  }

  public function update(Request $request, $id) {
    $org_ids = auth()->user()->getOrgsByPermission("parking-car-update");

    $parking_car = ParkingCar::find($id);
    if (!in_array($parking_car->org_id, $org_ids)) {
      return response()->json(['message' => 'Permiso denegado'], 422);
    }

    // $parking_car->org_id = $request->get('org_id');
    $parking_car->plate_number = $request->get('plate_number');
    $parking_car->brand = $request->get('brand');
    $parking_car->model = $request->get('model');
    $parking_car->color = $request->get('color');
    $parking_car->save();

    if ($request->get('contacts')) {
// get all contacts if not in delete
      $contacts = $parking_car->contacts;
      foreach ($contacts as $contact) {
        $found = false;
        foreach ($request->get('contacts') as $c) {
          if ($c['id'] == $contact->id) {
            $found = true;
            break;
          }
        }
        if (!$found) {
          $contact->delete();
        }
      }

      // if contacts have parking_car_id, update else create
      foreach ($request->get('contacts') as $contact) {
        if (isset($contact['id'])) {
          $parking_car_contact = ParkingCarContact::find($contact['id']);
          $parking_car_contact->name = $contact['name'];
          $parking_car_contact->phone = $contact['phone'];
          $parking_car_contact->save();
        } else {
          $parking_car->contacts()->create([
            'name' => $contact['name'],
            'phone' => $contact['phone'],
          ]);
        }
      }

    }

    return ['success' => __('messa.parking_car_update')];
  }

  public function delete($id) {
    $parking_car = ParkingCar::find($id);
    $org_ids = auth()->user()->getOrgsByPermission("parking-car-delete");

    if (!in_array($parking_car->org_id, $org_ids)) {
      return response()->json(['message' => 'Permiso denegado'], 422);
    }

    // delete all contacts
    $parking_car->contacts()->delete();

    $parking_car->delete();
    return ['success' => __('messa.parking_car_delete')];
  }

}
