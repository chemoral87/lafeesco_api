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
    Schema::create('bible_books', function (Blueprint $table) {
      $table->id();

      $table->string('ver', 5);
      $table->string('name', 50);
      $table->string('abreviation', 10);
      $table->char('testament', 1); // A = Antiguo, N = Nuevo
      $table->string('genre', 45);
      $table->unsignedInteger('order'); // nuevo campo para el orden del libro
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('bible_books');
  }
};
