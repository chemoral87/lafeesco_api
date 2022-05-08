<?php

namespace App\Models\Credits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model {
  use HasFactory;
  protected $table = 'cr_receipts';
}
