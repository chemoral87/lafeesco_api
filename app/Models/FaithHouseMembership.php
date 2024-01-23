<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaithHouseMembership extends Model {
  use HasFactory;
  protected $fillable = [
    'name',
    'age',
    'phone',
    'street_address',
    'house_number',
    'neighborhood',
    'municipality',
    'lat',
    'lng',
    'ip_address',
  ];
}
