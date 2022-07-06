<?php

namespace Database\Seeders;

use App\Models\MemberSource;
use Illuminate\Database\Seeder;

class MemberSourceSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    MemberSource::create(['name' => 'Dom 9am', 'order' => '1']);
    MemberSource::create(['name' => 'Dom 11am', 'order' => '2']);
    MemberSource::create(['name' => 'Dom 6pm', 'order' => '3']);
    MemberSource::create(['name' => 'Mie 7pm', 'order' => '4']);
  }
}
