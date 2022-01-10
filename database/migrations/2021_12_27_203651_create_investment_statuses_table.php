<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentStatusesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('investment_statuses', function (Blueprint $table) {
      $table->id();
      $table->string("name");
      $table->tinyInteger("order")->nullable();
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
    Schema::dropIfExists('investment_statuses');
  }
}
