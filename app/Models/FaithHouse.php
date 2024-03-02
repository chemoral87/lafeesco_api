<?php

namespace App\Models;

use App\Models\FaithHouseContact;
use App\Models\FaithHouseMembership;
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
    "order",
  ];

  // protected $casts = [
  //   'allow_matching' => 'integer',
  // ];

  public function getHostPhotoAttribute($value) {
    return awsUrlS3($value, false);
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

  public function faithMemberships() {
    return $this->belongsToMany(FaithHouseMembership::class, 'faith_house_membership_house', 'faith_house_id', 'faith_house_membership_id');
  }

  public function contacts() {
    // order by order column in ascending order
    return $this->hasMany(FaithHouseContact::class)->orderBy('order');
    // return $this->hasMany(FaithHouseContact::class);
  }

}
