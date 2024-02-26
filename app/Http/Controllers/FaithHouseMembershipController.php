<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataSetResource;
use App\Models\FaithHouse;
use App\Models\FaithHouseMembership;
use Illuminate\Http\Request;

class FaithHouseMembershipController extends Controller {

  public function index(Request $request) {
    // with faith_houses
    // $query = FaithHouseMembership::with('faithHouses');

    $query = queryServerSide($request, FaithHouseMembership::with('faithHouses'));

    $filter = $request->get("filter");
    if ($filter) {
      $query->where(function ($query) use ($filter) {
        $query->where("name", "like", "%" . $filter . "%");
        // ->orWhere("name", "like", "%" . $filter . "%")
        // ->orWhere("host", "like", "%" . $filter . "%");
      });

    }

    $faith_house_memberships = $query->paginate($request->get('itemsPerPage'));

    return new DataSetResource($faith_house_memberships);
  }

  public function create(Request $request) {

    $lat = $request->get('lat');
    $lng = $request->get('lng');
    // save ip address in a variable
    $ip_address = $request->ip();

    // get the 2 nearest faith house  where distance is less than 20 meters
    $faithHouses = FaithHouse::selectRaw(
      '*, ( 3959 * acos( cos( radians(?) ) *
      cos( radians( lat ) )
      * cos( radians( lng ) - radians(?)
      ) + sin( radians(?) ) *
      sin( radians( lat ) ) )
      ) AS distance', [$lat, $lng, $lat]
    )
      ->having('distance', '<', 3.5) // 4 kilometers
      ->whereNull('end_date')
      ->where('allow_matching', 1)
    // where end_date is null or end_date is greater than today
    // ->where(function ($query) {
    //   $query->whereNull('end_date')
    //     ->orWhere('end_date', '>', date('Y-m-d'));
    // })
      ->orderBy('distance')
      ->limit(2)
      ->get();

    // hide  from  $faithHouses
    $faithHouses->makeHidden('exhibitor_phone');
    $faithHouses->makeHidden('host_phone');
    $faithHouses->makeHidden('address');

    $membership = FaithHouseMembership::create([
      'name' => $request->get('name'),
      'age' => $request->get('age'),
      'phone' => $request->get('phone'),
      'marital_status' => $request->get('marital_status'),
      'source' => $request->get('source'),

      'street_address' => $request->get('street_address'),
      'house_number' => $request->get('house_number'),
      'neighborhood' => $request->get('neighborhood'),
      'municipality' => $request->get('municipality'),
      'lat' => $lat,
      'lng' => $lng,
      'ip_address' => $ip_address,
    ]);

    // insert $faithHouses into faith_house_membership_house table
    $membership->faithHouses()->attach($faithHouses->pluck('id'));

    return ['success' => __('messa.faith_house_membership_create'), 'match' => $faithHouses];
  }
}
