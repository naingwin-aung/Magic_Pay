<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helper\AccountNumberGenerate;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->ip = $request->ip();
            $user->user_agent = $request->server('HTTP_USER_AGENT');
            $user->login_at = Carbon::now();
            $user->save();

            Wallet::firstOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'account_number' => AccountNumberGenerate::accountNumber(),
                    'amount' => 0,
                ]
            );

            DB::commit();
            
            $token = $user->createToken('Magic Pay')->accessToken;
            return success('Successfully Register', ['token' => $token]);

        } catch (Exception $e) {
            DB::rollback();
            return fail('Register Fail', null);
        }
    }

    public function login(LoginRequest $request)
    {
        if(Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            $user = Auth::user();
            $user->ip = $request->ip();
            $user->user_agent = $request->server('HTTP_USER_AGENT');
            $user->login_at = Carbon::now();
            $user->update();

            $token = $user->createToken('Magic Pay')->accessToken;
            return success('Successfully Login', ['token' => $token]);
        }
        
        return fail('Login Fail', null);
    }

    public function logout()
    {
        $user = Auth::user()->token();  
        $user->revoke();
        return success('Successfully logout', null);
    }
}
