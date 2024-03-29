<?php

namespace App\Models;

use App\Models\Attendant;
use App\Models\ChurchServiceAttendant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChurchService extends Model {
  use HasFactory;
  protected $fillable = [
    "event_date",
  ];

  public function ministries() {
    return $this->belongsToMany(Ministry::class, 'church_service_attendant')
      ->using(ChurchServiceAttendant::class)
      ->select("ministries.id", "name", "order", "color")
      ->orderBy("order")
      ->distinct();
    //   ->withPivot('attendant_id', 'seq');
  }

  public function attendants() {
    return $this->belongsToMany(Attendant::class, 'church_service_attendant')
      ->withPivot('ministry_id', 'seq')
      ->select("attendants.id", "name", "paternal_surname", "photo")
      ->using(ChurchServiceAttendant::class)
      ->orderBy("seq");

    //   ->withPivot('attendant_id', 'seq');
  }

//   public function attendants() {
//     return $this->belongsToMany(Attendant::class, 'church_service_attendant')
//       ->using(ChurchServiceAttendant::class)
//       ->withPivot('ministry_id', 'seq');
//   }

  public function church_service_attendant() {
    return $this->hasMany(ChurchServiceAttendant::class);
  }
}
