<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TemplateGeneratorController extends Controller {
  public function getTables(Request $request) {
    $filter = $request->get("filter");
    $tables = DB::table('information_schema.tables')
      ->select("TABLE_NAME")
      ->where("table_type", "BASE TABLE")
      ->where("table_name", "LIKE", "%" . $filter . "%")
      ->whereNotIn("table_schema", ["performance_schema"])
      ->paginate(5);
    return $tables->items();
  }
}
