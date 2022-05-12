<?php

namespace App\Http\Controllers\Auth\Ouvrier;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\GestionCompte\OuvrierRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Ouvrier;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AuthOuvrierController extends BaseController{
    public function registerOuvrier(Request $request){
        $validator= Validator::make($request->all(), [
            'zone_travail_id'=>'required',
            'camion_id'=>'required',
            'poste'=>'required',
            'nom' => 'required',
            'prenom' => 'required',
            'adresse' => 'required',
            'photo' => 'nullable',
            'CIN' => 'required',
            'numero_telephone' => 'required',
            'email' => 'required|string|email|max:255|unique:ouvriers',
            'mot_de_passe' => 'required|string|min:8',
        ]);
        if($validator->fails()){
            return $this->handleError('Validation error.', $validator->errors(), 400);
        }
        $input = $request->all();
        $input['QRcode'] = Hash::make($input['email']);
        $input['mot_de_passe'] = Hash::make($input['mot_de_passe']);
        $ouvrier = Ouvrier::create($input);
        $ouvrier=Ouvrier::where('email',$request->email)->first();
        $success['zone_travail_id'] =  $ouvrier->zone_travail_id;
        $success['camion_id'] =  $ouvrier->camion_id;
        $success['poste'] =  $ouvrier->poste;
        $success['QRcode'] =  $ouvrier->QRcode;
        $success['prenom'] =  $ouvrier->prenom;
        $success['adresse'] =  $ouvrier->adresse;
        $success['CIN'] =  $ouvrier->CIN;
        $success['numero_telephone'] =  $ouvrier->numero_telephone;
        $success['email'] =  $ouvrier->email;
        $success['mot_de_passe'] =  $ouvrier->mot_de_passe;
        $success['created_at'] =  $ouvrier->created_at->format('d/m/y H:i:s');
        return $this->handleResponse($success, 'ouvrier successfully registered!');
    }

    public function loginOuvrier(Request $request){
        $validator= Validator::make($request->all(),[
            'email' =>['required','email','exists:ouvriers'],
            'mot_de_passe'=>'required|string',
            'device_name' => 'required',
        ]);
        if($validator->fails()){
        return response()->json(['validation_errors' =>$validator->errors()]);
        }
        $ouvrier=Ouvrier::where('email',$request->email)->first();

        if(Auth::guard('ouvrier') && (Hash::check($request->mot_de_passe,  $ouvrier->mot_de_passe)) ){
            return response()->json([
                'status'=>200,
                'email'=>$ouvrier->email,
                'token'=> $ouvrier->createToken('ouvrier_login')->plainTextToken,
                'message' =>'ouvrier vous avez connecté avec success',
        ]);
        }else{
            return response()->json(['status'=>401,'validation_credentials' =>"Invalid credentials"]);
     }
    }

    public function logoutOuvrier(){
        if(Auth::guard('ouvrier')){
            $user = request()->user();
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            return response([
                'status' => 200,
                'message' =>'ouvrier vous avez logout avec success',
            ]);
        }
    }
    public function qrlogin($qrcode){
        $ouvrier = Ouvrier::where('QRcode',$qrcode)->first();
        if(!$ouvrier){
            return response([
                    'message' => 'invalid qr'
            ] , 401);
        }
        return response([
            'user' => $ouvrier,
            'token'=> $ouvrier->createToken('ouvrier_login_qr')->plainTextToken,
        ],200);
    }

    public function allOuvriers(){
        $ouvrier = Ouvrier::all();
        return response([
            'ouvrier' => $ouvrier
        ]);
    }

    public function modifierProfileOuvrier(Request $request, $id){
        $ouvrier = Ouvrier::find($id);
        if(!$ouvrier){
            return response([
                'message' => 'undefenied ouvrier',
            ],404);
        }
        $ouvrier->update($request->all());
        return response([
            'ouvrier' => $ouvrier,
        ]);
    }

    public function modifierPasswordOuvrier (Request $request , $email){
        $ouvrier=Ouvrier::where('email',$email)->first();

        if(Auth::guard('ouvrier') && (Hash::check($request->mot_de_passe, $ouvrier->mot_de_passe)) ){
                $ouvrier['mot_de_passe'] = Hash::make($request->newPassword);
                $ouvrier->save();
                return response([
                    'message'=>'password updated'
                ],200);
            }

        return response([
            'message' => 'incorrect password'
        ],403);
    }

    public function sendFirstPassword(Request $request){
        $ouvrier = Ouvrier::where('email' , $request->email)->first();
        if($ouvrier){
            $mail_message = 'Ouvrier votre mot de passe est ';
            $pass = Str::random(8);
            $mail_message .= $pass ;
            $mail_data =[
                'recipient'=> 'arijcherni001@gmail.com',
                'fromEmail' =>$ouvrier->email ,
                'fromName' => $ouvrier->name,
                'subject' => 'nouveau mot de passe',
                'body' => $mail_message,
            ];
            Mail::send('email-template' ,$mail_data , function($message) use ($mail_data){
                $message->from($mail_data['fromEmail'], $mail_data['fromName'] );
                $message->to($mail_data['recipient'], 'ReSchool')
                ->subject($mail_data['subject']);
            });
            $ouvrier['mot_de_passe'] = Hash::make($pass);
            $ouvrier->save();
            return response([$ouvrier],200);
        }

        return response([],404);

    }

    public function updateImage(Request $request){
        $request->validate([
            'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $ouvrier=auth()->guard('ouvrier')->user();
        
        if($ouvrier !=null){
            
            if($request->hasFile('photo')){
                $image = $request->file('photo');
                $destinationPath = 'storage/images/ouvrier';
                $destination = 'storage/images/ouvrier/'.$ouvrier->photo;
                if(File::exists($destination)){
                    File::delete($destination);
                }
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['photo'] = $profileImage;
                $ouvrier['photo'] =$input['photo'];
                $ouvrier->save();
                return response([
                    'status' => 200,
                    'client_dechet' =>$ouvrier,
                ]);
            }
            return response([
                'status' => 404,
                'photo' =>'error',
            ]);
        }
    }

    public function sendImage(){
        $ouvrier=auth()->guard('ouvrier')->user();
        
        if($ouvrier !=null){
            if($ouvrier->photo!=null){
                $destination = 'storage/images/ouvrier/'.$ouvrier->photo;
                return response([
                    "url"=>$destination
                ],200);
            }
            return response([
                "photo"=>null
            ],200);
        }
        return response([
            'msg' =>$ouvrier
        ]);
    }

    public function destroyImage(){
        $ouvrier=auth()->guard('ouvrier')->user();
        
        if($ouvrier !=null){
            
            $destination = 'storage/images/ouvrier/'.$ouvrier->photo;
                if(File::exists($destination)){
                    File::delete($destination);
                    $ouvrier->photo = null;
                    $ouvrier->save();
                }
                return response([
                    'status' => 200,
                    'client_dechet' =>$ouvrier,
                ]);
        }
    }
}
