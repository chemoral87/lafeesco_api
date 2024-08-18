<?php

namespace App\Http\Controllers;

use App\Models\ParkingCar;
use Illuminate\Http\Request;

class ParkingCarContactController extends Controller {
  public function index(Request $request, $parking_car_id) {

    $parking_car = ParkingCar::find($parking_car_id);

    $contacts = $parking_car->contacts();

    // write parking car audit
    $parking_car->auditions()->create([
      'user_id' => $request->user()->id,
      'action' => 'view_contacts',
    ]);

    return $contacts->get();
  }

}
