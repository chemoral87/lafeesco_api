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
      ->select("TABLE_NAME", "TABLE_SCHEMA")
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
        ->select("COLUMN_KEY", "TABLE_NAME", "COLUMN_NAME", "ORDINAL_POSITION", "IS_NULLABLE", "DATA_TYPE", "CHARACTER_MAXIMUM_LENGTH", "NUMERIC_PRECISION", "NUMERIC_SCALE")
        ->where("TABLE_NAME", "LIKE", $table_name)
        ->where("TABLE_SCHEMA", "LIKE", $table_schema)->first();

      $table_definitions[$table_name] = $definition;
    }
    return $table_definitions;
  }

}
