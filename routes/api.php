<?php

Route::get("test", function () {
  return "ok test - " . date("d  Y h:i:s A");
});

Route::get("test/{user}", "TestController@test");

Route::group(["prefix" => "auth", "middleware" => ["api"]], function ($router) {
  $controller = "AuthController";
  Route::post("login", "{$controller}@login");
  Route::post("logout", "{$controller}@logout");
  Route::post("refresh", "{$controller}@refresh");
  Route::post("user", "{$controller}@me");

});

// Route::post('/forgot-password/send-code', [ForgotPasswordController::class, 'sendResetCode']);
// Route::post('/forgot-password/reset-password', [ForgotPasswordController::class, 'resetPassword']);

Route::group(["prefix" => "users"], function () {
  $controller = "UserController";
  Route::post("/register", "{$controller}@register");
  Route::post("/send-code", "{$controller}@sendResetCode");
  Route::post("/reset-password", "{$controller}@resetPassword");
});

Route::group(["middleware" => ['jwt.verify']], function () {

  Route::group(["prefix" => "organizations"], function () {
    $controller = "OrganizationController";
    Route::get("/", "{$controller}@index");
    Route::get("/filter", "{$controller}@filter");
    Route::get("/{id}", "{$controller}@show");
    Route::post("/", "{$controller}@create");
    Route::put("/{id}", "{$controller}@update");
    Route::delete("/{id}", "{$controller}@delete");
  });

  Route::group(["prefix" => "organization-configs"], function () {
    $controller = "OrganizationConfigController";
    Route::get("/{org_id}", "{$controller}@index");

    Route::post("/{org_id}", "{$controller}@create");
    Route::put("/{org_id}", "{$controller}@update");
    // Route::delete("/{id}", "{$controller}@delete");
  });

  Route::group(["prefix" => "profiles"], function () {
    $controller = "ProfileController";
    Route::get("/{user_id}", "{$controller}@index");
    // Route::get("/filter", "{$controller}@filter");
    Route::get("/{user_id}/{id}", "{$controller}@show");

    Route::post("/{user_id}", "{$controller}@create");
    Route::post("/{user_id}/{id}/favorite", "{$controller}@favorite");
    Route::put("/{user_id}/{id}", "{$controller}@update");
    Route::delete("/{user_id}/{id}", "{$controller}@delete");
  });

  Route::group(["prefix" => "configs"], function () {
    $controller = "ConfigController";
    Route::get("/", "{$controller}@index");
  });

  Route::group(["prefix" => "users"], function () {
    $controller = "UserController";
    Route::get("/", "{$controller}@index");
    Route::get("/filter", "{$controller}@filter");
    Route::get("/{id}", "{$controller}@show");
    Route::post("/", "{$controller}@create");
    // Route::post("/register", "{$controller}@register");
    Route::put("/{id}", "{$controller}@update");
    Route::put("/{id}/children", "{$controller}@children"); // TODO: remove
    Route::delete("/{id}", "{$controller}@delete");
    Route::post("/change", "{$controller}@changePassword");
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

  Route::group(["prefix" => "parking-car"], function () {
    $controller = "ParkingCarController";
    Route::get("/", "{$controller}@index");
    Route::get("/filter", "{$controller}@filter");
    Route::get("/{id}", "{$controller}@show");
    Route::post("/", "{$controller}@create");
    Route::put("/{id}", "{$controller}@update");
    Route::delete("/{id}", "{$controller}@delete");
  });

  Route::group(["prefix" => "parking-car-contact"], function () {
    $controller = "ParkingCarContactController";

    Route::get("/{parking_car_id}", "{$controller}@index");
    // Route::post("/{faith_house_id}", "{$controller}@create");
    // Route::put("/{faith_house_id}/{id}", "{$controller}@update");
    // Route::delete("/{parking_car_id}/{id}", "{$controller}@delete");
  });

  Route::group(["prefix" => "consolidation"], function () {
    $controller = "ConsolidationController";

  });

  Route::group(["prefix" => "members"], function () {
    $controller = "MemberController";
    Route::get("/marital-statuses", "{$controller}@getMaritalStatuses");
    Route::get("/member-categories", "{$controller}@getMemberCategories");
    Route::get("/member-sources", "{$controller}@getMemberSources");

    Route::get("/to-call", "{$controller}@toCall");
    Route::get("/my-no-address", "{$controller}@myNoAddress");
    Route::get("/my", "{$controller}@my");
    Route::get("/{id}", "{$controller}@show");
    Route::post("/", "{$controller}@create");
    Route::put("/{id}", "{$controller}@update");
    Route::delete("/{id}", "{$controller}@delete");
  });

  Route::group(["prefix" => "member-addresses"], function () {
    $controller = "MemberAddressController";
    Route::post("/", "{$controller}@create");
  });

  Route::group(["prefix" => "member-calls"], function () {
    $controller = "MemberCallController";
    Route::get("/by-member/{id}", "{$controller}@indexByMember");
    Route::get("/call-types", "{$controller}@callTypes");
    Route::post("/", "{$controller}@create");
    Route::put("/{id}", "{$controller}@update");
  });

  Route::group(["prefix" => "faith-house"], function () {
    $controller = "FaithHouseController";
    Route::get("/", "{$controller}@index");
    Route::get("/{id}", "{$controller}@show");
    Route::post("/", "{$controller}@create");
    Route::put("/{id}", "{$controller}@update");
    Route::delete("/{id}", "{$controller}@delete");
  });

  Route::group(["prefix" => "faith-house-contact"], function () {
    $controller = "FaithHouseContactController";

    Route::get("/{faith_house_id}", "{$controller}@index");
    Route::post("/{faith_house_id}", "{$controller}@create");
    Route::put("/{faith_house_id}/{id}", "{$controller}@update");
    Route::delete("/{faith_house_id}/{id}", "{$controller}@delete");
  });

  Route::group(["prefix" => "faith-house-membership"], function () {
    $controller = "FaithHouseMembershipController";
    Route::get("/", "{$controller}@index");
    Route::delete("/{id}", "{$controller}@delete");
  });

  Route::group(["prefix" => "agro-event"], function () {
    $controller = "AgroEventController";
    Route::get("/", "{$controller}@index");
    Route::get("/{id}", "{$controller}@show");
    Route::post("/", "{$controller}@create");
    Route::put("/{id}", "{$controller}@update");
    Route::delete("/{id}", "{$controller}@delete");
  });

  Route::group(["prefix" => "attendant"], function () {
    $controller = "AttendantController";
    Route::get("/", "{$controller}@index");

    Route::get("/{id}", "{$controller}@show");
    Route::post("/", "{$controller}@create");
    Route::put("/{id}", "{$controller}@update");
    Route::delete("/{id}", "{$controller}@delete");
  });

  Route::group(["prefix" => "attendant-ministry"], function () {
    $controller = "AttendantMinistryController";
    Route::get("/filter", "{$controller}@filter");
  });

  Route::group(["prefix" => "template-generator"], function () {
    $controller = "TemplateGeneratorController";
    Route::get("/tables", "{$controller}@getTables");
    Route::get("/definitions", "{$controller}@getDefinitions");
  });

  Route::group(["prefix" => "ministry"], function () {
    $controller = "MinistryController";
    Route::get("/", "{$controller}@index");
    Route::get("/filter", "{$controller}@filter");
    Route::get("/{id}", "{$controller}@show");
    Route::post("/", "{$controller}@create");
    Route::put("/{id}", "{$controller}@update");
    Route::delete("/{id}", "{$controller}@delete");
  });

  Route::group(["prefix" => "ministry-leader"], function () {
    $controller = "MinistryLeaderController";
    Route::get("/my", "{$controller}@my");
  });

  Route::group(["prefix" => "church-service"], function () {
    $controller = "ChurchServiceController";
    Route::get("/", "{$controller}@index");
    Route::get("/filter", "{$controller}@filter");
    Route::get("/{id}", "{$controller}@show");
    Route::post("/", "{$controller}@create");
    Route::post("/generate", "{$controller}@generate");
    Route::put("/{id}", "{$controller}@update");
    Route::delete("/{id}", "{$controller}@delete");
  });

  Route::group(["prefix" => "church-service-attendant"], function () {
    $controller = "ChurchServiceAttendantController";
    Route::put("/{id}", "{$controller}@update");

  });

  // Route::group(["prefix" => "sky-registration"], function () {
  //   $controller = "SkyRegistrationController";
  //   Route::get("/{id}", "{$controller}@show");

  // });

  Route::group(["prefix" => "texting"], function () {
    $controller = "TextingController";
    Route::post("/", "{$controller}@create");

  });

  Route::group(["prefix" => "exercises"], function () {
    $controller = "ExerciseController";
    Route::get("/", "{$controller}@index");
    Route::get("/filter", "{$controller}@filter");
    // Route::get("/muscle/filter", "{$controller}@getByMuscle");
    Route::get("/{id}", "{$controller}@show");
    Route::post("/", "{$controller}@store");
    Route::put("/{id}", "{$controller}@update");
    Route::delete("/{id}", "{$controller}@destroy");
  });

  Route::group(["prefix" => "workouts"], function () {
    $controller = "WorkoutController";
    Route::get("/", "{$controller}@index");
    Route::get("/{id}", "{$controller}@show");
    Route::post("/", "{$controller}@store");
    Route::put("/{id}", "{$controller}@update");
    Route::delete("/{id}", "{$controller}@destroy");
  });

}); // ["middleware" => ['jwt.verify']

// public
// Registro de personas a casas de fe
Route::group(["prefix" => "faith-house-membership"], function () {
  $controller = "FaithHouseMembershipController";
  Route::post("/", "{$controller}@create");
});

// registro de niños y QR
Route::group(["prefix" => "sky-registration"], function () {
  $controller = "SkyRegistrationController";
  Route::post("/", "{$controller}@create");

});

Route::group(["prefix" => "church-service"], function () {
  $controller = "ChurchServiceController";
  Route::get("/", "{$controller}@index");
});
Route::group(["prefix" => "ministry"], function () {
  $controller = "MinistryController";
  Route::get("/", "{$controller}@index");
});

Route::group(["prefix" => "bible"], function () {
  $controller = "BibleController";
  Route::get("/", "{$controller}@index");
});

Route::group(["prefix" => "bible-book"], function () {
  $controller = "BibleBookController";
  Route::get("/", "{$controller}@index");
});

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

// Route::group(["prefix" => "investor-profile"], function () {
Route::controller(InvestorProfileController::class)->prefix('investor-profile')->group(function () {
  // $controller = "InvestorProfileController";
  Route::get("/my", "myIndex");
  Route::post("/my", "myUpdate");
});

Route::controller(CreditController::class)->prefix('credit')->group(function () {
  Route::get('/amortization-table', 'amortizationTable');
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
