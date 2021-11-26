<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserShowResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller {
  public function index(Request $request) {
    $query = User::query();
    $itemsPerPage = $request->itemsPerPage;
    $sortBy = $request->get('sortBy');
    $sortDesc = $request->get('sortDesc');
    foreach ($request->get('sortBy') as $index => $column) {
      $sortDirection = ($sortDesc[$index] == 'true') ? 'DESC' : 'ASC';
      $query = $query->orderBy($column, $sortDirection);
    }
    $users = $query->with("roles")->with("permissions")->paginate($itemsPerPage);
    return $users;
  }

  public function show(Request $request, $id) {
    $user = User::find($id);
    $userResource = new UserShowResource($user);
    return response()->json($userResource);
  }

  public function update(Request $request, $id) {
    Log::info($request);
    $role_ids = $request->role_ids;
    $permissions_ids = $request->permissions_ids;
    $user = User::find($id);
    $user->roles()->sync($role_ids);
    $user->permissions()->sync($permissions_ids);

    return [
      'success' => __('messa.user_update'),
    ];
  }

}
