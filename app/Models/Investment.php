<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model {
  use HasFactory;

  protected $fillable = [
    'contract_date',
    'status_date',
    'status_id',
    'capital',
    'yield',
    'months',
    'investor_id',
    'comments',
    'created_by',
  ];
}