<?php

namespace App\Models;

use App\Models\Ministry;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attendant extends Model {
  use HasFactory;

  protected $fillable = [
    "name",
    "paternal_surname",
    "maternal_surname",
    "cellphone",
    "photo",
    "email",
    "birthdate",
  ];

  public function getPhotoAttribute($value) {
    if ($value) {
      return Storage::disk('s3')->temporaryUrl($value, Carbon::now()->addMinutes(20));
    }

    return "https://source.unsplash.com/96x96/daily";
  }

  public function getRealPhotoAttribute() {
    return $this->attributes['photo'];
  }

  public function ministries() {
    return $this->belongsToMany(Ministry::class, 'attendant_ministries', 'attendant_id', 'ministry_id');
  }

}
