<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;
use Symfony\Component\HttpFoundation\Response;

class ChangePasswordController extends Controller
{

    public function process(ChangePasswordRequest $request)
    {
        return $this->getPasswordResetTableRow($request)->count() ? $this->changePassword($request) : $this->tokenNotFoundResponse();
    }

    private function getPasswordResetTableRow($request)
    {
        return DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->resetToken
            ]);
    }


    private function tokenNotFoundResponse()
    {
        return response()->json(
            ['errors' => 'Token or email is incorrect.'],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    private function changePassword($request)
    {
        $user = User::where('email', $request->email)->first();

        $user->update(['password' => $request->password]);
        $this->getPasswordResetTableRow($request)->delete();

        return response()->json(['data' => 'Success!'], Response::HTTP_CREATED);
    }

}
