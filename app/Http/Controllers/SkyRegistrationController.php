<?php

namespace App\Http\Controllers;

use App\Models\SkyKid;
use App\Models\SkyParent;
use App\Models\SkyRegistration;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class SkyRegistrationController extends Controller {

  const PATH_S3 = "skykids/";
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

    $qrCode = QrCode::create($shortened)
      ->setSize(300)
      ->setMargin(10);

// Create a writer instance
    $writer = new PngWriter();

// Get QR code as string
    $qrCodeString = $writer->write($qrCode)->getString();

// Store the QR code string to S3
    // $path = 'qrcodes/qr-code.png'; // Modify this path as per your needs
    // Storage::disk('s3')->put($path, $qrCodeString, 'public');
    $qr_image = saveS3Blob($qrCodeString, self::PATH_S3);

    // create skyRegistration
    $registration = SkyRegistration::create([
      "uuid" => $uuid,
      "qr_path" => $qr_image,
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

    return [
      'success' => __('messa.sky_registration_create'),
      'qr_url' => awsUrlS3($qr_image),
    ];
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
