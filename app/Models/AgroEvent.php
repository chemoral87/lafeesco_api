<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgroEvent extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type_id',
        'description',
        'lat',
        'lng',
        'created_by',
      ];
}
