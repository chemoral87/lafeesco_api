<?php
namespace App\Services;

use Illuminate\Support\Str;
use Twilio\Rest\Client;

// https: //stackoverflow.com/questions/72826338/how-to-bind-env-values-in-laravel-service-using-service-container-and-service-p
class MessagingService {

  public const WELCOME = "welcome";

  protected $sid;
  protected $token;
  protected $messaging_service_sid;

  public function __construct() {
    $this->sid = config('services.twilio.sid');
    $this->token = config('services.twilio.token');
    $this->messaging_service_sid = config('services.twilio.messaging_service_sid');
  }

  public function sendSMS($cellphone, $params) {

    $client = new Client($this->sid, $this->token);
    $validation = $this->validatePhoneNumber($cellphone);

    if ($validation->valid) {

      try {
        $client->messages->create(
          // the number you'd like to send the message to
          $validation->cellphone,
          array(
            "messagingServiceSid" => $this->messaging_service_sid,
            "body" => "hola tomasin",
          )
        );
      } catch (Exception $e) {}
    }
  }

  private function validatePhoneNumber($cellphone) {
    $number = preg_replace("/[^0-9]/", "", $cellphone);

    if (Str::length($number) == 10) {
      return (object) ['valid' => true, 'cellphone' => '+52' . $number];
    } else {
      return (object) ['valid' => false, 'cellphone' => null];
    }
  }

}
