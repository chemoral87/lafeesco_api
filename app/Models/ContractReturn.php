<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class ContractReturn extends Model implements AuditableContract {
  use HasFactory;
  use Auditable;

  protected $fillable = [
    'max_capital',
    'label',
    'yield',
    'user_id',
  ];
}
