<?php

namespace App\Http\Controllers;

use App\Models\ContractReturn;
use Illuminate\Http\Request;

class InvestmentController extends Controller {
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request) {
    //
  }

  public function contractReturns() {
    // Log::info("contractReturns");
    return ContractReturn::orderBy("min_capital", "desc")->get();
  }
  // https://github.com/nuxt/nuxt.js/blob/ef4cdd477644cfb4571e1d7eb3b9ef1d16a3ed54/examples/vuex-persistedstate/store/index.js
}
