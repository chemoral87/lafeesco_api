<?php
namespace App\Services;

class CreditService {

  private $payment;
  const DEFAULT_INSTANCE = 'amortization-table';

  public function getPayment($rate, $total_payments, $capital) {

    $montly_rate = $rate / 100 / 12;
    $payment = ($capital * ($montly_rate * pow(1 + $montly_rate, $total_payments))) / (pow(1 + $montly_rate, $total_payments) - 1);
    // $this->payment = $payment;
    return round($payment, 2);
  }

  public function getAmortizationTable($rate, $total_payments, $capital, $tax, $factor) {
    $payment = $this->getPayment($rate, $total_payments, $capital);
    $payment = $payment + 0.01;

    $montly_rate = $rate / 100 / 12;
    $montly_rate_noTax = $montly_rate / (1 + $tax);

    $content = collect([]);
    $id = 1;
    $_saldo = $capital;

    while ($id <= $total_payments) {
      $_interes = round($_saldo * $montly_rate_noTax, 2);
      $_iva = round($_interes * $tax, 2);
      $_capital = round($payment - ($_interes + $_iva), 2);
      $_saldo = round($_saldo - $_capital, 2);

      $receipt = collect([
        'capital' => $_capital,
        'interes' => $_interes,
        'iva' => $_iva,
        'saldo' => $_saldo,
      ]);
      $content->put($id, $receipt);
      $id++;
    }

    return $content;
  }

  // protected function getContent(): Collection {
  //   return  collect([]);
  // }

}
