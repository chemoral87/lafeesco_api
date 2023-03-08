<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinistryLeader extends Model {
  use HasFactory;

  protected $fillable = [
    "user_id",
    "ministry_id",
  ];

}
