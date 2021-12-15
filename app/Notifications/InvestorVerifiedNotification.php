<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InvestorVerifiedNotification extends Notification implements ShouldQueue {
  use Queueable;

  private $data;
  public function __construct() {
  }

  public function via($notifiable) {
    return ['mail'];
  }

  public function toMail($notifiable) {
    $FRONT_URL = env("FRONT_URL", "/");
    return (new MailMessage)
      ->subject("Cuenta verificada")
      ->line('Felicidades!!, su cuenta ha sido verificada.')
      ->line('De click al siguiente botón para ingresar con su correo y contraseña.')
      ->action('Login', url($FRONT_URL . '/login'))
    ;
  }

  public function toArray($notifiable) {
    return [
      //
    ];
  }
}
