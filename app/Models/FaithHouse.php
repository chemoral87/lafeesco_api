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
    "exhibitor",
    "exhibitor_phone",
    "address",
    "schedule",
    "lat",
    "lng",
  ];
}
