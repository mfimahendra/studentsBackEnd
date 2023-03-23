<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;;


use App\Models\User;

class PassportAuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
  
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
  
        $token = $user->createToken('Laravel-9-Passport-Auth')->accessToken;
  
        return response()->json(['token' => $token], 200);
    }
  
    /**
     * Login Req
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
      
        if (auth()->attempt($data)) {            
            
            $token = auth()->user()->createToken('Laravel-Passport-Auth')->accessToken;                        


            $response = [
                'status' => '200',
                'message' => 'Login Successful',
                'token' => $token,
            ];
            
            return response()->json($response, 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
 
    public function userInfo() 
    {
 
        $user = auth()->user();

        $response = [
            'status' => '200',
            'message' => 'User Info',
            'data' => $user,
        ];
    
        return response()->json($response);
    }

    public function logout(Request $request) 
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
