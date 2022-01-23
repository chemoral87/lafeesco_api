<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler {
  /**
   * A list of the exception types that are not reported.
   *
   * @var array
   */
  protected $dontReport = [
    //
  ];

  /**
   * A list of the inputs that are never flashed for validation exceptions.
   *
   * @var array
   */
  protected $dontFlash = [
    'current_password',
    'password',
    'password_confirmation',
  ];

  // protected function unauthenticated($request, AuthenticationException $exception) {
  //   if ($request->expectsJson()) {
  //     return response()->json(['error' => 'Unauthenticated.'], 401);
  //   }
  //   return response()->json(['error' => 'Unauthenticated.'], 401);
  //   // return redirect()->guest(route('auth.login'));
  // }

  /**
   * Register the exception handling callbacks for the application.
   *
   * @return void
   */
  public function register() {
    $this->reportable(function (Throwable $e) {
      //
    });
  }

  public function render($request, Throwable $exception) {
    if ($exception instanceof ModelNotFoundException) {
      return response()->json(['message' => 'Not Found!'], 404);
    }

    return parent::render($request, $exception);
  }

}
