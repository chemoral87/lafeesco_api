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
      $table->string('marital_status')->nullable()->after('phone');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('faith_houses_membership', function (Blueprint $table) {
      $table->dropColumn('marital_status');
    });
  }
};
