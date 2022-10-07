<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaithHouseController extends Controller
{
    public function index(Request $request) {
    }

    public function create(Request $request) {
        $house_faith = HouseFaith::create($request->all());
        return ['success' => __('messa.house_faith_create')];
    }

    public function update(Request $request, $id) {
        $house_faith = HouseFaith::where("id", $id)->update($request->all());
        return [
            'success' => __('messa.house_faith_update'),
          ];
    }

    public function delete($id) {
        HouseFaith::find($id)->delete();
        return ['success' => __('messa.house_faith_delete')];
      }
}
