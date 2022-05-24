<?php

namespace Database\Seeders;

use App\Models\MemberCategory;
use Illuminate\Database\Seeder;

class MemberCategorySeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    MemberCategory::create(['name' => 'Matrimonios']);
    MemberCategory::create(['name' => 'Jovenes']);
    MemberCategory::create(['name' => 'Adolescentes']);
    MemberCategory::create(['name' => 'Reconfortados']);
    MemberCategory::create(['name' => 'Varones']);
    MemberCategory::create(['name' => 'Mujeres']);
  }
}
