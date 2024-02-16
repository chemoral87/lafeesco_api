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
    Schema::create('faith_house_contacts', function (Blueprint $table) {
      $table->id();
      $table->foreignId('faith_house_id')->constrained();

      $table->string('name');
      $table->string('paternal_surname');
      $table->string('maternal_surname');
      $table->string('phone');
      $table->string('photo')->nullable();
      $table->string('email')->nullable();
      $table->string('role')->nullable();

      $table->tinyInteger('order')->default(1);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('faith_house_contacts');
  }
};
