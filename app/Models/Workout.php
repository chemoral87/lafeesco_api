<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Workout extends Model {
  use HasFactory;

  protected $table = 'workout';

  protected $fillable = [
    'exercise_id',
    'repetitions',
    'unit',
    'weight',
    'workout_date',
    'notes',
    'created_by',
  ];

  /**
   * Get the exercise for this workout
   */
  public function exercise(): BelongsTo {
    return $this->belongsTo(Exercise::class);
  }

  /**
   * Get the user who created this workout
   */
  public function creator(): BelongsTo {
    return $this->belongsTo(User::class, 'created_by');
  }
}
