<?php

namespace App\Http\Controllers;

use App\Models\BibleBook;
use Illuminate\Http\Request;

class BibleBookController extends Controller {
  public function index(Request $request) {
    return BibleBook::orderBy('order')->get();
  }
}
