<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller {
  // https://codingdriver.com/laravel-user-roles-and-permissions-tutorial-with-example.html
  public function index(Request $request) {

    $query = Role::query();
    $itemsPerPage = $request->itemsPerPage;
    $sortBy = $request->get('sortBy');
    $sortDesc = $request->get('sortDesc');
    foreach ($request->get('sortBy') as $index => $column) {
      $sortDirection = ($sortDesc[$index] == 'true') ? 'DESC' : 'ASC';
      $query = $query->orderBy($column, $sortDirection);
    }
    $roles = $query->paginate($itemsPerPage);
    return $roles;
  }

  public function create(Request $request) {
    $this->validate($request, [
      'name' => 'required|unique:roles,name',
      // 'permissions' => 'required',
    ]);

    $role = Role::create(['name' => $request->input('name')]);
    $role->syncPermissions($request->permissions);

    return [
      'success' => __('messa.role_create'),
    ];
    // return redirect()->route('roles.index')
    //   ->with('success', 'Role created successfully');
  }

  public function update(Request $request, $id) {
    $this->validate($request, [
      'name' => 'required',
      // 'permissions' => 'required',
    ]);

    $role = Role::find($id);
    $role->name = $request->input('name');
    $role->save();

    $role->syncPermissions($request->input('permissions'));

    return [
      'success' => __('messa.role_update'),
    ];

    // return redirect()->route('roles.index')
    //   ->with('success', 'Role updated successfully');
  }

  public function delete($id) {
    Role::find($id)->delete();

    return [
      'success' => __('messa.role_delete'),
    ];
    // return redirect()->route('roles.index')
    //   ->with('success', 'Role deleted successfully');
  }
}
