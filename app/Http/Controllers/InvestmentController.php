<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataSetResource;
use App\Models\ContractReturn;
use App\Models\InvestmentView;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

// use Tymon\JWTAuth\JWTAuth;

class InvestmentController extends Controller {

  public function myIndex(Request $request) {
    $query = InvestmentView::query();
    $id = JWTAuth::user()->id;

    // Log::info("userid " . $id);
    $itemsPerPage = $request->itemsPerPage;
    $sortBy = $request->get('sortBy');
    $sortDesc = $request->get('sortDesc');
    $filter = $request->get("filter");

    foreach ($request->get('sortBy') as $index => $column) {
      $sortDirection = ($sortDesc[$index] == 'true') ? 'DESC' : 'ASC';
      $query = $query->orderBy($column, $sortDirection);
    }
    if ($filter) {
      $query->where("investor_id", $id);
    }

    $investment = $query->paginate($itemsPerPage);
    return new DataSetResource($investment);
    // return response()->json(new DataSetResource($investment))->setEncodingOptions(JSON_NUMERIC_CHECK);
  }

  public function create() {
    //
  }

  public function store(Request $request) {
    //
  }

  public function contractReturns() {
    return ContractReturn::orderBy("min_capital", "desc")->get();
    // https://github.com/nuxt/nuxt.js/blob/ef4cdd477644cfb4571e1d7eb3b9ef1d16a3ed54/examples/vuex-persistedstate/store/index.js
  }
}
