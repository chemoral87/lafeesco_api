<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    try {
      // Require for cloud-databases
      \Illuminate\Support\Facades\DB::statement('SET SESSION sql_require_primary_key=0');
    } catch (Throwable $e) {

    }
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('last_name');
      $table->string('second_last_name')->nullable();
      $table->string('email')->unique();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->date("birthday")->nullable();
      $table->string("cellphone")->nullable();
      $table->rememberToken();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('users');
  }
}
