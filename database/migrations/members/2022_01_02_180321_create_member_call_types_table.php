<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberCallTypesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('member_call_types', function (Blueprint $table) {
      $table->id();
      $table->boolean("was_contacted");
      $table->string("name");
      $table->string("description")->nullable();
      $table->string("color")->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('member_call_types');
  }
}
