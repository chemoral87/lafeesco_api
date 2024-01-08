<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaithHouse extends Model {
  use HasFactory;

  protected $fillable = [
    "name",
    "host",
    "host_phone",
    "host_photo",
    "exhibitor",
    "exhibitor_phone",
    "exhibitor_photo",
    "address",
    "schedule",
    "lat",
    "lng",
  ];

  public function getHostPhotoAttribute($value) {
    return awsUrlS3($value);
    // return temporaryUrlS3($value);
  }

  public function getExhibitorPhotoAttribute($value) {
    return awsUrlS3($value);
    // return temporaryUrlS3($value);
  }

  public function getRealHostPhotoAttribute() {
    return $this->attributes['host_photo'];
  }

  public function getRealExhibitorPhotoAttribute() {
    return $this->attributes['exhibitor_photo'];
  }
}
