<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MessageTemplate;
use App\Http\Resources\DataSetResource;

class MessageTemplateController extends Controller {

  public function index(Request $request) {
    $query = queryServerSide($request, MessageTemplate::query());
    $message_templates = $query->paginate($request->get('itemsPerPage'));
    return new DataSetResource($message_templates);
  }

}
