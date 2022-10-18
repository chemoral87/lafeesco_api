<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

function createVerificationCode($length = 10) {
  $characters = '0123456789';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

function generateFileName($file, $path) {
  $d = app()->environment();
  $extension = $file->extension();
  $full_name = $d . $path . "/" . uniqid() . "." . $extension;
  // $full_name = $d . $path;
  return $full_name;
}

function saveS3Blob($blob, $path, $file_to_delete = null) {
    $folder  = Carbon::now()->format("Ymd")."/";
    $name =  $path.$folder.Str::uuid()->toString(). '.jpg';
    $intervention = Image::make($blob)->encode('jpg');
    $result = Storage::disk('s3')->put($name, $intervention);
    // https://www.positronx.io/laravel-image-resize-upload-with-intervention-image-package/
    // https://laracasts.com/discuss/channels/laravel/resize-an-image-before-upload-to-s3


    if ($file_to_delete != null) {
      try {
        Storage::disk('s3')->delete($old_file);
      } catch (Exception $e) {
      }
    }
    return $name;
  }

function saveAmazonFile($file, $path, $old_file = null) {
  $d = app()->environment();
  $extension = $file->extension();
  $full_name = $d . $path . "/" . uniqid() . "." . $extension;
  // https://www.positronx.io/laravel-image-resize-upload-with-intervention-image-package/
  // https://laracasts.com/discuss/channels/laravel/resize-an-image-before-upload-to-s3
  $img = Image::make($file);
//   $img->resize(null, 800, function ($constraint) {
//     $constraint->aspectRatio();
//   });

  //detach method is the key! Hours to find it... :/
  $resource = $img->stream()->detach();

  $path = Storage::disk('s3')->put($full_name, $resource);

  if ($old_file != null) {
    try {
      Storage::disk('s3')->delete($old_file);
    } catch (Exception $e) {
    }
  }
  return $full_name;
}


 function queryServerSide($request, $query) {
    if ($request->has('sortBy')) {
      $sortBy = $request->get('sortBy');
      $sortDesc = $request->get('sortDesc');
      foreach ($sortBy as $key => $value) {
        $sortBy_ = $sortBy[$key];
        $sortDesc_ = $sortDesc[$key] == 'true' ? 'desc' : 'asc';
        $query->orderBy($sortBy_, $sortDesc_);
      }
    }

    return $query;
  }
