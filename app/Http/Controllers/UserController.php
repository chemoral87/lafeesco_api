<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserShowResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
    $userResource = new UserShowResource(User::find($id));
    return response()->json($userResource);
  }

  public function create(Request $request) {
    $req = $this->validate($request, [
      'name' => 'required',
      'last_name' => 'required',
      'email' => 'required',
    ]);
    User::create($req + ['password' => Hash::make('admin')]);
    return ['success' => __('messa.user_create')];
  }

  public function update(Request $request, $id) {
    $this->validate($request, [
      'name' => 'required',
      'last_name' => 'required',
    ]);
    $user = User::find($id);
    $user->name = $request->name;
    $user->last_name = $request->last_name;
    $user->second_last_name = $request->second_last_name;
    $user->save();
    return ['success' => __('messa.user_update')];
  }

  public function children(Request $request, $id) {
    $user = User::find($id);
    if ($user) {
      $role_ids = $request->role_ids;
      $permissions_ids = $request->permissions_ids;
      $user->roles()->sync($role_ids);
      $user->permissions()->sync($permissions_ids);
    }

    return ['success' => __('messa.user_roles_update')];
  }

  public function delete($id) {
    if ($id != 1 && $id != 2) {
      // admin
      User::find($id)->delete();
    }
    return ['success' => __('messa.user_delete')];
  }

}
