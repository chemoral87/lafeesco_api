<?php
namespace App\Channels;

use Illuminate\Notifications\Notification;

class TwilioChannel {

  public function send($notifiable, Notification $notification) {
    $message = $notification->toTwilio($notifiable);

  }
}
