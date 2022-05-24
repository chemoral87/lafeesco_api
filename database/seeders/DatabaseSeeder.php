<?php

namespace Database\Seeders;

use Database\Seeders\ContractReturnSeeder;
use Database\Seeders\InvestmentSeeder;
use Database\Seeders\PermissionDemoSeeder;
use Database\Seeders\StatusSeeder;
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
    $this->call(InvestmentSeeder::class);
    $this->call(StatusSeeder::class);
    $this->call(MaritalStatusSeeder::class);
    $this->call(MemberCallTypesSeeder::class);
    $this->call(MemberCategorySeeder::class);

  }
}
