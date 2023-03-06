<?php

namespace App\Models;

use App\Models\Attendant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendantMinistry extends Model {
  use HasFactory;

  protected $fillable = [
    "attendant_id",
    "ministry_id",
  ];

  public function attendant() {
    return $this->belongsTo(Attendant::class, 'attendant_id', 'id');
  }
}
