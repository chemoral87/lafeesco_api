<?php

namespace App\Http\Controllers;

use App\Models\MessageTemplate;
use Illuminate\Http\Request;

class MessageTemplateController extends Controller {

  public function index(Request $request) {
    $query = queryServerSide($request, MessageTemplate::from("message_templates"));
    $message_templates = $query->paginate($request->get('itemsPerPage'));
    return new DataSetResource($message_templates);
  }

}
