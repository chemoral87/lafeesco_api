<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Cross-Origin Resource Sharing (CORS) Configuration
  |--------------------------------------------------------------------------
  |
  | Here you may configure your settings for cross-origin resource sharing
  | or "CORS". This determines what cross-origin operations may execute
  | in web browsers. You are free to adjust these settings as needed.
  |
  | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
  |
   */

  //'paths' => ['api/*'],
  'paths' => ['api/*'],
  'allowed_methods' => ['*'],

  'allowed_origins' => ['http://localhost:*', 'http://localhost:3000', 'https://dev.d2ax9tya2rkwv4.amplifyapp.com', 'https://rcdesarrolladora.cloudns.ph', '*'],

  'allowed_origins_patterns' => [],

  'allowed_headers' => ['*'],

  'exposed_headers' => false,

  'max_age' => 0,

  'supports_credentials' => false,

];
