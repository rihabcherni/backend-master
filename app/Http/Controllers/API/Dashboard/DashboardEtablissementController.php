<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\Poubelle;
use App\Models\Responsable_etablissement;
use App\Http\Resources\GestionPoubelleEtablissements\Etablissement as EtablissementResource;
use App\Models\Bloc_poubelle;
use Illuminate\Support\Facades\DB;

class DashboardEtablissementController extends Controller{
     public function donnee_etablissement($id){
        $etablissement=  Etablissement::findOrFail($id);
        $bloc_poubelle=$etablissement->bloc_poubelles;
        $poubelle=[];
        foreach($bloc_poubelle as $bloc){
            $Array = [
                'bloc'=>$bloc->poubelles,
            ];
            array_push($poubelle,$Array);
        }

        $responsable_etablissement_id=$etablissement->responsable_etablissement_id;
        $responsable_etablissement=  Responsable_etablissement::where('id',$responsable_etablissement_id)->get();

        $myArray = [
            'etablissement'=>$etablissement,
            'responsable_etablissement'=>$responsable_etablissement,
        ];
        return response()->json($myArray);
    }

    public function dashboard_etablissement($id){
        $etablissement=  Etablissement::findOrFail($id);
        $nbr_bloc_poubelle_etablissement= Etablissement::withcount('bloc_poubelles')->where('id','=',$id)->get();
        // $nbr_bloc_poubelle_bloc_etablissement= $etablissement->bloc_poubelles->groupby('bloc_etablissement')->get();
        $bloc_etablissement=Bloc_poubelle::selectRaw('bloc_etablissement, count(*)')->where("etablissement_id",$id)
        ->groupBy('bloc_etablissement')
        ->get();

        $etage_etablissement_par_bloc_etablissment=Bloc_poubelle::selectRaw('bloc_etablissement ,etage_etablissement, count(*)')->where("etablissement_id",$id)
        ->groupBy('bloc_etablissement','etage_etablissement')
        ->get();
        // $groupedSalesCampaign = Bloc_poubelle::where("etablissement_id",$id)
        // ->groupBy('bloc_etablissement')
        // ->orderBy(DB::raw('COUNT(id)','desc'))
        // ->get(array(DB::raw('COUNT(id) as totalsales'),'bloc_etablissement'));

        // $nbr_bloc_poubelle_etage_etablissement= ;
        // $nbr_bloc_poubelle_etablissement=$etablissement->bloc_poubelles->count();

        // $poubelle=[];
        // foreach($bloc_poubelle as $bloc){
        //     $Array = [
        //         'bloc'=>$bloc,
        //         'poubelles'=>Poubelle::where('bloc_poubelle_id',$bloc->id)->get(),
        //     ];
        //     array_push($poubelle,$Array);
        // }


        // $responsable_etablissement_id=$etablissement->responsable_etablissement_id;
        // $responsable_etablissement=  Responsable_etablissement::where('id',$responsable_etablissement_id)->get();

        $myArray = [
            'etablissement'=>$nbr_bloc_poubelle_etablissement,
            'bloc_etablissement'=>$bloc_etablissement,
            'etage_etablissement_par_bloc_etablissment'=>$etage_etablissement_par_bloc_etablissment,
        ];
        return response()->json($myArray);
    }
}
