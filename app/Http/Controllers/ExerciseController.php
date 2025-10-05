<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataSetResource;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExerciseController extends Controller {
  /**
   * Display a listing of exercises
   */
  public function index(Request $request) {
    $query = queryServerSide($request, Exercise::query());

    // Only get exercises created by the authenticated user
    $query->where('created_by', Auth::id());

    $query->with('creator');

    $filter = $request->get("filter");
    if ($filter) {
      $query->where("name", "like", "%" . $filter . "%");
    }

    $exercises = $query->paginate($request->get('itemsPerPage'));

    return new DataSetResource($exercises);
  }

  /**
   * Store a newly created exercise
   */
  public function store(Request $request) {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'muscles' => 'required|array',
      'muscles.*' => 'string|max:100',
      'description' => 'nullable|string',
      'default_unit' => 'required|in:lb,kg,mt',
    ]);

    $validated['created_by'] = Auth::id();

    $exercise = Exercise::create($validated);

    return ['success' => 'Exercise created successfully', 'id' => $exercise->id];
  }

  /**
   * Display the specified exercise
   */
  public function show($id) {
    $exercise = Exercise::with('creator')
      ->find($id);

    if ($exercise == null) {
      abort(404, 'Exercise not found');
    }

    return response()->json($exercise);
  }

  /**
   * Update the specified exercise
   */
  public function update(Request $request, $id) {
    $exercise = Exercise::find($id);

    $exercise->update([
      'name' => $request->get('name'),
      'muscles' => $request->get('muscles'),
      'description' => $request->get('description'),
      'default_unit' => $request->get('default_unit'),
    ]);

    return ['success' => 'Exercise updated successfully'];
  }

  /**
   * Remove the specified exercise
   */
  public function destroy($id) {
    Exercise::find($id)->delete();
    return ['success' => 'Exercise deleted successfully'];
  }

  /**
   * Get exercises by muscle group
   */
  public function getByMuscle(Request $request) {
    $muscle = $request->query('muscle');

    if (!$muscle) {
      abort(400, 'Muscle parameter is required');
    }

    $exercises = Exercise::whereJsonContains('muscles', $muscle)
      ->with('creator')
      ->orderBy('name')
      ->get();

    return response()->json($exercises);
  }

  /**
   * Filter exercises for dropdown/selection
   */
  public function filter(Request $request) {
    $filter = $request->queryText;
    $ids = isset($request->ids) ? $request->ids : [];

    $exercises = Exercise::select("name", "id")
      ->where('created_by', Auth::id())
      ->whereNotIn("id", $ids)
      ->where("name", "like", "%" . $filter . "%")
      ->orderBy("name")->paginate(7);

    return $exercises->items();
  }
}
