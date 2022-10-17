<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\AgroEvent;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class AgroEventController extends Controller
{

    const PATH_S3 = "agro_event/";
    public function create(Request $request) {

        $request->created_by = JWTAuth::user()->id;
        // $images = json_decode($request->get('images'));
        $images =  [];

        foreach ($request->file('images') as $key => $blob) {
           $full_path = saveS3Blob($blob, self::PATH_S3);
            // $folder  = Carbon::now()->timezone("America/Monterrey")->format("Ymd")."/";
            // $name = self::PATH_S3.$folder.Str::uuid()->toString(). '.jpg';
            // Log::info("imagen ".$key." ".$name);
            // $intervention = Image::make($file)->encode('jpg');
            // $result = Storage::disk('s3')->put($name, $intervention);
            Log::info("result ".$result);
            $images[] =$full_path;
        }
        $agro_event = AgroEvent::create($request->all());
        return ['success' => __('messa.agro_event_create')];
    }
}
