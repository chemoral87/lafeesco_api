<?php

namespace App\Http\Controllers;

use App\Models\AgroEvent;
use Illuminate\Http\Request;

class AgroEventController extends Controller
{
    public function create(Request $request) {
        $agro_event = AgroEvent::create($request->all());
        return ['success' => __('messa.agro_event_create')];
    }
}
