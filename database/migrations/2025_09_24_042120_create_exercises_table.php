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
    Schema::create('exercises', function (Blueprint $table) {
      $table->id();
      $table->string('name')->comment('Nombre del ejercicio');
      $table->json('muscles')->comment('Músculos que trabaja (gluteo, bicep, core, pierna, etc)');
      $table->enum('default_unit', ['lb', 'kg', 'mt'])->comment('Unidad de medida por defecto para este ejercicio');
      $table->text('description')->nullable()->comment('Descripción del ejercicio');
      $table->unsignedBigInteger('created_by')->comment('Usuario que creó el ejercicio');
      $table->timestamps();

      $table->foreign('created_by')->references('id')->on('users');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('exercises');
  }
};
