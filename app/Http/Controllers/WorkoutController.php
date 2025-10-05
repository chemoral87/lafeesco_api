<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataSetResource;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutController extends Controller {
  /**
   * Display a listing of workouts
   */
  public function index(Request $request) {
    $query = queryServerSide($request, Workout::query());

    // Only get workouts created by the authenticated user
    $query->where('created_by', Auth::id());

    $query->with(['exercise', 'creator']);

    $filter = $request->get("filter");
    if ($filter) {
      $query->whereHas('exercise', function ($q) use ($filter) {
        $q->where('name', 'like', '%' . $filter . '%');
      });
    }

    $workouts = $query->orderBy('created_at', 'desc')->paginate($request->get('itemsPerPage'));

    return new DataSetResource($workouts);
  }

  /**
   * Store a newly created workout
   */
  public function store(Request $request) {
    $validated = $request->validate([
      'exercise_id' => 'required|exists:exercises,id',
      'repetitions' => 'required|integer|min:1',
      'unit' => 'required|in:lb,kg,mt',
      'weight' => 'nullable|numeric|min:0',
      'workout_date' => 'required|date_format:Y-m-d H:i:s',
      'notes' => 'nullable|string',
    ]);

    $validated['created_by'] = Auth::id();

    $workout = Workout::create($validated);

    return ['success' => 'Workout created successfully', 'id' => $workout->id];
  }

  /**
   * Display the specified workout
   */
  public function show($id) {
    $workout = Workout::with(['exercise', 'creator'])
      ->where('created_by', Auth::id())
      ->find($id);

    if ($workout == null) {
      abort(404, 'Workout not found');
    }

    return response()->json($workout);
  }

  /**
   * Update the specified workout
   */
  public function update(Request $request, $id) {
    $workout = Workout::where('created_by', Auth::id())->find($id);

    if (!$workout) {
      abort(404, 'Workout not found');
    }

    $workout->update([
      'exercise_id' => $request->get('exercise_id'),
      'repetitions' => $request->get('repetitions'),
      'unit' => $request->get('unit'),
      'weight' => $request->get('weight'),
      'workout_date' => $request->get('workout_date'),
      'notes' => $request->get('notes'),
    ]);

    return ['success' => 'Workout updated successfully'];
  }

  /**
   * Remove the specified workout
   */
  public function destroy($id) {
    $workout = Workout::where('created_by', Auth::id())->find($id);

    if (!$workout) {
      abort(404, 'Workout not found');
    }

    $workout->delete();
    return ['success' => 'Workout deleted successfully'];
  }
}
