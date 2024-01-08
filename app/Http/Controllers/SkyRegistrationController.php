<?php

namespace App\Http\Controllers;

use App\Models\SkyKid;
use App\Models\SkyParent;
use App\Models\SkyRegistration;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Ramsey\Uuid\Uuid;

class SkyRegistrationController extends Controller {

  const PATH_S3 = "skykids/";

  public function show(Request $request, $id) {
    $shortened_uuid = $id;
    $sky_uuid = decodeUUID($shortened_uuid);

    $registration = SkyRegistration::with('kids', 'parents')
    // ->select("uuid")
      ->where('uuid', $sky_uuid)->first();
    return $registration;
  }
  //
  public function create(Request $request) {
    $kids = $request->input("kids");
    $parents = $request->input("parents");

    $legal_parent = strtoupper(substr($parents[0]['name'] . ' ' . $parents[0]['paternal_surname'], 0, 30));

    $uuid = Uuid::uuid4()->toString();
    $shortened = encodeUUID($uuid);

    $qrCode = QrCode::create($shortened)
      ->setSize(300)
      ->setMargin(20);

    $logo = Logo::create(public_path('images/logo.jpg'))
      ->setResizeToWidth(40)
      ->setPunchoutBackground(true);

// Create a writer instance
    $writer = new PngWriter();

// Get QR code as string
    $qrCodeString = $writer->write($qrCode, $logo)->getString();

    // ADD additional label

    $image = Image::make($qrCodeString);

// Add a label on top with red letters
    $labelText = 'SKY KIDS  La Fe Escobedo';
    $image->text($labelText, $image->width() / 2, 2, function ($font) {
      $font->file(public_path('fonts/Roboto-Regular.ttf')); // Path to a TTF font file
      $font->size(18); // Font size
      // color blue
      $font->color('#0000ff'); // Blue color

      $font->align('center'); // Horizontal alignment
      $font->valign('top'); // Vertical alignment
    });

    $image->text($legal_parent, $image->width() / 2, 324, function ($font) {
      $font->file(public_path('fonts/Roboto-Regular.ttf')); // Path to a TTF font file
      $font->size(16); // Font size
      // color blue
      $font->color('#0000ff'); // Blue color

      $font->align('center'); // Horizontal alignment
      $font->valign('top'); // Vertical alignment
    });

// Convert image back to string
    $modifiedQrCodeString = (string) $image->encode('png');

    // DEBUG only
    // $qr_image = saveBlob($modifiedQrCodeString, self::PATH_S3);
    $qr_image = saveS3Blob($modifiedQrCodeString, self::PATH_S3);

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
