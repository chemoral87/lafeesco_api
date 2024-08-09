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
    Schema::create('parking_car_contacts', function (Blueprint $table) {
      $table->id();
      $table->foreignId('parking_car_id')->constrained("parking_cars");
      $table->string('name');
      $table->string('phone');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('parking_car_contacts');
  }
};
