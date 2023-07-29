<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

function createVerificationCode($length = 10) {
  $characters = '0123456789';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

function saveS3Blob($blob, $path, $file_to_delete = null) {
  $d = app()->environment();
  $folder = Carbon::now()->format("Ymd") . "/";
  $name = $d . "/" . $path . $folder . Str::uuid()->getHex()->toString() . '.jpg';
  $intervention = Image::make($blob)->encode('webp');
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

function awsUrlS3($path) {

  if ($path) {

    $cacheKey = 'aws-url-' . $path;
    $cacheTtl = 60 * 12 * 7; // in minutes
    // Check if the temporary URL is already cached
    if (Cache::has($cacheKey)) {
      //   Log::info("Cache::get($cacheKey)");
      return Cache::get($cacheKey);
    }
    //   return Storage::disk('s3')->temporaryUrl($path, Carbon::now()->addMinutes(cacheTtl));
    $temporaryUrl = Storage::disk('s3')->url($path);
    Cache::put($cacheKey, $temporaryUrl, $cacheTtl);
    return $temporaryUrl;
  }
  return "https://source.unsplash.com/96x96/daily";

}

function temporaryUrlS3($path) {
  Log::info($path);
  if ($path) {

    $cacheKey = 'temp-url-' . $path;
    $cacheTtl = 5; // in minutes
    // Check if the temporary URL is already cached
    if (Cache::has($cacheKey)) {
      return Cache::get($cacheKey);
    }
    //   return Storage::disk('s3')->temporaryUrl($path, Carbon::now()->addMinutes(cacheTtl));
    $temporaryUrl = Storage::disk('s3')->temporaryUrl($path, now()->addMinutes(5));
    Cache::put($cacheKey, $temporaryUrl, $cacheTtl);
    return $temporaryUrl;
  }
  return "https://source.unsplash.com/96x96/daily";

}

function deleteS3($path) {
  try {
    $result = Storage::disk('s3')->delete($path);
  } catch (Exception $e) {
  }

  return $result;
}

function saveAmazonFile($file, $path, $old_file = null) {
  $d = app()->environment();
  $extension = $file->extension();
  $full_name = $d . $path . "/" . uniqid() . "." . $extension;
  // https://www.positronx.io/laravel-image-resize-upload-with-intervention-image-package/
  // https://laracasts.com/discuss/channels/laravel/resize-an-image-before-upload-to-s3
  $img = Image::make($file);

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

function replace_tags($string, $tags, $force_lower = false) {
  return preg_replace_callback('/\\{\\{([^{}]+)\}\\}/',
    function ($matches) use ($force_lower, $tags) {
      $key = $force_lower ? strtolower($matches[1]) : $matches[1];
      return array_key_exists($key, $tags)
      ? $tags[$key]
      : ''
      ;
    }
    , $string);
}
