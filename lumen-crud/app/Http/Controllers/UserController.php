<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use Firebase\JWT\Key;
use Exception;
use Illuminate\Support\Facades\Mail;

class UserController extends BaseController 
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }


    public function showList(Request $request)
    {
         $users = User::all();
         return response()->json($users);
    }

    public function createNewUser(Request $request)
    {
        $response = $this->validate(
            $request, [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required'
            ]
        );
        
        $str = rand();
        $token = md5($str);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->reset_token = $token;
        $user->save();
        
        if($user->save())
        {
            $response = response()->json(
                [
                    'response' => [
                        'created' => true
                    ]
                ], 201
            );
        }
        return $response;
    }

    /**
     * Create a new token.
     * 
     * @param  \App\User   $user
     * @return string
     */
    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60*60*60 // Expiration time
        ];
        // As you can see we are passing `JWT_SECRET` as the second parameter that will 
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    } 

    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     * 
     * @param  \App\User   $user 
     * @return mixed
     */
    public function loginUser(User $user) {
        $this->validate($this->request, [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        // Find the user by email
        $user = User::where('email', $this->request->input('email'))->first();

        if (!$user) {
            return response()->json([
                'email' => 'Email does not exist.'
            ], 400);
        }

        // Verify the password and generate the token
        if (Hash::check($this->request->input('password'), $user->password)) {
            return response()->json([
                'token' => $this->jwt($user)
            ], 200);
        }

        // Bad Request response
        return response()->json([
            'password' => 'Password is wrong.'
        ], 400);
    }

    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     * 
     * @param  \App\User   $user 
     * @return mixed
     */
    public function isValidToken(Request $request)
    {
        $token = $request->header('token');
        if(!$token) {
            // Unauthorized response if token not there
            return response()->json(false, 401);
        }
        try {
            JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256') );
        } catch(Exception $e) {
            return response()->json(false, 401);
        }
        return response()->json(true);
    }


    public function forgotPassword(Request $request)
    {
        $this->validate($this->request, [
            'email'     => 'required|email'
        ]);

        // Find the user by email
        $user = User::where('email', $this->request->input('email'))->first();
        if (!$user) {
            return response()->json([
                'email' => 'Email does not exist.'
            ], 400);
        }

          // Create the reset URL
        $resetUrl = url('http://localhost:4200/password/reset/' . $user->reset_token);

        // Send the reset email
        // Mail::send('emails.password_reset', ['resetUrl' => $resetUrl], function ($message) use ($request) {
        //     $message->to($request->email);
        //     $message->subject('Password Reset');
        // });
        //return response()->json(true);
        return response()->json(['resetUrl' => $resetUrl]);
    }

    public function resetPassword(Request $request)
    {

         $response = $this->validate(
            $request, [
                'password' => 'required',
                'reset_token' => 'required'
            ]
        );

        $reset_token = $request->reset_token;

        if($reset_token == 0)
        {
            $response =  response()->json([
                'response' => 'Invalid url.'
            ], 400);
        }

        // Find the user by token
        $user = User::where('reset_token', $reset_token)->select('id')->first();
        if (!$user) {   
            $response =  response()->json([
                'response' => 'Invalid url.'
            ], 400);
        }

        if(isset($user))
        {
            $user->password = Hash::make($request->input('password'));
            $user->save();
            $response =  response()->json([
                'response' => 'Password reset successfully.'
            ], 201);
        } 
        else
        {
            $response =  response()->json([
                'response' => 'Invalid url.'
            ], 400);
        }
        return $response;
    }

}