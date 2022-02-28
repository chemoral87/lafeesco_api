<?php

// Route::get("test", function () {
//   return "ok test - " . date("d  Y h:i:s A");
// });

Route::get("test/{user}", "TestController@test");

Route::group(["prefix" => "auth", "middleware" => ["api"]], function ($router) {
  $controller = "AuthController";
  Route::post("login", "{$controller}@login");
  Route::post("logout", "{$controller}@logout");
  Route::post("refresh", "{$controller}@refresh");
  Route::post("user", "{$controller}@me");
});

Route::group(["middleware" => ['jwt.verify']], function () {
  Route::group(["prefix" => "users"], function () {
    $controller = "UserController";
    Route::get("/", "{$controller}@index");
    Route::get("/{id}", "{$controller}@show");
    Route::post("/", "{$controller}@create");
    Route::put("/{id}", "{$controller}@update");
    Route::put("/{id}/children", "{$controller}@children");
    Route::delete("/{id}", "{$controller}@delete");
  });

  Route::group(["prefix" => "roles"], function () {
    $controller = "RoleController";
    Route::get("/", "{$controller}@index");
    Route::get("/filter", "{$controller}@filter");
    Route::get("/{id}", "{$controller}@show");
    Route::post("/", "{$controller}@create");
    Route::put("/{id}", "{$controller}@update");
    Route::delete("/{id}", "{$controller}@delete");
    Route::put("/{id}/children", "{$controller}@children");
  });

  Route::group(["prefix" => "permissions"], function () {
    $controller = "PermissionController";
    Route::get("/", "{$controller}@index");
    Route::get("/filter", "{$controller}@filter");
    Route::post("/", "{$controller}@create");
    Route::put("/{id}", "{$controller}@update");
    Route::delete("/{id}", "{$controller}@delete");
  });

}); // ["middleware" => ['jwt.verify']

Route::group(["prefix" => "investment"], function () {
  $controller = "InvestmentController";
  Route::get("/contract-returns", "{$controller}@contractReturns");
  Route::get("/my-index", "{$controller}@myIndex");
});

Route::group(["prefix" => "investment-status"], function () {
  $controller = "InvestmentStatusController";
  Route::get("/", "{$controller}@index");

});

Route::group(["prefix" => "investor"], function () {
  $controller = "InvestorController";
  Route::post("/newinvest", "{$controller}@newinvest");
  Route::post("/sendVerificationCode", "{$controller}@sendVerificationCode");
  Route::post("/verifyCode", "{$controller}@verifyCode");

  Route::post("/my-profile", "{$controller}@myUpdate");
});

Route::group(["prefix" => "investor-profile"], function () {
  $controller = "InvestorProfileController";
  Route::get("/my", "{$controller}@myIndex");
  Route::post("/my", "{$controller}@myUpdate");
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