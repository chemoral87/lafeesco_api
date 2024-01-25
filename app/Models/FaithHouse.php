<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaithHouse extends Model {
  use HasFactory;

  protected $appends = [
    'neighborhood',
    'municipality',
  ];
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
    "end_date",
    "allow_matching",
    "lat",
    "lng",
  ];

  // protected $casts = [
  //   'allow_matching' => 'integer',
  // ];

  public function getHostPhotoAttribute($value) {
    return awsUrlS3($value, false);
    // return temporaryUrlS3($value);
  }

  public function getExhibitorPhotoAttribute($value) {
    return awsUrlS3($value, false);

  }

  public function getRealHostPhotoAttribute() {
    return $this->attributes['host_photo'];
  }

  public function getRealExhibitorPhotoAttribute() {
    return $this->attributes['exhibitor_photo'];
  }

  public function getNeighborhoodAttribute() {

    $address = explode(',', $this->address);
    if (count($address) > 1) {
      return trim($address[1]);
    } else {
      return "";
    }

  }

  public function getMunicipalityAttribute() {

    $address = explode(',', $this->address);
    if (count($address) > 2) {
      return trim($address[2]);
    } else {
      return "";
    }

  }

}
