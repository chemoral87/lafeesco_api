<?php

namespace App\Http\Controllers;

use App\Models\ChurchServiceAttendant;
use Illuminate\Http\Request;

class ChurchServiceAttendantController extends Controller {
  public function update(Request $request) {
    $attendant_ids = $request->get("attendant_ids");
    $church_service_id = $request->get("church_service_id");
    $ministry_id = $request->get("ministry_id");
    // VALIDATION

    $attendants = ChurchServiceAttendant::where('church_service_id', $church_service_id)
      ->where('ministry_id', $ministry_id)
      ->get();

    $attendants_assined = $attendants->pluck("attendant_id")->all();
    $attendants_to_insert = array_diff($attendant_ids, $attendants_assined);
    $attendants_to_delete = array_diff($attendants_assined, $attendant_ids);
    $attendants_to_update = array_diff($attendants_assined, $attendants_to_insert);

    // INSERT church services attendant
    $newMembers = [];
    foreach ($attendants_to_insert as $key => $attendant_id) {
      $newMembers[] = [
        'church_service_id' => $church_service_id,
        'ministry_id' => $ministry_id,
        'attendant_id' => $attendant_id,
        "seq" => array_search($attendant_id, $attendant_ids) + 1,
      ];
    }
    ChurchServiceAttendant::insert($newMembers);

    // DELETE church services attendant
    ChurchServiceAttendant::whereNotIn("attendant_id", $attendant_ids)
      ->where("church_service_id", $church_service_id)
      ->where("ministry_id", $ministry_id)
      ->delete();

    //UPDATE seq church services attendant
    foreach ($attendants_to_update as $key => $attendant_id) {
      ChurchServiceAttendant::where("attendant_id", $attendant_id)
        ->where("ministry_id", $ministry_id)
        ->where("church_service_id", $church_service_id)
        ->update(["seq" => array_search($attendant_id, $attendant_ids) + 1]);
    }

    return [
      'success' => __('messa.church_service_attendant_create'),
    ];
  }
}
