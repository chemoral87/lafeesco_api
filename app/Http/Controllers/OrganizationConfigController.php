<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Organization;
use App\Models\OrganizationConfig;
use Illuminate\Http\Request;

class OrganizationConfigController extends Controller {
  public function index(Request $request, $org_id) {
    $query = OrganizationConfig::where('org_id', $org_id);
    $organization_configs = $query->get();
    $config_ids = $organization_configs->pluck('config_id')->toArray();

    $configs = Config::whereNotIn('id', $config_ids)->get();
    return ['organization_configs' => $organization_configs, 'configs' => $configs];

  }

  public function create(Request $request, $org_id) {
    $organization = Organization::find($org_id);
    if (!$organization) {
      return response()->json(['message' => 'Organization Not Found'], 404);
    }
    $configs = $request->configs;

    // create  organization config for each [{"config_id":1,"value":"casa de fe"},{"config_id":2,"value":"2.5"}]
    // prevent  Integrity constraint violation: 1062 Duplicate entry '4-2'
    foreach ($configs as $key => $value) {
      $organization->config()->updateOrCreate(
        ['config_id' => $value['config_id']], ['value' => $value['value']]);
    }

    // foreach ($configs as $config) {
    //     $organization_config = new OrganizationConfig();
    //     $organization_config->org_id = $org_id;
    //     $organization_config->config_id = $config['config_id'];
    //     $organization_config->value = $config['value'];
    //     $organization_config->save();
    //   }

    // foreach ($configs as $key => $value) {
    //     $organization->config()->create([
    //       'config_id' => $key,
    //       'value' => $value,
    //     ]);
    //   }

    return ['success' => __('messa.organization_config_create')];
    // return response()->json(['message' => 'Organization Config Created Successfully'], 201);
  }

  public function update(Request $request, $org_id) {

    // $organization->config()->sync($configs);

    return response()->json(['message' => 'Organization Config Updated Successfully'], 200);
  }
}
