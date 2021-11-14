<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionDemoSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    //app()[PermissionRegistrar::class]->forgetCachedPermissions();

    // create permissions
    Permission::create(['name' => 'roles-index']);
    Permission::create(['name' => 'role-edit']);
    Permission::create(['name' => 'role-new']);
    Permission::create(['name' => 'role-delete']);

    Permission::create(['name' => 'contract-my-index']);
    Permission::create(['name' => 'contract-my-new']);

    // create roles and assign existing permissions
    // $role1 = Role::create(['name' => 'writer']);
    // $role1->givePermissionTo('edit articles');
    // $role1->givePermissionTo('delete articles');

    $role1 = Role::create(['name' => 'super']);
    $role1->givePermissionTo('roles-index');
    $role1->givePermissionTo('role-create');
    $role1->givePermissionTo('role-update');
    $role1->givePermissionTo('role-delete');
    // gets all permissions via Gate::before rule; see AuthServiceProvider

    $role2 = Role::create(['name' => 'admin']);

    $role3 = Role::create(['name' => 'investor']);
    $role3->givePermissionTo('contract-my-index');
    $role3->givePermissionTo('contract-my-new');

    // create demo users
    $user = \App\Models\User::factory()->create([
      'name' => 'Sergio',
      'last_name' => 'Morales',
      'second_last_name' => 'Parra',
      'email' => 'chemoral87@hotmail.com',
      'password' => Hash::make('admin'),
    ]);
    $user->assignRole($role1);

    $user = \App\Models\User::factory()->create([
      'name' => 'Arturo',
      'last_name' => 'Peniche',
      'email' => 'chemoral87@gamil.com',
      'password' => Hash::make('admin'),
    ]);
    $user->assignRole($role2);

    // $user = \App\Models\User::factory()->create([
    //   'name' => 'Sergio',
    //   'last_name' => 'Morales',
    //   'second_last_name' => 'Parra',
    //   'email' => 'superadmin@example.com',
    //   'password' => Hash::make('admin'),
    // ]);
    // $user->assignRole($role3);
  }
}
