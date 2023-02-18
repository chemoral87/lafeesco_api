<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataSetResource;
use App\Models\Attendant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AttendantController extends Controller {
  const PATH_S3 = "attendant/";

  public function index(Request $request) {
    $query = queryServerSide($request, Attendant::query());
    $attendants = $query->paginate($request->get('itemsPerPage'));
    return new DataSetResource($attendants);
  }

  public function create(Request $request) {
    $photo = "";
    if ($request->has('image')) {
      $photo = saveS3Blob($request->file('image'), self::PATH_S3);
    }

    $attendant = Attendant::create([
      'name' => $request->get('name'),
      'paternal_surname' => $request->get('paternal_surname'),
      'maternal_surname' => $request->get('maternal_surname'),
      'cellphone' => $request->get('cellphone'),
      'photo' => $photo,
      'email' => $request->get('email'),
      'birthdate' => $request->get('birthdate'),
    ]);

    return ['success' => __('messa.attendant_create')];
  }

  public function update(Request $request, $id) {
    $attendant = Attendant::find($id);

    if ($request->has('image')) {
      try {
        deleteS3($attendant->photo);
      } catch (Exception $e) {
        Log::error(sprintf("%s - func %s - line %d - ", __CLASS__, __FUNCTION__, __LINE__) . $e->getMessage());
      }
      $photo = saveS3Blob($request->file('image'), self::PATH_S3);
      $attendant->photo = $photo;
    }

    // $attendant = Attendant::where("id", $id)->update([
    //   'name' => $request->get('name'),
    //   'paternal_surname' => $request->get('paternal_surname'),
    //   'maternal_surname' => $request->get('maternal_surname'),
    //   'cellphone' => $request->get('cellphone'),
    //   //   'photo' => $request->get('photo'),
    //   'email' => $request->get('email'),
    //   'birthdate' => $request->get('birthdate'),pl
    // ]);
    $attendant->name = $request->get('name');
    $attendant->paternal_surname = $request->get('paternal_surname');
    $attendant->maternal_surname = $request->get('maternal_surname');
    $attendant->cellphone = $request->get('cellphone');
    $attendant->email = $request->get('email');
    $attendant->birthdate = $request->get('birthdate');

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
    $attendant->delete();

    return ['success' => __('messa.attendant_delete')];
  }

  public function show(Request $request, $id) {
    $attendant = Attendant::where("id", $id)->first();

    if ($attendant == null) {
      abort(405, 'Attendant not found');
    }
    return response()->json($attendant);
  }
}
