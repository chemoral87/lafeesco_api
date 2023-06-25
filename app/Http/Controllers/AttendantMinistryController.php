<?php

namespace App\Http\Controllers;

use App\Models\AttendantMinistry;
use Illuminate\Http\Request;

class AttendantMinistryController extends Controller {

  public function filter(Request $request) {
    $filter = $request->queryText;
    $ids = isset($request->ids) ? $request->ids : [];
    $ministry_id = $request->ministry_id;
    $attendants = AttendantMinistry::with(["attendant" => function ($query) {
      $query->select("id", "name", "paternal_surname", "photo");
    }])
      ->whereNotIn("id", $ids)
      ->where('ministry_id', $ministry_id)
      ->whereHas('attendant', function ($query) use ($filter) {
        $query->where("name", "like", "%" . $filter . "%");
      })
      ->get()
      ->pluck('attendant')
      ->toArray();
    return $attendants;
    //   ->whereNotIn("id", $ids)
    //   ->where("name", "like", "%" . $filter . "%")
    //   ->orderBy("name")->paginate(7);

    // return $attendants->items();
  }

}
