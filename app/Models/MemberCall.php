<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberCall extends Model {
  use HasFactory;
  protected $fillable = [
    "member_id",
    "call_type_id",
    "comments",
    "created_by",
  ];
}
