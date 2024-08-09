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
    Schema::create('parking_cars', function (Blueprint $table) {
      $table->id();
      $table->foreignId('org_id')->constrained("organizations");
      $table->string('plate_number');
      $table->string('brand');
      $table->string('model');
      $table->string('color');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('parking_cars');
  }
};
