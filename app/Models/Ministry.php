<?php

namespace App\Models;

use App\Models\Attendant;
use App\Models\ChurchServiceMinistryAttendant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ministry extends Model {
  use HasFactory;

  protected $fillable = [
    'name',
    'order',
    'color',
  ];

  public function leaders() {
    return $this->belongsToMany(User::class, 'ministry_leaders', 'ministry_id', 'user_id');
  }

  // AQUI
  public function attendants() {
    return $this->belongsToMany(Attendant::class, 'church_service_attendant')
      ->withPivot('church_service_id', 'seq')
      ->using(ChurchServiceMinistryAttendant::class);
  }

}
