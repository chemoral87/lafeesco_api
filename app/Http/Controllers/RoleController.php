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
    $roles = $query->with("permissions")->paginate($itemsPerPage);
    return $roles;
  }

  public function filter(Request $request) {
    $filter = $request->queryText;
    $ids = isset($request->ids) ? $request->ids : [];
    $roles = Role::select("name", "id")
      ->whereNotIn("id", $ids)
      ->where("name", "like", "%" . $filter . "%")
      ->orderBy("name")->paginate(2);
    return $roles->items();
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

    return ['success' => __('messa.role_update')];
  }

  public function delete($id) {
    Role::find($id)->delete();
    return ['success' => __('messa.role_delete')];
  }
}
