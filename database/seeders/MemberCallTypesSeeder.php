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
    MemberCallType::create(['was_contacted' => 1, 'name' => 'Bienvenida', 'description' => 'Dar la bienvenida, información de cultos y próximas actividades', 'color' => '#29B6F6']);
    MemberCallType::create(['was_contacted' => 1, 'name' => 'Seguimiento', 'description' => 'Saludar, saber cómo ha estado? si tiene alguna duda', 'color' => '#29B6F6']);
    MemberCallType::create(['was_contacted' => 1, 'name' => "Conexión", 'description' => 'Hablar de las casas de fé o grupgos de Conexión', 'color' => '#26C6DA']);
    MemberCallType::create(['was_contacted' => 1, 'name' => "Seguimiento2", 'description' => 'Saludar, saber cómo ha estado? si tiene alguna duda?', 'color' => '#26A69A']);
    MemberCallType::create(['was_contacted' => 1, 'name' => "No molestar", 'description' => 'Ya no quiere recibir llamadas', 'color' => '#A5D6A7']);

    MemberCallType::create(['was_contacted' => 0, 'name' => "No contesta", 'color' => '#FBC02D']);
    MemberCallType::create(['was_contacted' => 0, 'name' => "No disponible", 'color' => '#FB8C00']);

  }
}
