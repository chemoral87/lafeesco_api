<?php

namespace Database\Seeders;

use App\Models\ContractReturn;
use Illuminate\Database\Seeder;

class ContractReturnSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    ContractReturn::create(['min_capital' => 200000, 'label' => '$200,000 en adelante', 'yield' => 6, 'user_id' => 1]);
    ContractReturn::create(['min_capital' => 50000, 'label' => '$50,000 a $199,999', 'yield' => 5, 'user_id' => 1]);
    ContractReturn::create(['min_capital' => 30000, 'label' => '$30,000 a $49,999', 'yield' => 4, 'user_id' => 1]);
    ContractReturn::create(['min_capital' => 10000, 'label' => '$10,000 a $29,999', 'yield' => 3, 'user_id' => 1]);
  }
}
