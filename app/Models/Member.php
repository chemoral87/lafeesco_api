<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Member extends Model implements AuditableContract {
  use HasFactory, Auditable;

  protected $fillable = [
    'name',
    'paternal_surname',
    'maternal_surname',
    'birthday',
    'cellphone',
    'marital_status_id',
    'category_id',
    'prayer_request',
    'next_call_type_id',
    'next_call_date',
    'created_by',
  ];
}
