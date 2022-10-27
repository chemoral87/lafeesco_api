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
    Schema::create('attendants', function (Blueprint $table) {
      $table->id();
      $table->string("name");
      $table->string("paternal_surname");
      $table->string("maternal_surname")->nullable();
      $table->string("cellphone", 13);
      $table->string("photo")->nullable();
      $table->string("email")->nullable();
      $table->date("birthdate")->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('attendants');
  }
};
