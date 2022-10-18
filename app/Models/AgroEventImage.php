<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgroEventImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'agro_event_id',
        'path',
    ];

//     public function agroEvent()
//     {
//         return $this->belongsTo(AgroEvent::class);
//     }
}
