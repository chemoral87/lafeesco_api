<?php

namespace Database\Seeders;

use App\Models\MaritalStatus;
use Illuminate\Database\Seeder;

class MaritalStatusSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    // MaritalStatus::create(['name' => "(Vacío)"]);
    MaritalStatus::create(['name' => "Soltero"]);
    MaritalStatus::create(['name' => "Casado"]);
    MaritalStatus::create(['name' => "Divorciado"]);
    MaritalStatus::create(['name' => "Viudo"]);
    MaritalStatus::create(['name' => "Unión Libre"]);
  }
}
