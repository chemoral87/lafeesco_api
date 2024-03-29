<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataSetResource;
use App\Models\MaritalStatus;
use App\Models\Member;
use App\Models\MemberCategory;
use App\Models\MemberSource;
use App\Services\MessagingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class MemberController extends Controller {

  private $messagingService;

  public function __construct(MessagingService $messagingService) {
    $this->messagingService = $messagingService;
  }

  public function create(Request $request) {
    $userId = JWTAuth::user()->id;
    $birthday = $request->get('birthday') ? \Carbon\Carbon::parse($request->get('birthday')) : null;

    $call_type_id = 1; // Bienvenida
    $next_call_date = Carbon::now()->timezone("America/Monterrey")->addDay(1);

    $member = Member::create([
      'name' => Str::title($request->get('name')),
      'paternal_surname' => Str::title($request->get('paternal_surname')),
      'maternal_surname' => Str::title($request->get('maternal_surname')),
      'birthday' => $birthday,
      'cellphone' => $request->get('cellphone'),
      'marital_status_id' => $request->get('marital_status_id'),
      'category_id' => $request->get('category_id'),
      'source_id' => $request->get('source_id'),
      'prayer_request' => $request->get('prayer_request'),
      'next_call_type_id' => $call_type_id,
      'next_call_date' => $next_call_date,
      'created_by' => $userId,
    ]);

    // Use the client to do fun stuff like send text messages!
    $cellphone = $request->get('cellphone');
    $name = Str::title($request->get('name')) . " " . Str::title($request->get('paternal_surname'));

    $this->messagingService->sendSMS($cellphone, ['type' => MessagingService::WELCOME, 'name' => $name]);
    // https://console.twilio.com/us1/develop/sms/try-it-out/send-an-sms?frameUrl=%2Fconsole%2Fsms%2Fget-setup%3Fx-target-region%3Dus1&currentFrameUrl=%2Fconsole%2Fsms%2Fgetting-started%2Fbuild%3F__override_layout__%3Dembed%26bifrost%3Dtrue%26x-target-region%3Dus1
    // https://www.twilio.com/docs/libraries/php
    // send sms

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
      $query->where(DB::raw("CONCAT(name,' ',paternal_surname, ' ',maternal_surname )"), "like", "%" . $filter . "%");
    }

    $members = $query->paginate($itemsPerPage);
    return new DataSetResource($members);

  }

  public function show($id) {
    // Member::findOrFail($id);

    $member = Member::from("members_v")->where("id", $id)->first();
    if ($member == null) {
      abort(405, 'Page not found');
    }

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
      'source_id' => $request->get('source_id'),
      'prayer_request' => $request->get('prayer_request'),
      'next_call_date' => $request->get('next_call_date'),
    ]);

    return [
      'success' => __('messa.member_update'),
    ];
  }

  public function toCall(Request $request) {
    $now = Carbon::now()->timezone("America/Monterrey")->format("Y-m-d");

    $query = Member::query()->from("members_v")
      ->whereNotNull("next_call_date")
      ->whereNotNull("address_id")
      ->where(DB::raw("6"), "<=", DB::raw("LENGTH(REPLACE(cellphone,'-',''))"))
      ->where("next_call_date", "<=", $now)
    ;

    $itemsPerPage = $request->itemsPerPage;
    $sortBy = $request->get('sortBy');
    $sortDesc = $request->get('sortDesc');
    $filter = $request->get("filter");

    foreach ($request->get('sortBy') as $index => $column) {
      $sortDirection = ($sortDesc[$index] == 'true') ? 'DESC' : 'ASC';
      $query = $query->orderBy($column, $sortDirection);
    }
    if ($filter) {
      $query->where(DB::raw("CONCAT(name,' ',paternal_surname, ' ',maternal_surname )"), "like", "%" . $filter . "%");
    }

    $members = $query->paginate($itemsPerPage);
    return new DataSetResource($members);
  }

  public function delete($id) {
    Member::find($id)->delete();
    return ['success' => __('messa.member_delete')];
  }

  public function getMaritalStatuses() {
    return MaritalStatus::select("id", "name")->orderBy("name")->get();
  }

  public function getMemberCategories() {
    return MemberCategory::select("id", "name")->orderBy("name")->get();
  }

  public function getMemberSources() {
    return MemberSource::select("id", "name")->orderBy("order")->get();
  }

}
