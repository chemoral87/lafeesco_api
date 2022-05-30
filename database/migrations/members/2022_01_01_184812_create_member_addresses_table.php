<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberAddressesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('member_addresses', function (Blueprint $table) {
      $table->id();
      $table->string("municipality_id")->nullable();
      $table->string("other_municipality")->nullable();
      $table->string("street")->nullable();
      $table->string("number")->nullable();
      $table->string("suburn")->nullable(); // colonia
      $table->string("postal_code")->nullable();
      $table->string("telephone")->nullable();
      $table->point("position")->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('member_addresses');
  }
}
