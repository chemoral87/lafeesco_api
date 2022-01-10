<?php

namespace App\Models;

use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Investment extends Model implements AuditableContract {
  use HasFactory, Auditable;

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



  // https://medium.com/@kiasaty/how-to-avoid-enum-data-type-in-laravel-eloquent-1c37ec908773
  // public const STATUS = [
  //   1 => 'incomplete',
  //   2 => 'complete',
  //   3 => 'authorize',
  // ];

  // public function getStatusAttribute() {
  //   return self::STATUS[$this->attributes['status_id']];
  // }
}
