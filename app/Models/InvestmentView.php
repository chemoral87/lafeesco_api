<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class InvestmentView extends Model {
  use HasFactory;

  // https://laracasts.com/discuss/channels/general-discussion/sql-views-as-laravel-eloquent-models
  protected $table = 'investments_v';

  protected $casts = [
    'capital' => 'float',
    'yield' => 'float',
    'months' => 'integer',
  ];
}
