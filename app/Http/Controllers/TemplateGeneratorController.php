<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TemplateGeneratorController extends Controller {
  public function getTables(Request $request) {
    $table_filter = $request->get("table_filter");
    $schema_filter = $request->get("schema_filter");
    $tables = DB::table('information_schema.tables')
      ->select("table_name", "table_schema")
      ->where("table_type", "BASE TABLE")
      ->where("table_name", "LIKE", "%" . $table_filter . "%")
      ->where("TABLE_SCHEMA", "LIKE", "%" . $schema_filter . "%")
      ->whereNotIn("table_schema", ["performance_schema"])
      ->paginate(5);
    return $tables->items();
  }

  public function getDefinitions(Request $request) {
    $payload = $request->get("payload");
    $table_definitions = [];
    foreach ($payload as $table) {
      $data = json_decode($table, true);
      $table_name = Str::lower($data["table_name"]);
      $table_schema = $data["table_schema"];
      $definition = DB::table('information_schema.COLUMNS')
        ->select("column_key", "table_name", "column_name", "ordinal_position", "is_nullable", "data_type", "character_maximum_length", "numeric_precision", "numeric_scale")
        ->where("TABLE_NAME", "LIKE", $table_name)
        ->where("TABLE_SCHEMA", "LIKE", $table_schema)->get();

      $table_definitions[$table_name] = $definition;
    }
    return $definition;

    // return $table_definitions;
  }

}
