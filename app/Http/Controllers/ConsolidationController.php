<?php

namespace App\Http\Controllers;

use App\Models\MaritalStatus;
use App\Models\MemberCategory;
use Illuminate\Http\Request;

class ConsolidationController extends Controller {
  public function initialCatalog(Request $request) {
    $marital_statuses = MaritalStatus::select("id", "name")->orderBy("name")->get();
    $member_categories = MemberCategory::select("id", "name")->orderBy("name")->get();

    return [
      "marital_statuses" => $marital_statuses,
      "member_groups" => $member_categories,
    ];
  }
}
