<?php

namespace App\Http\Controllers;

use App\Models\FaithHouse;
use App\Models\FaithHouseMembership;
use Illuminate\Http\Request;

class FaithHouseMembershipController extends Controller {

  public function create(Request $request) {

    $lat = $request->get('lat');
    $lng = $request->get('lng');
    // save ip address in a variable
    $ip_address = $request->ip();

    // get the 2 nearest faith house
    $faithHouses = FaithHouse::selectRaw(
      '*, ( 3959 * acos( cos( radians(?) ) *
      cos( radians( lat ) )
      * cos( radians( lng ) - radians(?)
      ) + sin( radians(?) ) *
      sin( radians( lat ) ) )
      ) AS distance', [$lat, $lng, $lat]
    )
      ->having('distance', '<', 20)
      ->whereNull('end_date')
    // where allow_new_members is true
      ->where('allow_matching', 1)
    // where end_date is null or end_date is greater than today
    // ->where(function ($query) {
    //   $query->whereNull('end_date')
    //     ->orWhere('end_date', '>', date('Y-m-d'));
    // })
      ->orderBy('distance')
      ->limit(2)
      ->get();

    $membership = FaithHouseMembership::create(
      [
        'name' => $request->get('name'),
        'age' => $request->get('age'),
        'phone' => $request->get('phone'),
        'street_address' => $request->get('street_address'),
        'house_number' => $request->get('house_number'),
        'neighborhood' => $request->get('neighborhood'),
        'municipality' => $request->get('municipality'),
        'lat' => $lat,
        'lng' => $lng,
        'ip_address' => $ip_address,
      ]
    );

    return ['success' => __('messa.faith_house_membership_create'), 'match' => $faithHouses];
  }
}
