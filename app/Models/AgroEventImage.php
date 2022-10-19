<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AgroEventImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'agro_event_id',
        'path',
    ];

    public function getPathAttribute($value)
    {
        if ($value) {

            return Storage::disk('s3')->temporaryUrl($value, Carbon::now()->addMinutes(20));
        }

        return "https://source.unsplash.com/96x96/daily";
    }

//     public function agroEvent()
//     {
//         return $this->belongsTo(AgroEvent::class);
//     }
}
