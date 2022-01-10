<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\StatusSeeder;
use Database\Seeders\InvestmentSeeder;
use Database\Seeders\ContractReturnSeeder;
use Database\Seeders\PermissionDemoSeeder;

class DatabaseSeeder extends Seeder {
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run() {
    // \App\Models\User::factory(1
    $this->call(PermissionDemoSeeder::class);
    $this->call(ContractReturnSeeder::class);
    $this->call(InvestmentSeeder::class);
    $this->call(StatusSeeder::class);
  }
}
