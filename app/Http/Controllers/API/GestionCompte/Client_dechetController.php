<?php
namespace App\Http\Controllers\API\GestionCompte;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\GestionCompte\Client_dechet as Client_dechetResource;
use App\Models\Client_dechet;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\GestionCompte\Client_dechetRequest;
use Illuminate\Support\Facades\Storage;

class Client_dechetController extends BaseController{
    public function index(){
        $client = Client_dechet::all();
        return $this->handleResponse(Client_dechetResource::collection($client), 'Affichage des clients!');
    }
    public function store(Client_dechetRequest $request)  {
        $input = $request->all();
        if ($image = $request->file('photo')) {
            $destinationPath = 'storage/images/client';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }
        $input['mot_de_passe'] = Hash::make($input['mot_de_passe']);

        $client= Client_dechet::create($input);
        return $this->handleResponse(new Client_dechetResource($client), 'Client crée!');
    }
    public function show($id){
        $client = Client_dechet::find($id);
        if (is_null($client)) {
            return $this->handleError('client n\'existe pas!');
        }else{
            return $this->handleResponse(new Client_dechetResource($client), 'Client existe.');
        }
    }
    public function update(Client_dechetRequest $request, Client_dechet $client){
        $input = $request->all();
        if ($image = $request->file('photo')) {
            Storage::delete(('storage\images\client\\').Client_dechet::find($client->id)->photo);
            //unlink(public_path('storage\images\client\\').Client_dechet::find($client->id)->photo);
            $destinationPath = 'storage\images\client';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }else{
            unset($input['photo']);
        }
        if(!($request->mot_de_passe==null)){
            $input['mot_de_passe'] = Hash::make($input['mot_de_passe']);
        }
        $client->update($input);
        return $this->handleResponse(new Client_dechetResource($client), 'Client modifié!');


    }

    public function destroy($id) {
        $client = Client_dechet::find($id);
        if (is_null($client)) {
            return $this->handleError('client  n\'existe pas!');
        }
        else{
            unlink(public_path('storage\images\client\\').$client->photo );
            $client->delete();
            return $this->handleResponse(new Client_dechetResource($client), 'Client supprimé!');
        }

    }

}
