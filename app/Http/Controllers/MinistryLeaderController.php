<?php

namespace App\Http\Controllers;

use App\Models\MinistryLeader;
use Tymon\JWTAuth\Facades\JWTAuth;

class MinistryLeaderController extends Controller {

  public function my() {
    $userId = JWTAuth::user()->id;
    $ministry_leads = MinistryLeader::with(["ministry" => function ($query) {
      $query->select("id", "name", "order", "color");

    }])->where('user_id', $userId)->get();
    return $ministry_leads;
  }
}
