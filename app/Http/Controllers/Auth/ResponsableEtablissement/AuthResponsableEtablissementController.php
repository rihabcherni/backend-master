<?php

namespace App\Http\Controllers\Auth\ResponsableEtablissement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\GestionCompte\ResponsableEtablissementRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Responsable_etablissement;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AuthResponsableEtablissementController extends BaseController{
    public function registerResponsableEtablissement(Request $request){
        $validator= Validator::make($request->all(), [
            'nom_etablissement' => 'required',
            'nom_responsable' => 'required',
            'adresse' => 'required',
            'numero_fixe' => 'required',
            'numero_telephone' => 'required',
            'email' => 'required|string|email|max:255|unique:responsable_etablissements',
            'mot_de_passe' => 'required|string|min:8',
        ]);
        if($validator->fails()){
            return $this->handleError('Validation error.', $validator->errors(), 400);
        }
        $input = $request->all();
        $input['QRcode'] = Hash::make($input['email']);
        $input['mot_de_passe'] = Hash::make($input['mot_de_passe']);
        $responsable = Responsable_etablissement::create($input);
        $responsable=Responsable_etablissement::where('email',$request->email)->first();
        $success['nom_etablissement'] =  $responsable->nom_etablissement;
        $success['nom_responsable'] =  $responsable->nom_responsable;
        $success['adresse'] =  $responsable->adresse;
        $success['numero_fixe'] =  $responsable->numero_fixe;
        $success['numero_telephone'] =  $responsable->numero_telephone;
        $success['email'] =  $responsable->email;
        $success['QRcode'] = $responsable->QRcode;
        $success['created_at'] =  $responsable->created_at->format('d/m/y H:i:s');
        return $this->handleResponse($success, 'responsable successfully registered!');
    }

    public function loginResponsableEtablissement(Request $request){
        $validator= Validator::make($request->all(),[
            'email' =>['required','email','exists:responsable_etablissements'],
            'mot_de_passe'=>['required', 'string']
        ]);
        if($validator->fails()){
        return response()->json(['validation_errors' =>$validator->errors()],401);
        }

        $responsable=Responsable_etablissement::where('email',$request->email)->first();


        if(Auth::guard('responsable_etablissement') && (Hash::check($request->mot_de_passe, $responsable->mot_de_passe)) ){
            return response()->json([
                'status'=>200,
                'email'=>$responsable->email,
                'token'=>$responsable->createToken('responsable-etablissement-login')->plainTextToken,
                'message' =>'responsable etablissement vous avez connecté avec success',
            ],200);
        }else{
            return response()->json(['status'=>401,'validation_credentials' =>"Invalid credentials"]);
     }
    }
    public function qrlogin($qrcode){
        $responsable = Responsable_etablissement::where('QRcode',$qrcode)->first();
        if(!$responsable){
            return response([
                    'message' => 'invalid qr'
            ] , 401);
        }
        return response([
            'user' => $responsable,
            'token'=> $responsable->createToken('responsable-etablissement-login')->plainTextToken,
        ],200);
    }

    public function logoutResponsable(){
        if(Auth::guard('responsable_etablissement')){
            $user = request()->user(); //or Auth::user()
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            return response([
                'status' => 200,
                'message' =>'responsable vous avez logout avec success',
            ]);
        }
    }

    public function allResponsableEtablissement(){
        $responsable = Responsable_etablissement::all();
        return response([
            'responsable_etablissements' => $responsable
        ]);
    }

    public function modifierProfileResponsableEtablissement(Request $request, $id){
        $reponsable = Responsable_etablissement::find($id);
        if(!$reponsable){
            return response([
                'message' => 'undefenied reponsable',
            ],404);
        }
        $reponsable->update($request->all());
        return response([
            'reponsable' => $reponsable,
        ]);
    }

    public function modifierPasswordResponsableEtablissement (Request $request , $email){
        $reponsable=Responsable_etablissement::where('email',$email)->first();

        if(Auth::guard('reponsable') && (Hash::check($request->mot_de_passe, $reponsable->mot_de_passe)) ){
                $reponsable['mot_de_passe'] = Hash::make($request->newPassword);
                $reponsable->save();
                return response([
                    'message'=>'password updated'
                ],200);
            }

        return response([
            'message' => 'incorrect password'
        ],403);
    }

    public function sendFirstPassword(Request $request){
        $responsable = Responsable_etablissement::where('email',$request->email)->first();
        if($responsable){
            $mail_message = 'responsable etablissement votre mot de passe est ';
            $pass = Str::random(8);
            $mail_message .= $pass ;
            $mail_data =[
                'recipient'=> 'arijcherni001@gmail.com',
                'fromEmail' =>$responsable->email ,
                'fromName' => $responsable->name,
                'subject' => 'nouveau mot de passe',
                'body' => $mail_message,
            ];
            Mail::send('email-template' ,$mail_data , function($message) use ($mail_data){
                $message->from($mail_data['fromEmail'], $mail_data['fromName'] );
                $message->to($mail_data['recipient'], 'ReSchool')
                ->subject($mail_data['subject']);
            });
            $responsable['mot_de_passe'] = Hash::make($pass);
            $responsable->save();
            return response([$responsable],200);
        }

        return response([],404);

    }


}
