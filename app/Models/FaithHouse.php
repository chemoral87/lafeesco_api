<?php

namespace App\Models;

use App\Models\FaithHouseContact;
use App\Models\FaithHouseMembership;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaithHouse extends Model {
  use HasFactory;

  protected $appends = [
    'neighborhood',
    'municipality',
    'org_name',
  ];
  protected $fillable = [
    "name",

    "address",
    "schedule",
    "end_date",
    "allow_matching",
    "lat",
    "lng",
    "order",
    'org_id',
  ];

  public function getNeighborhoodAttribute() {

    $address = explode(',', $this->address);
    if (count($address) > 1) {
      return trim($address[1]);
    } else {
      return "";
    }

  }

  public function getOrgNameAttribute() {
    return $this->organization->short_code;
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

  public function organization() {
    return $this->belongsTo(Organization::class, 'org_id', 'id');

  }

}
