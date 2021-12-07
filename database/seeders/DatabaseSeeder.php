<?php

namespace Database\Seeders;

use Database\Seeders\ContractReturnSeeder;
use Database\Seeders\PermissionDemoSeeder;
use Illuminate\Database\Seeder;

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
  }
}
