<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class FaithHouseContact extends Model {
  use HasFactory, Notifiable;

  protected $fillable = [
    'faith_house_id',
    'name',
    'paternal_surname',
    'maternal_surname',
    'phone',
    'photo',
    'email',
    'role',
    'order',
  ];

  public function getPhotoAttribute($value) {
    return awsUrlS3($value, false);
  }

  public function getRealPhotoAttribute() {
    return $this->attributes['photo'];
  }

  public function routeNotificationForTwilio() {

// remve hypens from phone number
    $phone = str_replace('-', '', $this->phone);
    // Log::info('phone: ' . $phone);
    return $phone;
  }
}
