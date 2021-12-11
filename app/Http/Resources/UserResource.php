<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {

  public function toArray($request) {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'last_name' => $this->last_name,
      'second_last_name' => $this->second_last_name,
      'email' => $this->email,
      'email_verified' => isset($this->email_verified_at) ? 1 : 0,
      // 'created_at' => $this->created_at,
      'permissions' => $this->getAllPermissions()->pluck('name'),
    ];
    // return parent::toArray($request);
  }
}
