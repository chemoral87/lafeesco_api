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
    Schema::table('faith_house_membership_house', function (Blueprint $table) {
// set distance as decimal
      $table->decimal('distance', 10, 5)->nullable()->after('faith_house_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('faith_house_membership_house', function (Blueprint $table) {
      $table->dropColumn('distance');
    });
  }
};
