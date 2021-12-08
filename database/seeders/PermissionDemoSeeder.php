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
    Permission::create(['name' => 'user-index']);
    Permission::create(['name' => 'user-create']);
    Permission::create(['name' => 'user-update']);
    Permission::create(['name' => 'user-delete']);

    Permission::create(['name' => 'role-index']);
    Permission::create(['name' => 'role-create']);
    Permission::create(['name' => 'role-update']);
    Permission::create(['name' => 'role-delete']);

    Permission::create(['name' => 'permission-index']);
    Permission::create(['name' => 'permission-create']);
    Permission::create(['name' => 'permission-update']);
    Permission::create(['name' => 'permission-delete']);

    Permission::create(['name' => 'investment-authorize']);
    Permission::create(['name' => 'investment-reject']);

    Permission::create(['name' => 'investment-index']);
    Permission::create(['name' => 'investment-update']);
    Permission::create(['name' => 'investment-my-index']);
    Permission::create(['name' => 'investment-my-create']);

    // create roles and assign existing permissions
    // $role1 = Role::create(['name' => 'writer']);
    // $role1->givePermissionTo('edit articles');
    // $role1->givePermissionTo('delete articles');

    $role1 = Role::create(['name' => 'super']);
    $role1->givePermissionTo('role-index');
    $role1->givePermissionTo('role-create');
    $role1->givePermissionTo('role-update');
    $role1->givePermissionTo('role-delete');

    $role1->givePermissionTo('user-index');
    $role1->givePermissionTo('user-create');
    $role1->givePermissionTo('user-update');
    $role1->givePermissionTo('user-delete');

    $role1->givePermissionTo('permission-index');
    $role1->givePermissionTo('permission-create');
    $role1->givePermissionTo('permission-update');
    $role1->givePermissionTo('permission-delete');

    // gets all permissions via Gate::before rule; see AuthServiceProvider

    $role2 = Role::create(['name' => 'admin']);

    $role_inversor = Role::create(['name' => 'investor']);
    $role_inversor->givePermissionTo('investment-my-index');
    $role_inversor->givePermissionTo('investment-my-create');

    $role_contract_manager = Role::create(['name' => 'contract-manager']);
    $role_contract_manager->givePermissionTo('investment-index');
    $role_contract_manager->givePermissionTo('investment-update');
    $role_contract_manager->givePermissionTo('investment-authorize');

    Role::create(['name' => 'publisher']);
    Role::create(['name' => 'cashier']);
    Role::create(['name' => 'leader']);
    Role::create(['name' => 'worker']);
    Role::create(['name' => 'auditor']);

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
      'email' => 'chemoral87@gmail.com',
      'password' => Hash::make('admin'),
    ]);
    $user->assignRole($role2);

    $user_valeria = \App\Models\User::factory()->create([
      'name' => 'Valeria',
      'last_name' => 'Dominguez',
      'email' => 'valeria@gmail.com',
      'password' => Hash::make('admin'),
    ]);
    $user_valeria->assignRole($role_contract_manager);

    $user_juan = \App\Models\User::factory()->create([
      'name' => 'Juan',
      'last_name' => 'Perez',
      'email' => 'inversor@gmail.com',
      'password' => Hash::make('admin'),
    ]);
    $user_juan->assignRole($role_inversor);

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
