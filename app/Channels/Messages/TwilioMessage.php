<?php

namespace App\Channels\Messages;

class TwilioMessage {
  public $content;

  public function content($content) {
    $this->content = $content;

    return $this;
  }
}
