<?php

use Illuminate\Database\Migrations\Migration;

class CreateMemberView extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    DB::statement("
    CREATE VIEW members_v AS
    select `mmb`.`id` AS `id`,`mmb`.`name` AS `name`,`mmb`.`paternal_surname` AS `paternal_surname`,`mmb`.`maternal_surname` AS `maternal_surname`,`mmb`.`cellphone` AS `cellphone`,`mmb`.`birthday` AS `birthday`,`mmb`.`marital_status_id` AS `marital_status_id`,`mmb`.`category_id` AS `category_id`,`mmb`.`address_id` AS `address_id`,`mmb`.`prayer_request` AS `prayer_request`,`mmb`.`last_call_id` AS `last_call_id`,`mmb`.`next_call_type_id` AS `next_call_type_id`,`mmb`.`next_call_date` AS `next_call_date`,`mmb`.`created_by` AS `created_by`,`mmb`.`created_at` AS `created_at`,`mmb`.`updated_at` AS `updated_at`,`mmbc`.`name` AS `category`,`mrt`.`name` AS `marital_status`,timestampdiff(YEAR,`mmb`.`birthday`,current_timestamp()) AS `years`,`mct`.`name` AS `next_call_type` from (((`members` `mmb` left join `member_categories` `mmbc` on(`mmbc`.`id` = `mmb`.`category_id`)) left join `marital_statuses` `mrt` on(`mrt`.`id` = `mmb`.`marital_status_id`)) left join `member_call_types` `mct` on(`mct`.`id` = `mmb`.`next_call_type_id`));

    CREATE VIEW AS
SELECT mcll.*, mcllt.name as call_type, mcllt.was_contacted
FROM `member_calls` as mcll
join member_call_types mcllt on mcllt.id = mcll.call_type_id;
  ");
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    DB::statement('DROP VIEW members_v;');
    DB::statement('DROP VIEW member_calls_v;');
  }
}
