<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataSetResource;
use App\Models\Ministry;
use Illuminate\Http\Request;

class MinistryController extends Controller {
  public function index(Request $request) {
    $filter = $request->get("filter");
    $query = queryServerSide($request, Ministry::query());
    if ($filter) {
      $query->where("name", "like", "%" . $filter . "%");
    }
    $ministries = $query->paginate($request->get('itemsPerPage'));
    return new DataSetResource($ministries);
  }

  public function show($id) {
    $ministry = Ministry::where("id", $id)->first();
    if ($ministry == null) {
      abort(405, 'Ministry not found');
    }
    return response()->json($ministry);
  }

  public function create(Request $request) {
    $ministry = Ministry::create([
      'name' => $request->get('name'),
      'order' => $request->get('order'),
    ]);
    return ['success' => __('messa.ministry_create')];
  }

  public function update(Request $request, $id) {
    $ministry = Ministry::find($id);
    $ministry->name = $request->get('name');
    $ministry->order = $request->get('order');
    $ministry->save();
    return ['success' => __('messa.ministry_update')];
  }

  public function delete($id) {
    $ministry = Ministry::find($id);
    if ($ministry == null) {
      abort(405, 'Ministry not found');
    }
    $ministry->delete();
    return ['success' => __('messa.ministry_delete')];
  }

}
