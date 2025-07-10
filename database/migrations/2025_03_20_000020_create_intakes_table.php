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
    Schema::create('intakes', function (Blueprint $table) {
      $table->id();
      $table->dateTime('intake_time'); // The time of intake
      $table->foreignId('intake_concept_id')->constrained('intake_concepts')->onDelete('cascade');
      $table->foreignId('measure_id')->constrained('intake_measures')->onDelete('cascade'); // References `intake_measures`
      $table->decimal('quantity', 5, 2); // Example: "1/3" .33, "1/4" .25
// created_by
      $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // Reference to users table
      $table->foreignId('updated_by')->constrained('users')->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('intakes');
  }
};
