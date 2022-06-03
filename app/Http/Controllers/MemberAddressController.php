<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberAddress;
use Illuminate\Http\Request;

class MemberAddressController extends Controller {
  public function create(Request $request) {
    $member_ids = $request->get("member_ids");

    $address = MemberAddress::create([
      'municipality_id' => $request->input('municipality_id'),
      'other_municipality' => $request->input('other_municipality'),
      'street' => $request->input('street'),
      'number' => $request->input('number'),
      'suburn' => $request->input('suburn'),
      'postal_code' => $request->input('postal_code'),
      'telephone' => $request->input('telephone'),

    ]);
    Member::whereIn("id", $member_ids)->update(["address_id" => $address->id]);

    return ['success' => __('messa.member_address_create')];
  }
}
