<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataSetResource;
use App\Models\Attendant;
use Illuminate\Http\Request;

class AttendantController extends Controller {
  const PATH_S3 = "attendant/";

  public function index(Request $request) {
    $query = queryServerSide($request,  Attendant::query());
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
    $attendant = Attendant::where("id", $id)->update([
      'name' => $request->get('name'),
      'paternal_surname' => $request->get('paternal_surname'),
      'maternal_surname' => $request->get('maternal_surname'),
      'cellphone' => $request->get('cellphone'),
      'photo' => $request->get('photo'),
      'email' => $request->get('email'),
      'birthdate' => $request->get('birthdate'),
    ]);
    return [
      'success' => __('messa.attendant_update'),
    ];
  }

  public function delete($id) {
    Attendant::find($id)->delete();
    return ['success' => __('messa.attendant_delete')];
  }
}
