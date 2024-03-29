<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkyRoom extends Model {
  use HasFactory;
  protected $fillable = [
    'name',
    'min_age',
    'max_age',
    'active',
  ];
}
