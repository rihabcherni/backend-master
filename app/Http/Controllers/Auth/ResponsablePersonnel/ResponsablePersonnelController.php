<?php

namespace App\Http\Controllers\Auth\ResponsablePersonnel;

use App\Models\Responsable_personnel;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class ResponsablePersonnelController extends BaseController
{
    public function registerResponsablePersonnel(Request $request){
        $validator= Validator::make($request->all(), [
            'nom'=>'required',
            'prenom'=>'required',
            'CIN'=>'required',
            'numero_telephone' => 'required',
            'email' => 'required',
            'photo' => 'nullable',
            'mot_de_passe' => 'required',
        ]);
        if($validator->fails()){
            return $this->handleError('Validation error.', $validator->errors(), 400);
        }
        $input = $request->all();
        $input['QRcode'] = Hash::make($input['email']);
        $input['mot_de_passe'] = Hash::make($input['mot_de_passe']);
        $responsable_personnel = Responsable_personnel::create($input);
        $responsable_personnel=Responsable_personnel::where('email',$request->email)->first();
        $success['nom']= $responsable_personnel->nom;
        $success['prenom']= $responsable_personnel->prenom;
        $success['mot_de_passe']= Crypt::encryptString($responsable_personnel->mot_de_passe);
        $success['photo']= $responsable_personnel->photo;
        $success['CIN']= $responsable_personnel->CIN;
        $success['email']= $responsable_personnel->email;
        $success['QRcode']= $responsable_personnel->QRcode;
        $success['numero_telephone']= $responsable_personnel->numero_telephone;
        $success['created_at'] =  $responsable_personnel->created_at->format('d/m/y H:i:s');
        return $this->handleResponse($success, 'responsable personnel successfully registered!');
    }

    public function loginResponsablePersonnel(Request $request){
        $validator= Validator::make($request->all(),[
            'email' =>['required','email','exists:responsable_personnels'],
            'mot_de_passe'=>'required|string',
            'device_name' => 'required',
        ]);
        if($validator->fails()){
        return response()->json(['validation_errors' =>$validator->errors()]);
        }
        $responsable_personnel=Responsable_personnel::where('email',$request->email)->first();

        if(Auth::guard('responsable_personnel') && (Hash::check($request->mot_de_passe,  $responsable_personnel->mot_de_passe)) ){
            return response()->json([
                'status'=>200,
                'email'=>$responsable_personnel->email,
                'token'=> $responsable_personnel->createToken('responsable_personnel_login')->plainTextToken,
                'message' =>'responsable commercial vous avez connecté avec success',
        ]);
        }else{
            return response()->json(['status'=>401,'validation_credentials' =>"Invalid credentials"]);
     }
    }

    public function logoutResponsablePersonnel(){
        if(Auth::guard('responsable_personnel')){
            $user = request()->user();
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            return response([
                'status' => 200,
                'message' =>'responsable commercial vous avez logout avec success',
            ]);
        }
    }
    public function qrlogin($qrcode){
        $responsable_personnel = Responsable_personnel::where('QRcode',$qrcode)->first();
        if(!$responsable_personnel){
            return response([
                    'message' => 'invalid qr'
            ] , 401);
        }
        return response([
            'user' => $responsable_personnel,
            'token'=> $responsable_personnel->createToken('responsable_personnel_login_qr')->plainTextToken,
        ],200);
    }

    public function allResponsableCommercials(){
        $responsable_personnel = Responsable_personnel::all();
        return response([
            'responsable_personnel' => $responsable_personnel
        ]);
    }

    public function modifierProfileResponsablePersonnel(Request $request, $id){
        $responsable_personnel = Responsable_personnel::find($id);
        if(!$responsable_personnel){
            return response([
                'message' => 'undefenied responsable_personnel',
            ],404);
        }
        $responsable_personnel->update($request->all());
        return response([
            'responsable_personnel' => $responsable_personnel,
        ]);
    }

    public function modifierPasswordResponsablePersonnel (Request $request , $email){
        $responsable_personnel=Responsable_personnel::where('email',$email)->first();

        if(Auth::guard('responsable_personnel') && (Hash::check($request->mot_de_passe, $responsable_personnel->mot_de_passe)) ){
                $responsable_personnel['mot_de_passe'] = Hash::make($request->newPassword);
                $responsable_personnel->save();
                return response([
                    'message'=>'password updated'
                ],200);
            }

        return response([
            'message' => 'incorrect password'
        ],403);
    }

    public function sendFirstPassword(Request $request){
        $responsable_personnel = Responsable_personnel::where('email' , $request->email)->first();
        if($responsable_personnel){
            $mail_message = 'responsable commercial votre mot de passe est ';
            $pass = Str::random(8);
            $mail_message .= $pass ;
            $mail_data =[
                'recipient'=> 'arijcherni001@gmail.com',
                'fromEmail' =>$responsable_personnel->email ,
                'fromName' => $responsable_personnel->name,
                'subject' => 'nouveau mot de passe',
                'body' => $mail_message,
            ];
            Mail::send('email-template' ,$mail_data , function($message) use ($mail_data){
                $message->from($mail_data['fromEmail'], $mail_data['fromName'] );
                $message->to($mail_data['recipient'], 'ReSchool')
                ->subject($mail_data['subject']);
            });
            $responsable_personnel['mot_de_passe'] = Hash::make($pass);
            $responsable_personnel->save();
            return response([$responsable_personnel],200);
        }

        return response([],404);

    }

    public function updateImage(Request $request){
        $request->validate([
            'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $responsable_personnel=auth()->guard('responsable_personnel')->user();

        if($responsable_personnel !=null){

            if($request->hasFile('photo')){
                $image = $request->file('photo');
                $destinationPath = 'storage/images/responsable_personnel';
                $destination = 'storage/images/responsable_personnel/'.$responsable_personnel->photo;
                if(File::exists($destination)){
                    File::delete($destination);
                }
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['photo'] = $profileImage;
                $responsable_personnel['photo'] =$input['photo'];
                $responsable_personnel->save();
                return response([
                    'status' => 200,
                    'responsable_personnel' =>$responsable_personnel,
                ]);
            }
            return response([
                'status' => 404,
                'photo' =>'error',
            ]);
        }
    }

    public function sendImage(){
        $responsable_personnel=auth()->guard('responsable_personnel')->user();

        if($responsable_personnel !=null){
            if($responsable_personnel->photo!=null){
                $destination = 'storage/images/responsable_personnel/'.$responsable_personnel->photo;
                return response([
                    "url"=>$destination
                ],200);
            }
            return response([
                "photo"=>null
            ],200);
        }
        return response([
            'msg' =>$responsable_personnel
        ]);
    }

    public function destroyImage(){
        $responsable_personnel=auth()->guard('responsable_personnel')->user();

        if($responsable_personnel !=null){

            $destination = 'storage/images/responsable_personnel/'.$responsable_personnel->photo;
                if(File::exists($destination)){
                    File::delete($destination);
                    $responsable_personnel->photo = null;
                    $responsable_personnel->save();
                }
                return response([
                    'status' => 200,
                    'client_dechet' =>$responsable_personnel,
                ]);
        }
    }
}
