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
    Schema::create('organization_configs', function (Blueprint $table) {
      $table->id();
      $table->foreignId('org_id')->constrained("organizations")->onDelete('cascade');
      $table->foreignId('config_id')->constrained("configs")->onDelete('cascade');

      $table->string('value');
      // description

      $table->unique(['org_id', 'config_id']);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('organization_configs');
  }
};
