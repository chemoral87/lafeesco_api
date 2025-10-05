<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exercise extends Model {
  use HasFactory;

  protected $fillable = [
    'name',
    'muscles',
    'default_unit',
    'description',
    'created_by',
  ];

  protected $casts = [
    'muscles' => 'array',
  ];

  /**
   * Get the user who created this exercise
   */
  public function creator(): BelongsTo {
    return $this->belongsTo(User::class, 'created_by');
  }

}
