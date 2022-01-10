<?php

namespace Database\Seeders;

use App\Models\InvestmentStatus;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    InvestmentStatus::create(['name' => 'CAPTURA', 'order' => 10]);
    InvestmentStatus::create(['name' => 'REVISIÓN', 'order' => 20]);
    InvestmentStatus::create(['name' => 'AUTORIZADO', 'order' => 30]);
    InvestmentStatus::create(['name' => 'CANCELADO', 'order' => 40]);

  }
}
