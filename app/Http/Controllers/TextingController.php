<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class TextingController extends Controller {
  public function create(Request $request) {
    $contacts = $request->input('contacts');

    $template = $request->input('text');
    $number = $request->input('number');

    $sid = env('TWILIO_SID');
    $token = env('TWILIO_TOKEN');
    $twilio = new Client($sid, $token);

    // for each contacts send a message
    foreach ($contacts as $contact) {
      $number = $contact['phone_number'];
      $name = $contact['name'];
      $text = str_replace('{{name}}', $name, $template);
      $message = $twilio->messages
        ->create('+52' . $number, // to
          array(
            "from" => env('TWILIO_PHONE_NUMBER'),
            "body" => $text,
          )
        );

      // $message = $twilio->messages
      //   ->create('whatsapp:+521' . $number, // to
      //     array(
      //       "from" => 'whatsapp:' . env('TWILIO_WHATSAPP_NUMBER'),
      //       "body" => $text,
      //     )
      //   );
    }

    return [
      'success' => "Notificaciones enviadas",

    ];
    // return $message->sid;
  }
}
