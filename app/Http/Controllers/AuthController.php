<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller {
  /* public function register(UserRegisterRequest $request) {

  $user = User::create([
  'email' => $request->email,
  'name' => $request->name,
  'password' => bcrypt($request->password),
  ]);

  if (!$token = auth()->attempt($request->only(['email', 'password']))) {
  return abort(401);
  }

  return (new UserResource($request->user()))->additional([
  'meta' => [
  'access_token' => $token,
  'expires_in' => auth()->factory()->getTTL() * 60,
  'token_type' => 'bearer',
  ],
  ]);
  } */

  public function login() {
    $credentials = request(['email', 'password']);

    if (!$token = auth()->attempt($credentials)) {
      // trans('auth.failed');
      return response()->json(['errors' => [
        'password' => trans('auth.failed'),
      ]], 401);
      // return response()->json(['error' => 'Unauthorized'], 401);
    }

    return $this->respondWithToken($token);
  }

  public function me() {
    // return new UserResource(auth()->user());
    return response()->json(
      new UserResource(auth()->user())
    );
  }

  public function logout() {
    auth()->logout();

    return response()->json(['message' => 'Successfully logged out']);
  }

  public function refresh() {
    // refresh token
    return $this->respondWithToken(auth()->refresh());
  }

  protected function respondWithToken($token) {
    return response()->json([
      'access_token' => $token,
      'token_type' => 'bearer',
      //'expires_in' => auth()->factory()->getTTL() * 60,
      'expires_in' => auth('api')->factory()->getTTL() * 60,
    ]);
  }

}
