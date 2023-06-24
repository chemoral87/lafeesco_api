<?php

namespace App\Models;

use App\Models\Ministry;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinistryLeader extends Model {
  use HasFactory;

  protected $fillable = [
    "user_id",
    "ministry_id",
  ];

  public function ministry() {
    return $this->belongsTo(Ministry::class);
  }

}
