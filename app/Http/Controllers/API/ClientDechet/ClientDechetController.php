<?php

namespace App\Http\Controllers\API\ClientDechet;

use App\Http\Controllers\Controller;
use App\Models\Commande_dechet;
use App\Models\Detail_commande_dechet;
use Illuminate\Http\Request;

class ClientDechetController extends Controller
{
    public function ClientCommande(){
        $client=auth()->guard('client_dechet')->user();
        $commande= Commande_dechet::where('client_dechet_id','=',$client->id)->get();
        foreach($commande as $comm){
            $comm->detail_commande_dechet;
        }
        return $commande;
    }
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
