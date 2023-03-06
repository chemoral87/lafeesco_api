<?php

namespace App\Models;

use App\Models\Ministry;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
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
      $cacheKey = 'temporary-url-' . $value;
      $cacheTtl = 120; // in minutes
      // Check if the temporary URL is already cached
      if (Cache::has($cacheKey)) {
        return Cache::get($cacheKey);
      }
      //   return Storage::disk('s3')->temporaryUrl($value, Carbon::now()->addMinutes(cacheTtl));
      $temporaryUrl = Storage::disk('s3')->temporaryUrl($value, Carbon::now()->addMinutes($cacheTtl));
      Cache::put($cacheKey, $temporaryUrl, $cacheTtl);
      return $temporaryUrl;
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
