<?php

namespace App\Http\Controllers;

use App\Services\BibleService;
use Illuminate\Http\Request;

class BibleController extends Controller {

  public $bibleService;

  public function __construct(BibleService $bibleService) {
    $this->bibleService = $bibleService;
  }

  public function index(Request $request) {

    return $this->bibleService->getVersicles($request->prompt);

  }

}
