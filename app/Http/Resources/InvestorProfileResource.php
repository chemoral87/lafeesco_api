<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class InvestorProfileResource extends JsonResource {

  public function toArray($request) {

    $front_identification_url = "";
    if ($this->front_identification) {
      $front_identification_url = Storage::disk('s3')->temporaryUrl($this->front_identification, Carbon::now()->addMinute(120));
    }

    return [
      'id' => $this->id,
      'investor_id' => $this->investor_id,
      'status_id' => $this->status_id,
      'front_identification_url' => $front_identification_url,
      'back_identification' => $this->back_identification,
    ];
    // return parent::toArray($request);
  }
}
