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
    // php artisan db:seed --class=MemberSourceSeeder --force
    Schema::create('member_sources', function (Blueprint $table) {
      $table->id();
      $table->string("name");
      $table->tinyInteger("order")->nullable();
      $table->string("logic")->nullable();
      $table->string("description")->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('member_sources');
  }
};
