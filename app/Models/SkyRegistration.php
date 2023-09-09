<?php

namespace App\Models;

use App\Models\SkyKid;
use App\Models\SkyParent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkyRegistration extends Model {
  use HasFactory;
  protected $fillable = [
    'uuid',
    'qr_path',
  ];

  public function kids() {
    return $this->hasMany(SkyKid::class);
  }

  public function parents() {
    return $this->hasMany(SkyParent::class);
  }
}
