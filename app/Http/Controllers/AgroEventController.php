<?php

namespace App\Http\Controllers;

use App\Models\AgroEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class AgroEventController extends Controller
{

    const PATH_S3 = "agro_event/";
    public function create(Request $request)
    {
        $images = [];
        foreach ($request->file('images') as $key => $blob) {
            $full_path = saveS3Blob($blob, self::PATH_S3);
            $images[] = $full_path;
        }
        $agro_event = AgroEvent::create($request->all() + ['created_by' => JWTAuth::user()->id]);
        // https://github.com/gothinkster/laravel-realworld-example-app/blob/master/app/Http/Controllers/Api/CommentController.php
        foreach ($images as $image) {
            $agro_event->images()->create([
                'agro_event_id' => $agro_event->id,
                'path' => $image,
            ]);
        }
        return ['success' => __('messa.agro_event_create')];
    }

    public function update(Request $request, $id)
    {
        Log::info($request);
        $agro_event = AgroEvent::find($id);
        // $a->images()->where("id",2)->get()
        $images = [];
        foreach ($request->file('images') as $key => $blob) {
            $full_path = saveS3Blob($blob, self::PATH_S3);
            $images[] = $full_path;
        }
        foreach ($images as $image) {
            $agro_event->images()->create([
                'agro_event_id' => $agro_event->id,
                'path' => $image,
            ]);
        }
    }

    public function index(Request $request)
    {
        $agro_events = AgroEvent::with("images")->get();
        return $agro_events;
    }

    public function show(Request $request, $id)
    {
        $agro_event = AgroEvent::with('images')->where("id", $id)->first();

        if ($agro_event == null) {
            abort(405, 'Agro Event not found');
        }

        return response()->json($agro_event);
    }
}
