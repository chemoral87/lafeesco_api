<?php

return [
  'paths' => ['api/*'],
  'allowed_methods' => ['*'],

  //'allowed_origins' => ['http://localhost:*', 'http://localhost:3000', '*'],
  'allowed_origins' => ['http://localhost:*', 'http://localhost:3000', 'http://172.21.176.1:3000', 'http://192.168.0.5:3000', 'http://192.168.0.5:*', 'https://dev.d2ax9tya2rkwv4.amplifyapp.com'],
  'allowed_origins_patterns' => [],

  'allowed_headers' => ['*'],

  'exposed_headers' => false,

  'max_age' => 0,

  'supports_credentials' => false,
  /*
  |--------------------------------------------------------------------------
  | Laravel CORS Options
  |--------------------------------------------------------------------------
  |
  | The allowed_methods and allowed_headers options are case-insensitive.
  |
  | You don't need to provide both allowed_origins and allowed_origins_patterns.
  | If one of the strings passed matches, it is considered a valid origin.
  |
  | If ['*'] is provided to allowed_methods, allowed_origins or allowed_headers
  | all methods / origins / headers are allowed.
  |
   */

  /*
   * You can enable CORS for 1 or multiple paths.
   * Example: ['api/*']
   */
  // 'paths' => ['api/*'],

  // /*
  //  * Matches the request method. `['*']` allows all methods.
  //  */
  // 'allowed_methods' => ['*'],

  // /*
  //  * Matches the request origin. `['*']` allows all origins. Wildcards can be used, eg `*.mydomain.com`
  //  */
  // 'allowed_origins' => ['http://localhost:*', 'http://localhost:3000'],

  // /*
  //  * Patterns that can be used with `preg_match` to match the origin.
  //  */
  // 'allowed_origins_patterns' => [],

  // /*
  //  * Sets the Access-Control-Allow-Headers response header. `['*']` allows all headers.
  //  */
  // 'allowed_headers' => ['content-type', 'accept', 'x-custom-header', 'Access-Control-Allow-Origin'],

  // /*
  //  * Sets the Access-Control-Expose-Headers response header with these headers.
  //  */
  // // 'exposed_headers' => ['*'],
  // 'exposed_headers' => ['x-custom-response-header'],
  // /*
  //  * Sets the Access-Control-Max-Age response header when > 0.
  //  */
  // 'max_age' => 0,

  // /*
  //  * Sets the Access-Control-Allow-Credentials header.
  //  */
  // 'supports_credentials' => false,
];
