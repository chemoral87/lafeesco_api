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
      $table->foreignId('org_id')->nullable()->after('allow_matching')->constrained('organizations'); // Foreign key to link with organizations
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('faith_houses', function (Blueprint $table) {
      Schema::dropIfExists('org_id');
    });
  }
};
