<?php
namespace App\Http\Controllers\API\GestionDechet;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\GestionDechet\Dechet as DechetResource;
use App\Models\Dechet;
use App\Http\Requests\GestionDechet\DechetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DechetController extends BaseController{
    public function index(){
        $dechet = Dechet::all();
        return $this->handleResponse(DechetResource::collection($dechet), 'tous les dechets!');
    }
    public function store(DechetRequest $request){
        $input = $request->all();
        $dechet = Dechet::create($input);
        return $this->handleResponse(new DechetResource($dechet), 'dechet crée!');
    }
    public function show($id){
        $dechet = Dechet::find($id);
        if (is_null($dechet)) {
            return $this->handleError('dechet n\'existe pas!');
        }else{
            return $this->handleResponse(new DechetResource($dechet), 'dechet existante.');
        }
    }
    public function update(DechetRequest $request, Dechet $dechet){
        $input = $request->all();
        $dechet->update($input);
        return $this->handleResponse(new DechetResource($dechet), 'dechet modifié!');
    }
    public function destroydestroy($id) {
        $dechet =Dechet::find($id);
        if (is_null($dechet)) {
            return $this->handleError('dechet n\'existe pas!');
        }
        else{
            $dechet->delete();
            return $this->handleResponse(new DechetResource($dechet), 'dechet supprimé!');
        }
    }

    public function updateImage(Request $request){
        $request->validate([
            'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type_dechet'=>'required',
        ]);
            $dechet = Dechet::where("type_dechet",$request->type_dechet);
            if($request->hasFile('photo')){
                $image = $request->file('photo');
                $destinationPath = 'storage/images/stock_poubelle';
                $destination = 'storage/images/stock_poubelle/'.$dechet->photo;
                if(File::exists($destination)){
                    File::delete($destination);
                }
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['photo'] = $profileImage;
                $dechet['photo'] =$input['photo'];
                $dechet->save();
                return response([
                    'status' => 200,
                    'dechet' =>$dechet,
                ]);
            }
            return response([
                'status' => 404,
                'photo' =>'error',
            ]);
    }
}
