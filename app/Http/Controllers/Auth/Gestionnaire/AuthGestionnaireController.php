<?php
namespace App\Http\Controllers\Auth\Gestionnaire;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Gestionnaire;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AuthGestionnaireController extends BaseController{
    public function registerGestionnaire(Request $request){
        $validator= Validator::make($request->all(), [
            'nom' => 'required',
            'prenom' => 'required',
            'CIN' => 'required',
            'adresse' => 'required',
            'numero_telephone' => 'required',
            'email' => 'required|string|email|max:255|unique:gestionnaires',
            'mot_de_passe' => 'required|string|min:8',
        ]);
        if($validator->fails()){
            return $this->handleError('Validation error', $validator->errors(), 400);
        }
        $input = $request->all();
        $input['QRcode'] = Hash::make($input['email']);
        $input['mot_de_passe'] = Hash::make($input['mot_de_passe']);
        $gestionnaire = Gestionnaire::create($input);
        $gestionnaire=Gestionnaire::where('email',$request->email)->first();
        $success['nom'] =  $gestionnaire->nom;
        $success['prenom'] =  $gestionnaire->prenom;
        $success['CIN'] =  $gestionnaire->CIN;
        $success['adresse'] =  $gestionnaire->adresse;
        $success['numero_telephone'] =  $gestionnaire->numero_telephone;
        $success['email'] =  $gestionnaire->email;
        $success['mot_de_passe'] =  Crypt::encryptString($gestionnaire->mot_de_passe);
        $success['QRcode'] = $gestionnaire->QRcode;
        $success['created_at'] =  $gestionnaire->created_at->format('d/m/y H:i:s');
        return $this->handleResponse($success, 'gestionnaire successfully registered!');
    }

    public function loginGestionnaire(Request $request){
        $validator= Validator::make($request->all(),[
            'email' =>['required','email','exists:gestionnaires'],
            'mot_de_passe'=>'required|string'
        ]);
        if($validator->fails()){
        return response()->json(['validation_errors' =>$validator->errors()]);
        }

        $gestionnaire=Gestionnaire::where('email',$request->email)->first();

        if(Auth::guard('gestionnaire') && (Hash::check($request->mot_de_passe,  $gestionnaire->mot_de_passe)) ){
                return response()->json([
            'status'=>200,
            'email'=>$gestionnaire->email,
            'token'=> $gestionnaire->createToken('gestionnaire_login')->plainTextToken,
            'message' =>'gestionnaire vous avez connecté avec success',
        ]);
        }else{
            return response()->json(['status'=>401,'validation_credentials' =>"Invalid credentials"]);
     }
    }
    public function logoutGestionnaire(){

        $gestionnaire=auth()->guard('gestionnaire')->user();
        if($gestionnaire !=null){
            $gestionnaire->tokens()->where('id', $gestionnaire->currentAccessToken()->id)->delete();
            return response([
                'status' => 200,
                'message' =>'Gestionnaire vous avez logout avec success',
            ]);
        }
    }

    public function allGestionnaire(){
        $gestionnaire = Gestionnaire::all();
        return response([
            'gestionnaire' => $gestionnaire
        ]);
    }

    public function modifierProfileGetstionnaire(Request $request, $id){
        $gestionnaire = Gestionnaire::find($id);
        if(!$gestionnaire){
            return response([
                'message' => 'undefenied gestionnaire',
            ],404);
        }
        $gestionnaire->update($request->all());
        return response([
            'gestionnaire' => $gestionnaire,
        ]);
    }

    public function modifierPasswordGestionnaire (Request $request , $email){
        $gestionnaire=Gestionnaire::where('email',$email)->first();

        if(Auth::guard('gestionnaire') && (Hash::check($request->mot_de_passe, $gestionnaire->mot_de_passe)) ){
                $gestionnaire['mot_de_passe'] = Hash::make($request->newPassword);
                $gestionnaire->save();
                return response([
                    'message'=>'password updated'
                ],200);
            }

        return response([
            'message' => 'incorrect password'
        ],403);
    }

    public function sendFirstPassword(Request $request){
        $gestionnaire = Gestionnaire::where('email',$request->email)->first();
        if($gestionnaire){
            $mail_message = 'Gestionnaire votre mot de passe est ';
            $pass = Str::random(8);
            $mail_message .= $pass ;
            $mail_data =[
                'recipient'=> 'arijcherni001@gmail.com',
                'fromEmail' =>$gestionnaire->email ,
                'fromName' => $gestionnaire->name,
                'subject' => 'nouveau mot de passe',
                'body' => $mail_message,
            ];
            Mail::send('email-template' ,$mail_data , function($message) use ($mail_data){
                $message->from($mail_data['fromEmail'], $mail_data['fromName'] );
                $message->to($mail_data['recipient'], 'ReSchool')
                ->subject($mail_data['subject']);
            });
            $gestionnaire['mot_de_passe'] = Hash::make($pass);
            $gestionnaire->save();
            return response([$gestionnaire],200);
        }

        return response([],404);

    }

    public function qrlogin($qrcode){
        $gestionnaire = Gestionnaire::where('QRcode',$qrcode)->first();
        if(!$gestionnaire){
            return response([
                    'message' => 'invalid qr'
            ] , 401);
        }
        return response([
            'user' => $gestionnaire,
            'token'=> $gestionnaire->createToken('gestionnaire_login_qr')->plainTextToken,
        ],200);
    }

    public function sendImage(){
        $gestionnaire=auth()->guard('gestionnaire')->user();

        if($gestionnaire !=null){
            if($gestionnaire->photo!=null){
                $destination = 'storage/images/Gestionnaire'.$gestionnaire->photo;
                return response([
                    "url"=>$destination
                ],200);
            }
            return response([
                "photo"=>null
            ],200);
        }
        return response([
            'msg' =>$gestionnaire
        ]);
    }

    public function updateImage(Request $request){
        $request->validate([
            'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $gestionnaire=auth()->guard('gestionnaire')->user();

        if($gestionnaire !=null){

            if($request->hasFile('photo')){
                $image = $request->file('photo');
                $destinationPath = 'storage/images/Gestionnaire';
                $destination = 'storage/images/Gestionnaire/'.$gestionnaire->photo;
                if(File::exists($destination)){
                    File::delete($destination);
                }
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['photo'] = $profileImage;
                $gestionnaire['photo'] =$input['photo'];
                $gestionnaire->save();
                return response([
                    'status' => 200,
                    'client_dechet' =>$gestionnaire,
                ]);
            }
            return response([
                'status' => 404,
                'photo' =>'error',
            ]);
        }
    }

    public function destroyImage(){

        $gestionnaire=auth()->guard('gestionnaire')->user();

        if($gestionnaire !=null){
            $destination = 'storage/images/Gestionnaire/'.$gestionnaire->photo;
                if(File::exists($destination)){
                    File::delete($destination);
                    $gestionnaire->photo = null;
                    $gestionnaire->save();
                }
                return response([
                    'status' => 200,
                    'client_dechet' =>$gestionnaire,
                ]);
        }
    }
}
