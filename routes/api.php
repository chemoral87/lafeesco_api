<?php

// Route::get("test", function () {
//   return "ok test - " . date("d  Y h:i:s A");
// });

Route::get("test", "TestController@test");

Route::group(["middleware" => ["api"], "prefix" => "auth"], function ($router) {
  $controller = "AuthController";
  Route::post("login", "{$controller}@login");
  Route::post("logout", "{$controller}@logout");
  Route::post("refresh", "{$controller}@refresh");
  Route::post("user", "{$controller}@me");
});

Route::group(["prefix" => "users", "middleware" => ['jwt.verify']], function () {
  $controller = "UserController";
  Route::get("/", "{$controller}@index");
  Route::get("/{id}", "{$controller}@show");
  Route::post("/", "{$controller}@create");
  Route::put("/{id}", "{$controller}@update");
  Route::put("/{id}/children", "{$controller}@children");
  Route::delete("/{id}", "{$controller}@delete");
});

Route::group(["prefix" => "roles", "middleware" => ['jwt.verify']], function () {
  $controller = "RoleController";
  Route::get("/", "{$controller}@index");
  Route::get("/filter", "{$controller}@filter");
  Route::get("/{id}", "{$controller}@show");
  Route::post("/", "{$controller}@create");
  Route::put("/{id}", "{$controller}@update");
  Route::delete("/{id}", "{$controller}@delete");
  Route::put("/{id}/children", "{$controller}@children");
});

Route::group(["prefix" => "permissions", "middleware" => ['jwt.verify']], function () {
  $controller = "PermissionController";
  Route::get("/", "{$controller}@index");
  Route::get("/filter", "{$controller}@filter");
  Route::post("/", "{$controller}@create");
  Route::put("/{id}", "{$controller}@update");
  Route::delete("/{id}", "{$controller}@delete");
});

Route::group(["prefix" => "investment"], function () {
  $controller = "InvestmentController";
  Route::get("/contract-returns", "{$controller}@contractReturns");;
});

Route::group(["prefix" => "investor"], function () {
  $controller = "InvestorController";
  Route::post("/newinvest", "{$controller}@newinvest");
});

// // Verify email
// Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
//   ->middleware(['signed', 'throttle:6,1'])
//   ->name('verification.verify');

// // Resend link to verify email
// Route::post('/email/verify/resend', function (Request $request) {
//   $request->user()->sendEmailVerificationNotification();
//   return back()->with('message', 'Verification link sent!');
// })->middleware(['auth:api', 'throttle:6,1'])->name('verification.send');

Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify'); // Make sure to keep this as your route name

Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');