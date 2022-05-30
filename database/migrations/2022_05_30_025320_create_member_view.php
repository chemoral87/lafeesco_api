<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateMemberView extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    DB::statement("
    CREATE VIEW members_v AS
    SELECT mmb.*, mmbc.name as category, mrt.name as marital_status,
    TIMESTAMPDIFF(YEAR, birthday, NOW() ) as years
        FROM `members` mmb
        LEFT join member_categories mmbc on mmbc.id = mmb.category_id
        LEFT JOIN marital_statuses mrt on mrt.id = mmb.marital_status_id
  ");
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('members_v');
  }
}
