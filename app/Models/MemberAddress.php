<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberAddress extends Model {
  use HasFactory;
  protected $fillable = [
    'municipality_id',
    'other_municipality',
    'street',
    'number',
    'suburn',
    'postal_code',
    'telephone',
  ];
}
