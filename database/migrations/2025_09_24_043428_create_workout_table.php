<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('workout', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('exercise_id')->comment('ID del ejercicio');
      $table->integer('repetitions')->comment('Cantidad de repeticiones');
      $table->enum('unit', ['lb', 'kg', 'mt'])->comment('Unidad de medida');
      $table->decimal('weight', 8, 2)->nullable()->comment('Peso utilizado (opcional)');
      $table->datetime('workout_date')->comment('Fecha y hora del entrenamiento');
      $table->text('notes')->nullable()->comment('Notas adicionales (opcional)');
      $table->unsignedBigInteger('created_by')->comment('Usuario que creó el registro');
      $table->timestamps();

      $table->foreign('exercise_id')->references('id')->on('exercises');
      $table->foreign('created_by')->references('id')->on('users');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('workout');
  }
};
