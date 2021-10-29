<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials'], 401);
        }
        auth()->user()->tokens()->delete();

        $abilities = auth()->user()->getAllPermissions()->filter(function ($permission) {
            return false !== stristr($permission->name, 'api-');
        })->pluck('name')->toArray();

        $userToken = auth()->user()->createToken('authToken',$abilities);
        $plainTextToken = $userToken->plainTextToken;
        $expiration_minutes = config('sanctum.expiration');
        $expiration_seconds = -1;
        if(!empty($expiration_minutes)){
            $expiration_seconds = $expiration_minutes*60 - 1;
        }
        return response(["token_type" => "Bearer",
                         "abilities"  => $userToken->accessToken->abilities,
                         "expires_in" => $expiration_seconds,
                         "access_token" => Str::of($plainTextToken)->explode('|')[1]], 200);

    }
}
