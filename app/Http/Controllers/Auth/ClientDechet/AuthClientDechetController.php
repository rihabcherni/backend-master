<?php

namespace App\Http\Controllers\Auth\ClientDechet;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Client_dechet;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AuthClientDechetController extends BaseController{
    public function registerClientDechet(Request $request){
        $validator= Validator::make($request->all(), [
            'nom_entreprise' => 'required',
            'matricule_fiscale' => 'required',
            'nom_responsable' => 'required',
            'adresse' => 'required',
            'numero_fixe' => 'required',
            'numero_telephone' => 'required',
            'email' => 'required|string|email|max:255|unique:client_dechets',
            'mot_de_passe' => 'required|string|min:8',
        ]);
        if($validator->fails()){
            return $this->handleError('Validation error.', $validator->errors(), 400);
        }
        $input = $request->all();
        $input['QRcode'] = Hash::make($input['email']);
        $input['mot_de_passe'] = Hash::make($input['mot_de_passe']);
        $client = Client_dechet::create($input);
        $client=Client_dechet::where('email',$request->email)->first();
        $success['nom_entreprise'] =  $client->nom_entreprise;
        $success['matricule_fiscale'] =  $client->matricule_fiscale;
        $success['QRcode'] = $client->QRcode;
        $success['adresse'] =  $client->adresse;
        $success['nom_responsable'] =  $client->nom_responsable;
        $success['numero_telephone'] =  $client->numero_telephone;
        $success['numero_fixe'] =  $client->numero_fixe;
        $success['email'] =  $client->email;
        $success['created_at'] =  $client->created_at->format('d/m/y H:i:s');
        return $this->handleResponse($success, 'client successfully registered!');
    }

    public function loginClientDechet(Request $request){
        $validator= Validator::make($request->all(),[
            'email' =>['required','email','exists:client_dechets'],
            'mot_de_passe'=>['required', 'string'],
            'device_name' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['validation_errors' =>$validator->errors()]);
        }

        $client=Client_dechet::where('email',$request->email)->first();
        if(Auth::guard('client_dechet') && (Hash::check($request->mot_de_passe,  $client->mot_de_passe)) ){

            return response()->json([
                'status'=>200,
                'email'=>$client->email,
                'token'=> $client->createToken('client-dechet-login')->plainTextToken,
                'message' =>'client vous avez connecté avec success',
            ],200);
        }else{
            return response()->json(['error' => 'Invalid credentials'],401);
     }
    }

    public function logoutClientDechet(){
        $user=auth()->guard('client_dechet')->user();
        if($user !=null){
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            return response([
                'status' => 200,
                'message' =>'client dechet vous avez logout avec success',
            ]);
        }
    }


    public function qrlogin($qrcode){
        $client = Client_dechet::where('QRcode',$qrcode)->first();
        if(!$client){
            return response([
                    'message' => 'invalid qr'
            ] , 401);
        }
        return response([
            'user' => $client,
            'token'=> $client->createToken('client-dechet-login')->plainTextToken,
        ],200);
    }

    public function allClientDechets(){
        $client = Client_dechet::all();
        return response([
            'client_dechets' => $client
        ]);
    }

    public function modifierProfileClientDechet(Request $request, $id){
        $client = Client_dechet::find($id);
        if(!$client){
            return response([
                'message' => 'undefenied client',
            ],404);
        }
        $client->update($request->all());
        return response([
            'client' => $client,
        ]);
    }

    public function modifierPasswordClientDechet (Request $request , $email){
        $client=Client_dechet::where('email',$email)->first();

        if(Auth::guard('client') && (Hash::check($request->mot_de_passe, $client->mot_de_passe)) ){
                $client['mot_de_passe'] = Hash::make($request->newPassword);
                $client->save();
                return response([
                    'message'=>'password updated'
                ],200);
            }

        return response([
            'message' => 'incorrect password'
        ],403);
    }
    public function sendFirstPassword(Request $request){
        $clientDechet = Client_dechet::where('email',$request->email)->first();
        if($clientDechet){
            $mail_message = 'client dechet votre mot de passe est ';
            $pass = Str::random(8);
            $mail_message .= $pass ;
            $mail_data =[
                'recipient'=> 'arijcherni001@gmail.com',
                'fromEmail' =>$clientDechet->email ,
                'fromName' => $clientDechet->name,
                'subject' => 'nouveau mot de passe',
                'body' => $mail_message,
            ];
            Mail::send('email-template' ,$mail_data , function($message) use ($mail_data){
                $message->from($mail_data['fromEmail'], $mail_data['fromName'] );
                $message->to($mail_data['recipient'], 'ReSchool')
                ->subject($mail_data['subject']);
            });
            $clientDechet['mot_de_passe'] = Hash::make($pass);
            $clientDechet->save();
            return response([$clientDechet],200);
        }

        return response([],404);

    }



}
