<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateInvestmentTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {

    DB::statement("
      CREATE VIEW investments_v AS
      SELECT
	inv.id,
	inv.contract_date,
	inv.status_date,
	inv.status_id,
	sta.`name` AS `status`,
	inv.capital,
	inv.yield,
	inv.months,
	inv.investor_id,
	inv.comments,
	inv.created_by,
	inv.created_at,
	inv.updated_at
FROM
	investments AS inv
	INNER JOIN
	investment_statuses AS sta
	ON
		inv.status_id = sta.id
    ");
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    DB::statement('DROP VIEW investments_v;');
    // Schema::dropIfExists('investment_v');
  }
}
