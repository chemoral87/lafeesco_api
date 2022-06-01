<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class MemberController extends Controller {
  public function create(Request $request) {
    $userId = JWTAuth::user()->id;
    $birthday = $request->get('birthday') ? \Carbon\Carbon::parse($request->get('birthday')) : null;
    $member = Member::create([
      'name' => Str::ucfirst($request->get('name')),
      'paternal_surname' => Str::ucfirst($request->get('paternal_surname')),
      'maternal_surname' => Str::ucfirst($request->get('maternal_surname')),
      'birthday' => $birthday,
      'cellphone' => $request->get('cellphone'),
      'marital_status_id' => $request->get('marital_status_id'),
      'category_id' => $request->get('category_id'),
      'prayer_request' => $request->get('prayer_request'),
      'created_by' => $userId,
    ]);

    return ['success' => __('messa.member_create')];
  }

  public function myMembersNoAddress() {
    $userId = JWTAuth::user()->id;
    Log::info($userId);
    $members = Member::from("members_v")
      ->where("created_by", $userId)
      ->get();

    return [
      'members' => $members,
    ];
  }

  public function show($id) {
    $member = Member::from("members_v")->where("id", $id)->first();
    return response()->json($member);
  }

  public function update(Request $request, $id) {
    $birthday = $request->get('birthday') ? \Carbon\Carbon::parse($request->get('birthday')) : null;
    $member = Member::where("id", $id)->update([
      'name' => Str::ucfirst($request->get('name')),
      'paternal_surname' => Str::ucfirst($request->get('paternal_surname')),
      'maternal_surname' => Str::ucfirst($request->get('maternal_surname')),
      'birthday' => $birthday,
      'cellphone' => $request->get('cellphone'),
      'marital_status_id' => $request->get('marital_status_id'),
      'category_id' => $request->get('category_id'),
      'prayer_request' => $request->get('prayer_request'),
    ]);

    return [
      'success' => __('messa.member_update'),
    ];
  }

  public function delete($id) {
    Member::find($id)->delete();
    return ['success' => __('messa.member_delete')];
  }
}
