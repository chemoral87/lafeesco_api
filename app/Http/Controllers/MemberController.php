<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataSetResource;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class MemberController extends Controller {
  public function create(Request $request) {
    $userId = JWTAuth::user()->id;
    $birthday = $request->get('birthday') ? \Carbon\Carbon::parse($request->get('birthday')) : null;
    $member = Member::create([
      'name' => Str::title($request->get('name')),
      'paternal_surname' => Str::title($request->get('paternal_surname')),
      'maternal_surname' => Str::title($request->get('maternal_surname')),
      'birthday' => $birthday,
      'cellphone' => $request->get('cellphone'),
      'marital_status_id' => $request->get('marital_status_id'),
      'category_id' => $request->get('category_id'),
      'prayer_request' => $request->get('prayer_request'),
      'created_by' => $userId,
    ]);

    return ['success' => __('messa.member_create')];
  }

  public function myNoAddress() {
    $userId = JWTAuth::user()->id;
    $members = Member::from("members_v")
      ->where("created_by", $userId)
      ->whereNull("address_id")
      ->get();

    return [
      'members' => $members,
    ];
  }

  public function my(Request $request) {
    $userId = JWTAuth::user()->id;
    // $members = Member::from("members_v")
    //   ->where("created_by", $userId)
    //   ->whereNotNull("address_id")
    //   ->get();

    $query = Member::query()->from("members_v")
      ->where("created_by", $userId)
      ->whereNotNull("address_id");
    $itemsPerPage = $request->itemsPerPage;
    $sortBy = $request->get('sortBy');
    $sortDesc = $request->get('sortDesc');
    $filter = $request->get("filter");

    foreach ($request->get('sortBy') as $index => $column) {
      $sortDirection = ($sortDesc[$index] == 'true') ? 'DESC' : 'ASC';
      $query = $query->orderBy($column, $sortDirection);
    }
    if ($filter) {
      $query->where("name", "like", "%" . $filter . "%");
    }

    $members = $query->paginate($itemsPerPage);
    return new DataSetResource($members);

  }

  public function show($id) {
    $member = Member::from("members_v")->where("id", $id)->first();
    return response()->json($member);
  }

  public function update(Request $request, $id) {
    $birthday = $request->get('birthday') ? \Carbon\Carbon::parse($request->get('birthday')) : null;
    $member = Member::where("id", $id)->update([
      'name' => Str::title($request->get('name')),
      'paternal_surname' => Str::title($request->get('paternal_surname')),
      'maternal_surname' => Str::title($request->get('maternal_surname')),
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
