<?php

namespace App\Models;

use App\Models\Investment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Investor extends User {
  use HasFactory;

  public function investments() {
    return $this->hasMany(Investment::class);
  }

}
