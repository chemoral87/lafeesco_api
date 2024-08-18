<?php

namespace App\Http\Controllers;

use App\Models\OrganizationConfig;
use Illuminate\Http\Request;

class ConfigController extends Controller {

  public function index(Request $request) {
    // ['value_one', 'value_two']
    $settings = $request->get('settings');

    // get org_ids from user
    $org_ids = auth()->user()->profiles->pluck('org_id');
    $organization_config = OrganizationConfig::with("config")->whereIn('org_id', $org_ids)
// for each setting in settings, whereOr like name ->whereOr('name', 'like', '%' . $setting . '%'
      ->whereHas('config', function ($query) use ($settings) {
        $query->where(function ($query) use ($settings) {
          foreach ($settings as $setting) {
            $query->orWhere('key', 'like', $setting . '%');
          }
        });
      })
    //   ->where(function ($query) use ($settings) {
    //     foreach ($settings as $setting) {
    //       $query->orWhere('key', 'like', $setting . '%');
    //     }
    //   })
      ->get();

    $result = [];

    foreach ($organization_config as $item) {
      $orgId = $item->org_id;
      $key = $item->config->key;
      $value = $item->value;

      $result[$orgId]['org_id'] = $orgId;
      $result[$orgId]['keys'][$key] = $value;
    }

    // $result = [];

    // foreach ($organization_config as $item) {
    //   $org_id = $item['org_id'];
    //   $key = $item['key'];
    //   $value = $item['value'];

    //   if (!isset($result[$org_id])) {
    //     $result[$org_id] = ['org_id' => $org_id, 'keys' => []];
    //   }

    //   $result[$org_id]['keys'][$key] = $value;
    // }

    return array_values($result);

    return $result;
  }
}
