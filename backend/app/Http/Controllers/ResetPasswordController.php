<?php

namespace App\Http\Controllers;

use DB;
use Str;
use Mail;
use Carbon\Carbon;
use App\Mail\ResetPasswordMail;

class ResetPasswordController extends Controller
{

    public function sendEmail()
    {
        $email = request('email');

        $this->validate(request(), ['email' => 'required|email|exists:users,email']);

        $token = $this->createToken($email);

        Mail::to($email)->send(new ResetPasswordMail($token));

        return [
            'code' => 200,
            'message' => 'Password reset link has been sent successfully!'
        ];
    }

    public function createToken($email)
    {
        if($current_token = DB::table('password_resets')->where('email', $email)->first()){
            return $current_token->token;
        }

        $token = Str::random(60);

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        return $token;
    }

}
