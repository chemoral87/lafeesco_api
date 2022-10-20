<?php

namespace App\Http\Controllers;

use App\Models\AgroEvent;
use App\Models\AgroEventImage;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AgroEventController extends Controller {

  const PATH_S3 = "agro_event/";
  public function create(Request $request) {
    $images = [];
    if ($request->has('images')) {
      foreach ($request->file('images') as $key => $blob) {
        $full_path = saveS3Blob($blob, self::PATH_S3);
        // $images[] = $full_path;
        $images[] = new AgroEventImage(['path' => $full_path]);
      }
    }
    $agro_event = AgroEvent::create($request->all() + ['created_by' => JWTAuth::user()->id]);
    $agro_event->images()->saveMany($images);
    // https://github.com/gothinkster/laravel-realworld-example-app/blob/master/app/Http/Controllers/Api/CommentController.php
    // foreach ($images as $image) {
    //   $agro_event->images()->create([
    //     'agro_event_id' => $agro_event->id,
    //     'path' => $image,
    //   ]);
    // }

    return ['success' => __('messa.agro_event_create')];
  }

  public function update(Request $request, $id) {

    $agro_event = AgroEvent::find($id);

    $agro_event->fill($request->all())->save();
    // $a->images()->where("id",2)->get()
    $images = $agro_event->images()->whereNotIn("id", $request->image_ids)->get();
    foreach ($images as $img) {
      deleteS3($img->real_path);
      $img->delete();
    }

    $new_images = [];
    if ($request->has('images')) {
      foreach ($request->file('images') as $key => $blob) {
        $full_path = saveS3Blob($blob, self::PATH_S3);
        // $images[] = ['path' => $full_path];
        $new_images[] = new AgroEventImage(['path' => $full_path]);
      }
    }

    $agro_event->images()->saveMany($new_images);

  }

  public function index(Request $request) {
    $agro_events = AgroEvent::with("images")->get();
    return $agro_events;
  }

  public function show(Request $request, $id) {
    $agro_event = AgroEvent::with('images')->where("id", $id)->first();

    if ($agro_event == null) {
      abort(405, 'Agro Event not found');
    }
    return response()->json($agro_event);
  }

  public function delete($id) {

    $agro_event = AgroEvent::find($id);
    $images = $agro_event->images;
    foreach ($images as $img) {
      deleteS3($img->real_path);
    }
    $agro_event->delete();
    return ['success' => __('messa.agro_event_delete')];
  }

}
