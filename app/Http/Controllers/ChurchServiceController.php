<?php

namespace App\Http\Controllers;

use App\Models\ChurchService;
use Illuminate\Http\Request;

class ChurchServiceController extends Controller {
  public function index() {
    $query = new ChurchService;
    $church_services = $query->get();
    return [
      'church_services' => $church_services,
    ];
  }

  public function create(Request $request) {

    $church_service = ChurchService::create($request->all());
    return ['success' => __('messa.church_service_create')];
  }

}
