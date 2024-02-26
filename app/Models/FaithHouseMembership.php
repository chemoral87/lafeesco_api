<?php

namespace App\Models;

use App\Models\FaithHouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaithHouseMembership extends Model {
  use HasFactory;
  protected $fillable = [
    'name',
    'age',
    'phone',
    'marital_status',
    'source',
    'street_address',
    'house_number',
    'neighborhood',
    'municipality',
    'lat',
    'lng',
    'ip_address',
  ];

  public function faithHouses() {
    return $this->belongsToMany(FaithHouse::class, 'faith_house_membership_house', 'faith_house_membership_id', 'faith_house_id');
  }
}
