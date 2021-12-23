<?php

namespace App\Http\Controllers;

use App\Models\User;

class TestController extends Controller {
  public function test() {

    $userSchema = User::first();

    $offerData = [
      'test' => "okis",
      'name' => 'BOGO',
      'body' => 'You received an offer.',
      'thanks' => 'Thank you',
      'offerText' => 'Check out the offer',
      'offerUrl' => url('/'),
      'offer_id' => 007,
    ];

    // Notification::send($userSchema, new TestNotification($offerData));

    return "ok test - " . date("d  Y h:i:s A");
  }
}
