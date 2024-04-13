<?php
namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class TwilioChannel {

  public function send($notifiable, Notification $notification) {
    $message = $notification->toTwilio($notifiable);

    $to = $notifiable->routeNotificationFor('Twilio');
    
    $from = config('services.twilio.from');

    $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));

    return $twilio->messages->create(
      '+52' . $to,
      [
        "from" => $from,
        "body" => $message->content,
      ]);
  }
}
