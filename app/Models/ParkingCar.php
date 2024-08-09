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

  // ALWAys save plate_number in uppercase
  public function setPlateNumberAttribute($value) {
    $this->attributes['plate_number'] = strtoupper($value);
  }

  public function setBrandAttribute($value) {
    $this->attributes['brand'] = ucwords($value);
  }

  public function setModelAttribute($value) {
    $this->attributes['model'] = ucwords($value);
  }

  public function contacts() {
    return $this->hasMany(ParkingCarContact::class);
  }

  public function audits() {
    return $this->hasMany(ParkingCarAudit::class);
  }
}
