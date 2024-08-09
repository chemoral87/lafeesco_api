<?php

namespace App\Models;

use App\Models\ParkingCarAudit;
use App\Models\ParkingCarContact;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingCar extends Model {
  use HasFactory;

  protected $fillable = [
    'org_id',
    'plate_number',
    'brand',
    'model',
    'color',

  ];

  public function contacts() {
    return $this->hasMany(ParkingCarContact::class);
  }

  public function audits() {
    return $this->hasMany(ParkingCarAudit::class);
  }
}
