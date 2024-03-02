<?php

namespace App\Http\Controllers;

use App\Models\FaithHouse;
use Illuminate\Http\Request;

class FaithHouseContactController extends Controller {

  const PATH_S3 = "faith_house/";

  public function index(Request $request, $faith_house_id) {

    $faith_house = FaithHouse::find($faith_house_id);

    $contacts = $faith_house->contacts();
    return $contacts->get();
  }

  public function create(Request $request, $faith_house_id) {
    $faith_house = FaithHouse::find($faith_house_id);
    $data = $request->all();

    $data = $this->formatData($data);

    $photo = $request->hasFile('photo_blob') ? saveS3Blob($request->file('photo_blob'), self::PATH_S3) : null;
    $data['photo'] = $photo;

    $contact = $faith_house->contacts()->create($data);
    return ['success' => __('messa.faith_house_contact_create')];
  }

  public function update(Request $request, $faith_house_id, $id) {
    $faith_house = FaithHouse::find($faith_house_id);
    $contact = $faith_house->contacts()->find($id);
    $data = $request->all();

    $data = $this->formatData($data);

    if ($request->hasFile('photo_blob')) {
      if ($contact->photo) {
        deleteS3($contact->photo);
      }
      $photo = saveS3Blob($request->file('photo_blob'), self::PATH_S3);
      $data['photo'] = $photo;
    }

    $contact->update($data);
    return ['success' => __('messa.faith_house_contact_update')];

  }

  public function delete(Request $request, $faith_house_id, $id) {
    $faith_house = FaithHouse::find($faith_house_id);
    $contact = $faith_house->contacts()->find($id);
// delete photo from s3
    if ($contact->photo) {
      deleteS3($contact->photo);
    }

    $contact->delete();
    return ['success' => __('messa.faith_house_contact_delete')];
  }

  public function formatData($data) {
    if (array_key_exists('role', $data)) {
      $data['role'] = mb_strtoupper($data['role']);
    }

    if (array_key_exists('name', $data)) {
      $data['name'] = ucwords($data['name']);
    }

    if (array_key_exists('paternal_surname', $data)) {
      $data['paternal_surname'] = ucwords($data['paternal_surname']);
    }

    if (array_key_exists('maternal_surname', $data)) {
      $data['maternal_surname'] = ucwords($data['maternal_surname']);
    }

    return $data;
  }
}
