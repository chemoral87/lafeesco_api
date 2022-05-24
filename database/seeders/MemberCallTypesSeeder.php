<?php

namespace Database\Seeders;

use App\Models\MemberCallType;
use Illuminate\Database\Seeder;

class MemberCallTypesSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    MemberCallType::create(['was_contacted' => 1, 'name' => 'Informativa', 'description' => 'Saber cómo está?', 'color' => '#29B6F6']);
    MemberCallType::create(['was_contacted' => 1, 'name' => "Integración", 'description' => 'Invitarlo a una célular', 'color' => '#26C6DA']);
    MemberCallType::create(['was_contacted' => 1, 'name' => "Asistencia", 'description' => 'Saber a qué culto asiste', 'color' => '#26A69A']);
    MemberCallType::create(['was_contacted' => 1, 'name' => "No molestar", 'description' => 'Ya no quiere recibir llamadas', 'color' => '#A5D6A7']);

    MemberCallType::create(['was_contacted' => 0, 'name' => "No contesta", 'color' => '#FBC02D']);
    MemberCallType::create(['was_contacted' => 0, 'name' => "No disponible", 'color' => '#FB8C00']);

  }
}
