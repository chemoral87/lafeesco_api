<?php

namespace App\Http\Controllers;

class IntakeController extends Controller {

  public function index(Request $request) {
    $filter = $request->get("filter");
    $query = queryServerSide($request, Intake::query());
    if ($filter) {
      $query->where("name", "like", "%" . $filter . "%");
    }
    $intakes = $query->paginate($request->get('itemsPerPage'));
    return new DataSetResource($intakes);
  }

  public function show($id) {
    $intake = Intake::where("id", $id)->first();
    if ($intake == null) {
      abort(405, 'Intake not found');
    }
    return response()->json($intake);
  }

  public function create(Request $request) {
    $userId = JWTAuth::user()->id;
    $intake = Intake::create([
      'intake_time' => $request->get('intake_time'),
      'intake_concept_id' => $request->get('intake_concept_id'),
      'measure_id' => $request->get('measure_id'),
      'quantity' => $request->get('quantity'),
    ]);
    return ['success' => __('messa.intake_create')];
  }

  public function update(Request $request, $id) {
    $userId = JWTAuth::user()->id;
    $intake = Intake::find($id);
    $intake->intake_time = $request->get('intake_time');
    $intake->intake_concept_id = $request->get('intake_concept_id');
    $intake->measure_id = $request->get('measure_id');
    $intake->quantity = $request->get('quantity');
    $intake->save();
    return ['success' => __('messa.intake_update')];
  }

  public function delete($id) {
    $intake = Intake::find($id);
    $intake->delete();
    return ['success' => __('messa.intake_delete')];
  }

}
