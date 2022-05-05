<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// https: //www.itsolutionstuff.com/post/how-to-use-mysql-view-in-laravelexample.html
// https://styde.net/pivot-tables-con-eloquent-en-laravel/
class Credit extends Model {
  use HasFactory;
  protected $table = 'cr_credits';
}
