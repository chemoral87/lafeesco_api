<?php

namespace App\Models;

use App\Models\Ministry;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Attendant extends Model implements AuditableContract {
  use HasFactory, Auditable;

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
    return awsUrlS3($value);
    // return temporaryUrlS3($value);
  }

  public function getRealPhotoAttribute() {
    return $this->attributes['photo'];
  }

  public function ministries() {
    // return $this->hasMany(Ministry::class, 'attendant_ministries', 'attendant_id', 'ministry_id');
    return $this->belongsToMany(Ministry::class, 'attendant_ministries', 'attendant_id', 'ministry_id');
  }

//   public function churchServices() {
//     return $this->belongsToMany(ChurchService::class, 'church_service_attendant')
//       ->using(ChurchServiceAttendant::class)
//       ->withPivot('ministry_id', 'seq');
//   }

}
