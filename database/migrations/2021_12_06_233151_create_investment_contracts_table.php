<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentContractsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('investments', function (Blueprint $table) {
      $table->id();
      $table->date('contract_date');
      $table->dateTime('status_date');
      $table->tinyInteger('status_id');
      $table->decimal('yield');
      $table->tinyInteger('months');
      $table->bigInteger('investor_id');
      $table->text("comments")->nullable();
      $table->bigInteger('created_by');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('investments');
  }
}
