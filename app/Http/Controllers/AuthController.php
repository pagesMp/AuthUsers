<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request){
        try {
            $validator = Validator::make($request->all(),
                [
                    'name' => 'required|string|max:25',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6|max:25|regex:/[#$%^&*()+=!?¿.,:;]/i',
                ]);
    
                if($validator->fails()){
                    return response()->json(

                        [
                            'success'=> true,
                            'message' => $validator->errors()
                        ],
                        400
                    );
                }
    
                $user = User::create(
                    [
                        'name' => $request->get('name'),
                        'email' => $request->get('email'),
                        'password' => bcrypt($request->password)
                    ]
                );
                
                $user->roles()->attach(1);

                $token = JWTAuth::fromUser($user);
                return response()->json(compact('user','token'),201);

        }catch(\Exception $exception){
            Log::error('Error to create user'. $exception->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error to create user'
                    
                ],
            404
            );
        };
    }

    public function login(Request $request){
    
        $input = $request->only('email', 'password');
        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Invalid Email or Password',
                ], Response::HTTP_UNAUTHORIZED
            );
        }
        return response()->json([
            'success' => true,
            'token' => $jwt_token,
        ]);
    }

    public function logout(Request $request){
        try {

            $this->validate($request,
                [
                    'token' => 'require'
                ]);

            JWTAuth::invalidate($request->token);
            return response()->json(
                [
                    'success' => true,
                    'token' => 'You have successfully logged out'
                ]);

        } catch (\Exception $exception) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'You cant logout because you are not logged yet'
                ],
            404
            );
            
        }

    }
    
    public function profile(){
        return response()->json(
            [
            "susccess" => true,
            "data" => auth()->user()
            ]
        );
    }

    public function update(Request $request, $id){

        try {
            $user = User::query()->find($id);

            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');

            if(isset($name)){
                $user->name = $name;               
            };

            if(isset($email)){
                $user->email = $email;               
            };

            if(isset($password)){
                $user->password = bcrypt($password);               
            };

            $user->save();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'you have modifcate your profile successfully'
                ],
            200
            );

        }catch (\Exception $exception) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'You cant modify you profile'
                ],
            404
            );
        }
    }

}
