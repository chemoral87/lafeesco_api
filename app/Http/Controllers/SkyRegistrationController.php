<?php

namespace App\Http\Controllers;

use App\Models\SkyParent;
use App\Models\SkyRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class SkyRegistrationController extends Controller {
  //
  public function create(Request $request) {
    $kids = $request->input("kids");
    $parents = $request->input("parents");

    Log::info($kids);
    Log::info($parents);

    $uuid = Uuid::uuid4()->toString();
    $shortened = base64_encode(hex2bin(str_replace('-', '', $uuid)));

    Log::info($shortened);

    // create qr code

    // create skyRegistration
    $registration = SkyRegistration::create([
      "uuid" => $uuid,
      "qr_path" => $shortened,
    ]);

    // create skyParent loop $parents
    foreach ($parents as $parent) {
      $skyParent = SkyParent::create([
        "sky_registration_id" => $registration->id,
        "name" => $parent["name"],
        "paternal_surname" => $parent["paternal_surname"],
        "maternal_surname" => $parent["maternal_surname"],
        "cellphone" => $parent["cellphone"],
        "email" => $parent["email"],
        "photo" => $parent["photo"],
      ]);
    }

  }
}
