<?php

namespace App\Http\Controllers\Authentification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends BaseController{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $input['remember_token'] =$user->createToken('secret')->plainTextToken;

        $success['token'] =  $input['remember_token'];
        $success['name'] =  $user->name;
        $success['email'] =  $user->email;
        $success['password'] =  $user->password;
        $success['created_at'] =  $user->created_at->format('d/m/y H:i:s');

        return $this->handleResponse($success, 'User successfully registered!');
    }
    public function login(Request $request){
        $attrs = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
         $remember_me = $request->has('remember_me') ? true : false;

        if(!Auth::attempt($attrs,$remember_me)){
            return response([
                'message' => 'Invalid credentials',
            ],403);
        }
        return response([
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('secret')->plainTextToken
        ],200);
    }
    public function logout(){
        $user = request()->user(); //or Auth::user()
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return response([
        'message' =>'You have successfully logged out and the token was successfully deleted',
        ],200);
    }
    public function profile(){
        $users = User::find(Auth::user()->id);
        return response([
            'user' => $users
        ]);
    }
    public function allUser(){
        $client = User::all();
        return response([
            'user' => $client
        ]);
    }

    public function update(Request $request, $id){
        $user = User::find($id);
        if(!$user){
            return response([
                'message' => 'undefenied user',
            ],404);
        }
        $user->update( $request ->all());
        return response([
            'user' => $user,
        ]);
    }

    public function qrlogin(Request $request,$email){
        $test = User::where('email',$email)->first();
        if(!$test){
            return response([
                    'message' => 'invalid qr'
            ] , 403);
        }
        return response([
            'user' => $test,
            'token' => auth()->user()->createToken('secret')->plainTextToken
        ],200);
    }

    public function updatePassword (Request $request , $id){
        $user =User::find($id);

        $password = $user->password;
        if($user){
            if (Hash::check($request->oldPassword, $password)){

                $user['password'] = Hash::make($request->newPassword);
                $user->save();
                return response([
                    'message'=>'password updated'
                ],200);
            }
        }
        return response([
            'message' => 'incorrect password'
        ],403);
    }

    public function sendFirstPassword(Request $request){

        $user = User::where('email' , $request->email)->first();
        if($user){
            $mail_message = ' votre nouveu mot de passe est ';
            $pass = Str::random(5);
            $mail_message .= $pass ;
            $mail_data =[
                'recipient'=> 'mohamed72291@gmail.com',
                'fromEmail' =>$user->email ,
                'fromName' => $user->name,
                'subject' => 'nouveau mot de passe',
                'body' => $mail_message,
            ];
            Mail::send('email-template' ,$mail_data , function($message) use ($mail_data){
                $message->from($mail_data['fromEmail'], $mail_data['fromName'] );
                $message->to($mail_data['recipient'], 'ReSchool')
                ->subject($mail_data['subject']);
            });
            $user['password'] = Hash::make($pass);
            $user->save();
            return response([$user],200);
        }

        return response([],404);

    }

}
