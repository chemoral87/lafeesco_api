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
      $table->string("paternal_surname");
      $table->string("maternal_surname")->nullable();
      $table->string("cellphone", 13)->nullable();
      $table->date("birthday")->nullable();
      $table->tinyInteger("marital_status_id")->nullable();
      $table->tinyInteger("category_id")->nullable();
      $table->unsignedBigInteger("address_id")->nullable();
      $table->string("prayer_request", 250)->nullable();

      $table->unsignedBigInteger("last_call_id")->nullable();
      $table->unsignedBigInteger("next_call_type_id")->nullable();
      $table->date("next_call_date")->nullable();

      $table->unsignedBigInteger("created_by");

      $table->foreign('address_id')->references('id')->on('member_addresses');
      $table->foreign('created_by')->references('id')->on('users');
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
