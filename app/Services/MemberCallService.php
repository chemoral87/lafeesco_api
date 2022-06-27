<?php
namespace App\Services;

use App\Models\MemberCall;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MemberCallService {

  public function getNextCall($member_id, $call_type_id) {
    if ($call_type_id == 5) { // No Molestar
      return [
        "type_id" => null,
        "date" => null,
      ];
    }

    if ($call_type_id == 6 || $call_type_id == 7) {return null;}

    $calls_contacted = MemberCall::from("member_calls_v")
      ->where("was_contacted", 1)
      ->where("member_id", $member_id)
      ->orderBy("created_at", "DESC")
      ->get();

    $first = $calls_contacted->first();
    if ($first) {
      Log::info($first->created_at);
      Log::info($calls_contacted);
      $now = Carbon::parse($first->created_at)->timezone("America/Monterrey");
    } else {
      $now = Carbon::now()->timezone("America/Monterrey");
    }

    $call_welcome = $calls_contacted->first(function ($item) {return $item->call_type_id == 1;});
    if ($call_welcome == null) {
      return [
        "type_id" => 1, // bienvenida
        "date" => $now->addDay(1)->format("Y-m-d"),
      ];
    }

    $call_follow = $calls_contacted->first(function ($item) {return $item->call_type_id == 2;});
    if ($call_follow == null) {
      return [
        "type_id" => 2, // seguimiento
        "date" => $now->addDay(2)->format("Y-m-d"),
      ];
    }

    $call_connection = $calls_contacted->first(function ($item) {return $item->call_type_id == 3;});
    if ($call_connection == null) {
      return [
        "type_id" => 3, // conexion
        "date" => $now->addDay(2)->format("Y-m-d"),
      ];
    }

    $call_follow2 = $calls_contacted->first(function ($item) {return $item->call_type_id == 4;});
    if ($call_follow2 == null) {
      return [
        "type_id" => 4, // seguimiento2
        "date" => $now->addDay(5)->format("Y-m-d"),
      ];
    }

    // fin de llamadas
    return [
      "type_id" => null,
      "date" => null,
    ];

  }
}
