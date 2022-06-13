<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataSetResource;
use App\Models\Member;
use App\Models\MemberCall;
use App\Models\MemberCallType;
use App\Services\MemberCallService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class MemberCallController extends Controller {

  protected $callService;

  public function __construct(MemberCallService $callService) {
    $this->callService = $callService;
  }
  //
  public function indexByMember($id, Request $request) {

    $query = MemberCall::query()->from("member_calls_v")->where("member_id", $id);

    $itemsPerPage = $request->itemsPerPage;
    $sortBy = $request->get('sortBy');
    $sortDesc = $request->get('sortDesc');
    $filter = $request->get("filter");

    foreach ($request->get('sortBy') as $index => $column) {
      $sortDirection = ($sortDesc[$index] == 'true') ? 'DESC' : 'ASC';
      $query = $query->orderBy($column, $sortDirection);
    }

    $calls = $query->paginate($itemsPerPage);
    return new DataSetResource($calls);
  }

  public function create(Request $request) {
    $user_id = JWTAuth::user()->id;
    $member_id = $request->input('member_id');
    $call_type_id = $request->input('call_type_id');
    $address = MemberCall::create([
      'member_id' => $member_id,
      'call_type_id' => $request->input('call_type_id'),
      'comments' => $request->input('comments'),
      'created_by' => $user_id,
    ]);

    // update next call
    $next_call = $this->callService->getNextCall($member_id, $call_type_id);
    Log::info($next_call);
    if ($next_call) {
      $member = Member::where("id", $member_id)->first();
      $member->next_call_type_id = $next_call["type_id"];
      $member->next_call_date = $next_call["date"];
      $member->save();
    }

    return ['success' => __('messa.member_call_create')];
  }

  public function callTypes() {
    return MemberCallType::all();
  }
}
