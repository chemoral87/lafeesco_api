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
      $table->foreignId('org_id')->nullable()->after('ip_address')->constrained('organizations'); //
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('faith_house_memberships', function (Blueprint $table) {
      Schema::dropIfExists('org_id');
    });
  }
};
