<?php

namespace App\Models;

use App\Models\Investment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model {
  use HasFactory;

  public function statusable() {
    return $this->morphTo();
  }

  public function investment() {
    return $this->belongsTo(Investment::class);
  }
}
