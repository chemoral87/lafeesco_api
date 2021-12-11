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
      ->greeting("tomasin")
      ->line('The introduction to the notification.')
      ->action('Notification Action', url('/login'))
      ->line('Thank you for using our application!');
  }

  public function toArray($notifiable) {
    // https://www.positronx.io/laravel-notification-example-create-notification-in-laravel/
    return [
      'test' => $this->testData['test'],
    ];
  }
}
