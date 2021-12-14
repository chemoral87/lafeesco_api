<?php

namespace App\Http\Controllers;

use App\Models\ContractReturn;
use App\Models\Investment;
use App\Models\InvestorProfile;
use App\Models\InvestorVerification;
use App\Models\User;
use App\Notifications\InvestorVerificationNotification;
use App\Notifications\InvestorVerifiedNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Notification;
use Spatie\Permission\Models\Role;

class InvestorController extends Controller {

  public function newinvest(Request $request) {
    $email = $request->email;
    $user = User::where("email", $email)->first();
    if ($user == null) {
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
    $email = $request->email;
    $name = $request->name;
    $last_name = $request->last_name;
    $second_last_name = $request->second_last_name;
    $password = $request->password;
    $capital = $request->capital;
    $birthday = $request->birthday;
    $cellphone = $request->cellphone;

    $verification_code = $request->verification_code;
    $verification = InvestorVerification::where("email", $email)->where("verification_code", $verification_code)->first();
    if (isset($verification)) {
      if (is_null($verification->verification_date)) {

        // crear usuario, si no existe
        $user = User::where('email', $email)->first();
        if (is_null($user)) {
          $user = User::create([
            'name' => $name,
            'last_name' => $last_name,
            'second_last_name' => $second_last_name,
            'email' => $email,
            'password' => Hash::make($password),
            'birthday' => $birthday,
            'cellphone' => $cellphone,
          ]);
        }
        // asignar role investor
        $investorRole = Role::where("name", "investor")->first();
        $user->assignRole($investorRole);
        // create invest
        $contractReturn = ContractReturn::where('min_capital', '<=', $capital)->orderBy('min_capital', 'desc')->first();
        $yield = $contractReturn->yield;
        Investment::create([
          'contract_date' => Carbon::now(),
          'status_date' => Carbon::now(),
          'status_id' => 1,
          'yield' => $yield,
          'months' => 12, // anual
          'investor_id' => $user->id,
          'created_by' => $user->id,
        ]);

        $verification->verification_date = Carbon::now();
        $verification->save();
        //  successful register notification
        $user->notify(new InvestorVerifiedNotification());
      }

      return ['success' => __('messa.investor_verified')];
    } else {
      // no existe registro
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
