<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestorProfilesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('investor_profiles', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('investor_id');

      $table->string("front_identification")->nullable();
      $table->string("back_identification")->nullable();
      $table->tinyInteger("status_id");
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('investor_profiles');
  }
}
