<?php

namespace App\Models;

use App\Models\Attendant;
use App\Models\Ministry;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ChurchServiceMinistryAttendant extends Pivot {
  protected $table = 'church_service_attendant';

  public function ministry() {
    return $this->belongsTo(Ministry::class);
  }

  public function attendant() {
    return $this->belongsTo(Attendant::class);
  }
}
