<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class InvestorVerificationNotification extends Notification {
  use Queueable;
  private $data;
  public function __construct($data) {
    $this->data = $data;
  }

  public function via($notifiable) {
    return ['mail'];
  }

  public function toMail($notifiable) {

    return (new MailMessage)
      ->subject("Código de Verificación")
      ->line(new HtmlString('Su codigo de validación es: <strong>' . $this->data['code'] . '</strong>'))
    ;
    // ->action('Notification Action', url('/'))
    // ->line('Thank you for using our application!');
  }

  public function toArray($notifiable) {
    return [
      'code' => $this->data['code'],
    ];
  }
}
