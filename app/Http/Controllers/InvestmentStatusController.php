<?php

namespace App\Http\Controllers;

use App\Models\InvestmentStatus;

class InvestmentStatusController extends Controller {
  public function index() {
    return InvestmentStatus::all();
  }
}
