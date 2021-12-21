<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestNotification extends Notification {
  use Queueable;

  private $testData;
  public function __construct($testData) {
    $this->testData = $testData;
  }

  public function via($notifiable) {
    return ['mail'];
  }

  public function toMail($notifiable) {
    return (new MailMessage)
      ->subject("Código de Verificación")
      ->greeting("tomasin")
      ->line('The introduction to the notification.')
      ->action('Notification Action', url('/login'))
      ->line('Thank you for using our application!');
  }

  public function toArray($notifiable) {
    // https://www.positronx.io/laravel-notification-example-create-notification-in-laravel/
    // https://stackoverflow.com/questions/28623001/how-to-keep-laravel-queue-system-running-on-server
    // https://www.codecheef.org/article/laravel-8-send-notification-via-laravel-queue-example
    // https://www.oulub.com/es-ES/Laravel/queues-supervisor-configuration
    return [
      'test' => $this->testData['test'],
    ];
  }
}
