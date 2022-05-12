<?php

namespace App\Http\Controllers\Auth\ResponsableCommercial;

use App\Models\Responsable_commercial;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class ResponsableCommercialController extends BaseController
{
    public function registerResponsableCommercial(Request $request){
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
        $responsable_commercial = Responsable_commercial::create($input);
        $responsable_commercial=Responsable_commercial::where('email',$request->email)->first();
        $success['nom']= $responsable_commercial->nom;
        $success['prenom']= $responsable_commercial->prenom;
        $success['mot_de_passe']= Crypt::encryptString($responsable_commercial->mot_de_passe);
        $success['photo']= $responsable_commercial->photo;
        $success['CIN']= $responsable_commercial->CIN;
        $success['email']= $responsable_commercial->email;
        $success['QRcode']= $responsable_commercial->QRcode;
        $success['numero_telephone']= $responsable_commercial->numero_telephone;
        $success['created_at'] =  $responsable_commercial->created_at->format('d/m/y H:i:s');
        return $this->handleResponse($success, 'responsable commercial successfully registered!');
    }

    public function loginResponsableCommercial(Request $request){
        $validator= Validator::make($request->all(),[
            'email' =>['required','email','exists:responsable_commercials'],
            'mot_de_passe'=>'required|string',
            'device_name' => 'required',
        ]);
        if($validator->fails()){
        return response()->json(['validation_errors' =>$validator->errors()]);
        }
        $responsable_commercial=Responsable_commercial::where('email',$request->email)->first();

        if(Auth::guard('responsable_commercial') && (Hash::check($request->mot_de_passe,  $responsable_commercial->mot_de_passe)) ){
            return response()->json([
                'status'=>200,
                'email'=>$responsable_commercial->email,
                'token'=> $responsable_commercial->createToken('responsable_commercial_login')->plainTextToken,
                'message' =>'responsable commercial vous avez connecté avec success',
        ]);
        }else{
            return response()->json(['status'=>401,'validation_credentials' =>"Invalid credentials"]);
     }
    }

    public function logoutResponsableCommercial(){
        if(Auth::guard('responsable_commercial')){
            $user = request()->user();
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            return response([
                'status' => 200,
                'message' =>'responsable commercial vous avez logout avec success',
            ]);
        }
    }
    public function qrlogin($qrcode){
        $responsable_commercial = Responsable_commercial::where('QRcode',$qrcode)->first();
        if(!$responsable_commercial){
            return response([
                    'message' => 'invalid qr'
            ] , 401);
        }
        return response([
            'user' => $responsable_commercial,
            'token'=> $responsable_commercial->createToken('responsable_commercial_login_qr')->plainTextToken,
        ],200);
    }

    public function allResponsableCommercials(){
        $responsable_commercial = Responsable_commercial::all();
        return response([
            'responsable_commercial' => $responsable_commercial
        ]);
    }

    public function modifierProfileResponsableCommercial(Request $request, $id){
        $responsable_commercial = Responsable_commercial::find($id);
        if(!$responsable_commercial){
            return response([
                'message' => 'undefenied responsable_commercial',
            ],404);
        }
        $responsable_commercial->update($request->all());
        return response([
            'responsable_commercial' => $responsable_commercial,
        ]);
    }

    public function modifierPasswordResponsableCommercial (Request $request , $email){
        $responsable_commercial=Responsable_commercial::where('email',$email)->first();

        if(Auth::guard('responsable_commercial') && (Hash::check($request->mot_de_passe, $responsable_commercial->mot_de_passe)) ){
                $responsable_commercial['mot_de_passe'] = Hash::make($request->newPassword);
                $responsable_commercial->save();
                return response([
                    'message'=>'password updated'
                ],200);
            }

        return response([
            'message' => 'incorrect password'
        ],403);
    }

    public function sendFirstPassword(Request $request){
        $responsable_commercial = Responsable_commercial::where('email' , $request->email)->first();
        if($responsable_commercial){
            $mail_message = 'responsable commercial votre mot de passe est ';
            $pass = Str::random(8);
            $mail_message .= $pass ;
            $mail_data =[
                'recipient'=> 'arijcherni001@gmail.com',
                'fromEmail' =>$responsable_commercial->email ,
                'fromName' => $responsable_commercial->name,
                'subject' => 'nouveau mot de passe',
                'body' => $mail_message,
            ];
            Mail::send('email-template' ,$mail_data , function($message) use ($mail_data){
                $message->from($mail_data['fromEmail'], $mail_data['fromName'] );
                $message->to($mail_data['recipient'], 'ReSchool')
                ->subject($mail_data['subject']);
            });
            $responsable_commercial['mot_de_passe'] = Hash::make($pass);
            $responsable_commercial->save();
            return response([$responsable_commercial],200);
        }

        return response([],404);

    }

    public function updateImage(Request $request){
        $request->validate([
            'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $responsable_commercial=auth()->guard('responsable_commercial')->user();

        if($responsable_commercial !=null){

            if($request->hasFile('photo')){
                $image = $request->file('photo');
                $destinationPath = 'storage/images/responsable_commercial';
                $destination = 'storage/images/responsable_commercial/'.$responsable_commercial->photo;
                if(File::exists($destination)){
                    File::delete($destination);
                }
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['photo'] = $profileImage;
                $responsable_commercial['photo'] =$input['photo'];
                $responsable_commercial->save();
                return response([
                    'status' => 200,
                    'responsable_commercial' =>$responsable_commercial,
                ]);
            }
            return response([
                'status' => 404,
                'photo' =>'error',
            ]);
        }
    }

    public function sendImage(){
        $responsable_commercial=auth()->guard('responsable_commercial')->user();

        if($responsable_commercial !=null){
            if($responsable_commercial->photo!=null){
                $destination = 'storage/images/responsable_commercial/'.$responsable_commercial->photo;
                return response([
                    "url"=>$destination
                ],200);
            }
            return response([
                "photo"=>null
            ],200);
        }
        return response([
            'msg' =>$responsable_commercial
        ]);
    }

    public function destroyImage(){
        $responsable_commercial=auth()->guard('responsable_commercial')->user();

        if($responsable_commercial !=null){

            $destination = 'storage/images/responsable_commercial/'.$responsable_commercial->photo;
                if(File::exists($destination)){
                    File::delete($destination);
                    $responsable_commercial->photo = null;
                    $responsable_commercial->save();
                }
                return response([
                    'status' => 200,
                    'client_dechet' =>$responsable_commercial,
                ]);
        }
    }
}
