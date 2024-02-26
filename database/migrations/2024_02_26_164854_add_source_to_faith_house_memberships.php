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
    Schema::table('faith_house_memberships', function (Blueprint $table) {
      $table->string('source')->nullable()->after('marital_status');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('faith_house_memberships', function (Blueprint $table) {
      $table->dropColumn('source');
    });
  }
};
