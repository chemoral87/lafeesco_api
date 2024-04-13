<?php

namespace App\Notifications;

use App\Channels\Messages\TwilioMessage;
use App\Channels\TwilioChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class FaithHouseMatchNotification extends Notification {
  use Queueable;

  private $contact;
  public function __construct($contact) {
    $this->contact = $contact;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable) {
    return [TwilioChannel::class];
  }

  public function toTwilio($notifiable) {
    $sid = env('TWILIO_SID');
    $token = env('TWILIO_TOKEN');
    $twilio = new Client($sid, $token);

    $template = 'Conexión QR. Nombre: {{name}}, Edad: {{age}} años, Domicilio: {{street_address}} {{house_number}}, Col. {{neighborhood}}, {{municipality}}, Estado Civil: {{marital_status}}, Teléfono: {{phone}}. Favor de contactar y dar informes de Horario y Domicilio';

    $text = str_replace([
      '{{name}}',
      '{{age}}',
      '{{street_address}}',
      '{{house_number}}',
      '{{neighborhood}}',
      '{{municipality}}',
      '{{marital_status}}',
      '{{phone}}',
    ], [
      $this->contact['name'],
      $this->contact['age'],
      $this->contact['street_address'],
      $this->contact['house_number'],
      $this->contact['neighborhood'],
      $this->contact['municipality'],
      $this->contact['marital_status'],
      $this->contact['phone'],
    ], $template);

    return (new TwilioMessage)
      ->content($text);
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable) {
    // return (new MailMessage)
    //             ->line('The introduction to the notification.')
    //             ->action('Notification Action', url('/'))
    //             ->line('Thank you for using our application!');
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toArray($notifiable) {
    return [
      //
    ];
  }
}
