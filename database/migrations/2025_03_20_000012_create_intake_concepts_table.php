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
    Schema::create('intake_concepts', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique(); // Example: "Chicken", "Rice", etc.
      $table->foreignId('intake_classification_id')->constrained('intake_classifications')->onDelete('cascade'); // Reference to intake_classifications table
      $table->foreignId('intake_measure_id')->constrained('intake_measures') // Reference to intake_measures table
        ->onDelete('cascade')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('intake_concepts');
  }
};
