<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorProfile extends Model {
  use HasFactory;
  protected $fillable = [
    'investor_id',
    'status_id',
    'identification_type',
    'front_identification',
    'back_identification',
  ];
}
