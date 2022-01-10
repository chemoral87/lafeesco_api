<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentLogsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('investment_logs', function (Blueprint $table) {
      $table->id();
      $table->integer("status_id");
      $table->string("comment")->nullable();
      $table->unsignedBigInteger("user_id");
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('investment_logs');
  }
}
