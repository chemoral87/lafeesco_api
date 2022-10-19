<?php

namespace App\Http\Controllers;

use App\Models\AgroEvent;
use App\Models\AgroEventImage;
use Illuminate\Http\Request;
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
        foreach ($images as $image) {
            AgroEventImage::create([
                'agro_event_id' => $agro_event->id,
                'path' => $image,
            ]);

        }
        return ['success' => __('messa.agro_event_create')];
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
