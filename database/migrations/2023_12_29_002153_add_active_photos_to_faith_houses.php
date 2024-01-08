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
      $table->string('host_photo')->nullable()->after('host');
      $table->string('exhibitor_photo')->nullable()->after('exhibitor');
      $table->date('end_date')->nullable()->after('exhibitor_phone');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('faith_houses', function (Blueprint $table) {
      $table->dropColumn('host_photo');
      $table->dropColumn('exhibitor_photo');
      $table->dropColumn('end_date');
    });
  }
};
