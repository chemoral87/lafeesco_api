<?php

namespace App\Http\Controllers;

use App\Models\InvestorProfile;
use App\Models\InvestorVerification;
use App\Models\User;
use App\Notifications\InvestorVerificationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Notification;

class InvestorController extends Controller {

  public function newinvest(Request $request) {
    $email = $request->email;
    Log::info($email);
    $user = User::where("email", $email)->first();
    if ($user == null) {
      Log::info("create user");
      // create user for investor
      $user = User::create([
        'name' => $request->name,
        'last_name' => $request->last_name,
        'second_last_name' => $request->second_last_name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'birthday' => $request->birthday,
        'cellphone' => $request->cellphone,
      ])->sendEmailVerificationNotification();
// https://medium.com/cs-code/laravel-email-verification-apis-9c9e8a46ab03
    }
    Log::info($user);
    InvestorProfile::create([
      'investor_id' => $user->id,
      'status_id' => 1, // incompleto
    ]);
    return ['success' => __('messa.investor_create')];
  }

  public function sendVerificationCode(Request $request) {

    $email = $request->email;

    $verification = InvestorVerification::where("email", $email)->first();

    if ($verification == null) {

      $code = createVerificationCode(6);
      $verification = InvestorVerification::create([
        'email' => $email,
        'verification_code' => $code,
      ]);

    }
    $data = [
      'code' => $verification->verification_code,
    ];
    Notification::route("mail", $email)
      ->notify(new InvestorVerificationNotification($data));

    return ['success' => __('messa.investor_verification_code_send')];
  }

  public function verifyCode(Request $request) {
    Log::info($request);
    $email = $request->email;
    $verification_code = $request->verification_code;
    $verification = InvestorVerification::where("email", $email)->where("verification_code", $verification_code)->first();
    if (!($verification == null)) {
      return ['success' => __('messa.investor_verified')];
    }
  }

  public function create() {
    //
  }

  public function store(Request $request) {
    //
  }

  public function show(InvestorProfile $investorProfile) {
    //
  }

  public function edit(InvestorProfile $investorProfile) {
    //
  }

  public function update(Request $request, InvestorProfile $investorProfile) {
    //
  }

  public function destroy(InvestorProfile $investorProfile) {
    //
  }
}
