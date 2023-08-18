<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkyRegistration extends Model {
  use HasFactory;
  protected $fillable = [
    'uuid',
    'qr_path',
  ];
}
