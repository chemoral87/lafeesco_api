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
    Schema::table('faith_houses', function (Blueprint $table) {
      $table->tinyInteger('order')->default(1)
        ->nullable()->after('end_date');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('faith_houses', function (Blueprint $table) {
      $table->dropColumn('order');
    });
  }
};
