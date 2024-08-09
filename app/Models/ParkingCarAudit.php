<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingCarAudit extends Model {
  use HasFactory;

  protected $fillable = [
    'parking_car_id',
    'user_id',
    'action',
  ];
}
