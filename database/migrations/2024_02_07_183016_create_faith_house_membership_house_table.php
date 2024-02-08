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
    Schema::create('faith_house_membership_house', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('faith_house_membership_id');
      $table->unsignedBigInteger('faith_house_id');
      $table->timestamps();

      $table->foreign('faith_house_membership_id')->references('id')->on('faith_house_memberships')->onDelete('cascade');
      $table->foreign('faith_house_id')->references('id')->on('faith_houses')->onDelete('cascade');

    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('faith_house_membership_house');
  }
};
