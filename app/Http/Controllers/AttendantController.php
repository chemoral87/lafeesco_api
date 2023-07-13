<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataSetResource;
use App\Models\Attendant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AttendantController extends Controller {
  const PATH_S3 = "attendant/";

  public function index(Request $request) {
    $filter = $request->get("filter");
    $query = queryServerSide($request, Attendant::query());
    if ($filter) {
      $query->where(DB::raw("CONCAT(name, ' ', paternal_surname)"), "like", "%" . $filter . "%");
    }
    $attendants = $query
    // ->with("ministries")
      ->with(['ministries' => function ($query) {
        $query->select('name');
      }])
      ->paginate($request->get('itemsPerPage'));
    return new DataSetResource($attendants);
  }

  public function create(Request $request) {
    $photo = "";
    if ($request->has('image')) {
      $photo = saveS3Blob($request->file('image'), self::PATH_S3);
    }

    $attendant = Attendant::create([
      'name' => Str::title($request->get('name')),
      'paternal_surname' => Str::title($request->get('paternal_surname')),
      'maternal_surname' => Str::title($request->get('maternal_surname')),
      'cellphone' => $request->get('cellphone'),
      'photo' => $photo,
      'email' => $request->get('email'),
      'birthdate' => $request->get('birthdate'),
    ]);
    $attendant->ministries()->sync($request->get('ministry_ids'));

    return ['success' => __('messa.attendant_create')];
  }

  public function update(Request $request, $id) {
    $attendant = Attendant::find($id);

    if ($request->has('image')) {
      try {
        deleteS3($attendant->real_photo);
      } catch (Exception $e) {
        Log::error(sprintf("%s - func %s - line %d - ", __CLASS__, __FUNCTION__, __LINE__) . $e->getMessage());
      }
      $photo = saveS3Blob($request->file('image'), self::PATH_S3);
      $attendant->photo = $photo;
    }

    $attendant->name = Str::title($request->get('name'));
    $attendant->paternal_surname = Str::title($request->get('paternal_surname'));
    $attendant->maternal_surname = Str::title($request->get('maternal_surname'));
    $attendant->cellphone = $request->get('cellphone');
    $attendant->email = $request->get('email');
    $attendant->birthdate = $request->get('birthdate');
    $attendant->ministries()->sync($request->get('ministry_ids'));

    $attendant->save();

    return [
      'success' => __('messa.attendant_update'),
    ];
  }

  public function delete($id) {
    $attendant = Attendant::find($id);
    if ($attendant->real_photo) {
      deleteS3($attendant->real_photo);
    }
    // $attendant->delete();

    return ['success' => __('messa.attendant_delete')];
  }

  public function show(Request $request, $id) {
    $attendant = Attendant::with("ministries")->where("id", $id)->first();

    if ($attendant == null) {
      abort(405, 'Attendant not found');
    }
    return response()->json($attendant);
  }
}
