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
    Schema::create('faith_house_memberships', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('age')->nullable();
      $table->string('phone');
      $table->string('street_address')->nullable();
      $table->string('house_number')->nullable();
      $table->string('neighborhood')->nullable();
      $table->string('municipality')->nullable();
      $table->decimal('lat', 10, 8)->nullable();
      $table->decimal('lng', 11, 8)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('faith_house_memberships');
  }
};
