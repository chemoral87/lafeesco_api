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
    Permission::create(['name' => 'investment-my-profile']);

    Permission::create(['name' => 'credit-index']);

    Permission::create(['name' => 'consolidador-lead']);
    Permission::create(['name' => 'consolidador-index']);
    Permission::create(['name' => 'consolidador-insert']);
    Permission::create(['name' => 'consolidador-update']);
    Permission::create(['name' => 'consolidador-call-insert']);
    Permission::create(['name' => 'consolidador-call-update']);
    Permission::create(['name' => 'consolidador-call-delete']);

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

    $role1->givePermissionTo('credit-index');

    // gets all permissions via Gate::before rule; see AuthServiceProvider

    $role2 = Role::create(['name' => 'admin']);

    $role_inversor = Role::create(['name' => 'investor']);
    $role_inversor->givePermissionTo('investment-my-index');
    $role_inversor->givePermissionTo('investment-my-create');
    $role_inversor->givePermissionTo('investment-my-profile');

    $role_contract_manager = Role::create(['name' => 'contract-manager']);
    $role_contract_manager->givePermissionTo('investment-index');
    $role_contract_manager->givePermissionTo('investment-update');
    $role_contract_manager->givePermissionTo('investment-authorize');

    $role_consolidador = Role::create(['name' => 'consolidador']);
    $role_consolidador->givePermissionTo('consolidador-index');
    $role_consolidador->givePermissionTo('consolidador-insert');
    $role_consolidador->givePermissionTo('consolidador-update');
    $role_consolidador->givePermissionTo('consolidador-call-insert');
    $role_consolidador->givePermissionTo('consolidador-call-update');
    $role_consolidador->givePermissionTo('consolidador-call-delete');

    $role_leader_consolidador = Role::create(['name' => 'lider_consolidador']);
    $role_leader_consolidador->givePermissionTo('consolidador-lead');
    $role_leader_consolidador->givePermissionTo('consolidador-index');
    $role_leader_consolidador->givePermissionTo('consolidador-insert');
    $role_leader_consolidador->givePermissionTo('consolidador-update');
    $role_leader_consolidador->givePermissionTo('consolidador-call-insert');
    $role_leader_consolidador->givePermissionTo('consolidador-call-update');
    $role_leader_consolidador->givePermissionTo('consolidador-call-delete');

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
    $user->assignRole($role_consolidador);

    $user = \App\Models\User::factory()->create([
      'name' => 'Felipe',
      'last_name' => 'Nicanor',
      'email' => 'felipe.djnicanor@gmail.com',
      'password' => Hash::make('admin'),
    ]);
    $user->assignRole($role_leader_consolidador);

    $user = \App\Models\User::factory()->create([
      'name' => 'Salvador',
      'last_name' => 'Castillo',
      'email' => 'salvador.castillo.g@gmail.com',
      'password' => Hash::make('admin'),
    ]);
    $user->assignRole($role_leader_consolidador);

    $user_valeria = \App\Models\User::factory()->create([
      'name' => 'Marlene',
      'last_name' => 'Morales',
      'email' => 'mar.morales@hotmail.com',
      'password' => Hash::make('admin'),
    ]);
    $user_valeria->assignRole($role_leader_consolidador);

    $user_juan = \App\Models\User::factory()->create([
      'name' => 'Juan',
      'last_name' => 'Perez',
      'email' => 'inversor@gmail.com',
      'password' => Hash::make('admin'),
    ]);
    $user_juan->assignRole($role_inversor);

  }
}
