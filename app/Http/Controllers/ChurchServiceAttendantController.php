<?php

namespace App\Http\Controllers;

use App\Models\ChurchServiceAttendant;
use Illuminate\Http\Request;

class ChurchServiceAttendantController extends Controller {
  public function update(Request $request) {
    $attendant_ids = $request->get("attendant_ids");
    // VALIDATION

    // INSERTION
    $church_service_id = $request->get("church_service_id");
    $ministry_id = $request->get("ministry_id");

    // DELETE REMOVED ATTENDANT
    $attendants = ChurchServiceAttendant::where('church_service_id', $church_service_id)
      ->where('ministry_id', $ministry_id)
    // ->whereNotIn("attendant_id", $attendant_ids)
      ->get();

    $attendants_assined = $attendants->pluck("attendant_id")->all();
    $attendants_to_insert = array_diff($attendant_ids, $attendants_assined);
    $attendants_to_delete = array_diff($attendants_assined, $attendant_ids);

// DELETE church services attendant
    foreach ($attendants_to_delete as $key => $attendant_id) {
      $attendant = ChurchServiceAttendant::where("attendant_id", $attendant_id)
        ->where("church_service_id", $church_service_id)
        ->where("ministry_id", $ministry_id)
        ->first();
      $attendant->delete();
    }

// INSERT church services attendant
    foreach ($attendants_to_insert as $key => $attendant_id) {
      $member = ChurchServiceAttendant::create([
        'church_service_id' => $church_service_id,
        'ministry_id' => $ministry_id,
        'attendant_id' => $attendant_id,
      ]);
    }

    //UPDATE seq church services attendant
    foreach ($attendants_to_insert as $key => $attendant_id) {
      ChurchServiceAttendant::where("attendant_id", $attendant_id)
        ->where("ministry_id", $ministry_id)
        ->where("church_service_id", $church_service_id)
        ->update(["seq" => $key]);

    }

    return [
      'success' => __('messa.church_service_attendant_create'),
      'attendants' => $attendants,
      'attendant_ids' => is_array($attendant_ids),
      'attendants_assined' => is_array($attendants_assined),
      'attendants_to_delete' => $attendants_to_delete,
      'attendants_to_insert' => $attendants_to_insert,
    ];
  }
}
