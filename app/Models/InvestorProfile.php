<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorProfile extends Model {
  use HasFactory;
  protected $fillable = [
    'investor_id',
    'status_id',
    'front_identification',
    'back_identification',
  ];
}
