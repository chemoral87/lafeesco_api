<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class TextingController extends Controller {
  public function insert(Request $request) {
// receive text and number to send a text in twilio
    $request->validate([
      'text' => 'required',
      'number' => 'required',
    ]);

    $text = $request->input('text');
    $number = $request->input('number');

    $sid = env('TWILIO_ACCOUNT_SID');
    $token = env('TWILIO_AUTH_TOKEN');
    $twilio = new Client($sid, $token);

    $message = $twilio->messages
      ->create($number, // to
        array(
          "from" => env('TWILIO_NUMBER'),
          "body" => $text,
        )
      );

    return $message->sid;
  }
}
