<?php

namespace Database\Seeders;

use App\Models\Municipality;
use Illuminate\Database\Seeder;

class MunicipalitySeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    Municipality::create(['name' => 'Escobedo']);
    Municipality::create(['name' => 'García']);
    Municipality::create(['name' => 'San Nicolás']);
    Municipality::create(['name' => 'Monterrey']);
  }
}
