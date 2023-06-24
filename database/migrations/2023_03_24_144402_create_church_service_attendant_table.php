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
    Schema::create('church_service_attendant', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('church_service_id')->unsigned();
      $table->foreign('church_service_id')->references('id')->on('church_services')->onDelete('cascade');
      $table->bigInteger('attendant_id')->unsigned();
      $table->foreign('attendant_id')->references('id')->on('attendants')->onDelete('cascade');
      $table->bigInteger('ministry_id')->unsigned();
      $table->foreign('ministry_id')->references('id')->on('ministries')->onDelete('cascade');
      $table->tinyInteger('seq');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('church_service_attendant');
  }
};
