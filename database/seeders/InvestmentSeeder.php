<?php

namespace Database\Seeders;

use App\Models\ContractReturn;
use App\Models\Investment;
use App\Models\InvestmentLog;
use App\Models\InvestorProfile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class InvestmentSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    // create User
    $user = User::create([
      'name' => 'juanito',
      'last_name' => 'galindo',
      'second_last_name' => 'galeana',
      'email' => 'juan@gmail.com',
      'password' => Hash::make('admin'),
      'birthday' => '1990-01-01',
      'cellphone' => '81-2022-7272',
    ]);
    // assing Role
    $investorRole = Role::where("name", "investor")->first();
    $user->assignRole($investorRole);
    // create Profile
    InvestorProfile::create([
      'investor_id' => $user->id,
      'status_id' => 1, // incompleto
    ]);

    // create contract
    $capital = 75000;
    $contractReturn = ContractReturn::where('min_capital', '<=', $capital)->orderBy('min_capital', 'desc')->first();
    $yield = $contractReturn->yield;
    $investment = Investment::create([
      'contract_date' => Carbon::now(),
      'status_date' => Carbon::now(),
      'status_id' => 1,
      'capital' => $capital,
      'yield' => $yield,
      'months' => 12, // anual
      'investor_id' => $user->id,
      'created_by' => $user->id,
    ]);
    InvestmentLog::create([
      'status_id' => $investment->status_id,
      'user_id' => $user->id,
    ]);

  }
}
