<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvestorProfileResource;
use App\Models\InvestorProfile;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class InvestorProfileController extends Controller {
  public function myIndex(Request $request) {
    $id = JWTAuth::user()->id;
    $investorProfile = InvestorProfile::where("investor_id", $id)->first();
    return new InvestorProfileResource($investorProfile);
    // return InvestorProfileResource::collection($investorProfile);
  }

  public function myUpdate(Request $request) {
    // InvestorProfile::find()
    $id = JWTAuth::user()->id;
    $investorProfile = InvestorProfile::where("investor_id", $id)->first();
    $patu = "";
    if ($request->has("front_identification") && $request->front_identification != "null") {
      $full_name = saveAmazonFile($request->file("front_identification"), "/investor/id$id", $investorProfile->front_identification);
      $investorProfile->front_identification = $full_name;
      $investorProfile->save();
      // if ($investorProfile->front_identification != null) {
      //   $patu = Storage::disk('s3')->temporaryUrl($investorProfile->front_identification, Carbon::now()->addMinute(120));
      // }

    }

    return [
      'success' => __('messa.investor_profile_update'),
      'data' => new InvestorProfileResource($investorProfile), //$patu,
    ];
  }
}
