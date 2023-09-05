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
    Schema::create('sky_entrances', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('sky_kid_id')->unsigned();
      $table->string('room');
      $table->datetime('exits')->nullable();
      $table->string('ticket');
      $table->bigInteger('created_by')->unsigned();
      $table->bigInteger('updated_by')->unsigned();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('sky_entrances');
  }
};
