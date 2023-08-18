<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkyKid extends Model {
  use HasFactory;

  protected $fillable = [
    'sky_registration_id',
    'name',
    'paternal_surname',
    'maternal_surname',
    'birthdate',
    'allergies',
    'notes',
    'room',
  ];
}
