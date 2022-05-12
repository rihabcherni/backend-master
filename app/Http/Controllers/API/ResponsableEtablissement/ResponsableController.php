<?php

namespace App\Http\Controllers\API\ResponsableEtablissement;

use App\Http\Controllers\Controller;
use App\Models\Commande_poubelle;
use Illuminate\Http\Request;

class ResponsableController extends Controller{
    public function ResponsabelCommande(){
        $responable=auth()->guard('responsable_etablissement')->user();
        $commande= Commande_poubelle::where('responsable_etablissement_id','=',$responable->id)->get();
        foreach($commande as $comm){
            $comm->detail_commande_dechet;
        }
        return $commande;
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
