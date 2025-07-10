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
    Schema::create('intake_measures', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique(); // Example: liters, cups, grams
      $table->string('abbreviation')->unique(); // Example: L, cup, g
      $table->string('description')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('intake_measures');
  }
};
