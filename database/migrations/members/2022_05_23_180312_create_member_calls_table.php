<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberCallsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('member_calls', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger("member_id");
      $table->unsignedBigInteger("call_type_id");
      $table->string("comments", 250)->nullable();
      $table->unsignedBigInteger("created_by")->unsigned();
      $table->timestamps();

      $table->foreign('member_id')->references('id')->on('members');
      $table->foreign('call_type_id')->references('id')->on('member_call_types');
      $table->foreign('created_by')->references('id')->on('users');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('member_calls');
  }
}
