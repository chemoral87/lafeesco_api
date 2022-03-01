<?php

namespace App\Http\Controllers;

use App\Services\CreditService;
use Illuminate\Http\Request;

class CreditController extends Controller {

  protected $creditService;

  public function __construct(CreditService $creditService) {
    $this->creditService = $creditService;
  }

  public function amortizationTable(Request $request) {

    $rate = $request->rate;
    $total_payments = $request->total_payments;
    $capital = $request->capital;
    $type = "f"; //floor

    $payment = $this->creditService->getPayment($rate, $total_payments, $capital);
    $table = $this->creditService->getAmortizationTable($rate, $total_payments, $capital, .16, 1);

    return [
      'payment' => $payment,
      'table' => $table,
      'success' => __('messa.credit_amortization_table'),
    ];
  }
}