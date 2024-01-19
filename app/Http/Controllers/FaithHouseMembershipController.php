<?php

namespace App\Http\Controllers;

use App\Models\FaithHouseMembership;
use Illuminate\Http\Request;

class FaithHouseMembershipController extends Controller {

  public function create(Request $request) {

    $membership = FaithHouseMembership::create(
      [
        'name' => $request->get('name'),
        'age' => $request->get('age'),
        'phone' => $request->get('phone'),
        'street_address' => $request->get('street_address'),
        'house_number' => $request->get('house_number'),
        'neighborhood' => $request->get('neighborhood'),
        'municipality' => $request->get('municipality'),
      ]
    );

    return ['success' => __('messa.faith_house_membership_create')];
  }
}
