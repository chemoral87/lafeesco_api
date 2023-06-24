<?php

namespace App\Models;

use App\Models\ChurchServiceMinistryAttendant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChurchService extends Model {
  use HasFactory;
  protected $fillable = [
    "event_date",
  ];

//   public function attendant() {
//     return $this->belongsToMany(Attendant::class, 'church_service_attendant', 'church_service_id', 'attendant_id');
//   }

//   public function ministry() {
//     return $this->belongsToMany(Ministry::class, 'church_service_attendant', 'church_service_id', 'ministry_id');
//   }

//   public function ministries() {
//     return $this->belongsToMany(Ministry::class, 'church_service_attendant')
//       ->withPivot('attendant_id', 'order')
//       ->using(ChurchServiceMinistryAttendant::class);
//   }

//   public function ministries() {
//     return $this->belongsToMany(Ministry::class, 'church_service_attendant')
//       ->using(ChurchServiceMinistryAttendant::class)
//       ->withPivot('attendant_id', 'seq');
//   }

  public function ministries() {
    return $this->belongsToMany(Ministry::class, 'church_service_attendant')
      ->using(ChurchServiceMinistryAttendant::class)
      ->withPivot('attendant_id', 'seq');
  }

//   public function attendants() {
//     return $this->belongsToMany(Attendant::class, 'church_service_attendant')
//       ->using(ChurchServiceMinistryAttendant::class)
//       ->withPivot('ministry_id', 'seq');
//   }

  public function church_service_attendant() {
    return $this->hasMany(ChurchServiceMinistryAttendant::class);
  }
}
