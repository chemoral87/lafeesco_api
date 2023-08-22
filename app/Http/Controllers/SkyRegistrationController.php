<?php

namespace App\Http\Controllers;

use App\Models\SkyKid;
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

    // Prepare parent and kid data
    $parentData = [];
    $kidData = [];

    foreach ($parents as $parent) {
      $parentData[] = $this->prepareParentData($registration->id, $parent);
    }

    foreach ($kids as $kid) {
      $kidData[] = $this->prepareKidData($registration->id, $kid);
    }

    // Insert parent and kid data in a single batch
    SkyParent::insert($parentData);
    SkyKid::insert($kidData);

  }

  private function prepareParentData($registrationId, $parent) {
    return [
      'sky_registration_id' => $registrationId,
      'name' => $parent['name'],
      'paternal_surname' => $parent['paternal_surname'],
      'maternal_surname' => $parent['maternal_surname'],
      'cellphone' => $parent['cellphone'],
      'email' => $parent['email'],
      'photo' => $parent['photo'],
    ];
  }

  private function prepareKidData($registrationId, $kid) {
    return [
      'sky_registration_id' => $registrationId,
      'name' => $kid['name'],
      'paternal_surname' => $kid['paternal_surname'],
      'maternal_surname' => $kid['maternal_surname'],
      'birthdate' => $kid['birthdate'],
      'allergies' => $kid['allergies'],
      'notes' => $kid['notes'],
      'room' => $kid['room'],
    ];
  }
}
