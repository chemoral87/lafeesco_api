<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('members', function (Blueprint $table) {
      $table->id();
      $table->string("name");
      $table->string("paternal_surame");
      $table->string("maternal_surname");
      $table->date("birthday");
      $table->tinyInteger("matiral_status");
      $table->tinyInteger("category_id");
      $table->unsignedBigInteger("address_id")->unsigned();
      $table->string("prayer_request", 250);
      $table->foreign('address_id')->references('id')->on('member_addresses');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('members');
  }
}
