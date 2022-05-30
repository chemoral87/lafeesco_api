<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model {
  use HasFactory;

  protected $fillable = [
    'name',
    'paternal_surname',
    'maternal_surname',
    'cellphone',
    'marital_status_id',
    'category_id',
    'prayer_request',
    'created_by',
  ];
}
