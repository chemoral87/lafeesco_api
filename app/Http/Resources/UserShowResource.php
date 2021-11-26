<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserShowResource extends JsonResource {
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request) {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'last_name' => $this->last_name,
      'second_last_name' => $this->second_last_name,
      'email' => $this->email,
      // 'created_at' => $this->created_at,
      'roles' => $this->roles,
      'direct_permissions' => $this->getDirectPermissions(),
      // 'direct_permissions' => $this->getDirectPermissions(),
      // 'per2' => $this->getDirectPermissions(),
      // 'per3' => $this->getAllPermissions(),
      // 'per4' => $this->permissions,
      // 'permissions' => $this->getAllPermissions()->pluck('name'),
    ];
    // return parent::toArray($request);
  }
}
