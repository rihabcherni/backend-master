<?php
namespace App\Http\Controllers\API\Ouvrier;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Poubelle;
use App\Models\Ouvrier;
use App\Models\Camion;
use App\Models\Depot;
use App\Models\Zone_depot;
use App\Models\Bloc_etablissement;
use App\Models\Bloc_poubelle;
use App\Models\Etablissement;
use App\Models\Etage_etablissement;

class ViderController extends BaseController{
    public function ViderPoubelle( $ouvrier_id , $poubelle_id){
        $poubelle = Poubelle::find($poubelle_id);

        $capactite=$poubelle->capacite_poubelle;
        $pourcentage=$poubelle->Etat;

        $quantite=$capactite * $pourcentage/ 100;

        $poubelle->Etat=0;
        $poubelle->capacite_poubelle=0;


        $ouvrier = Ouvrier::find($ouvrier_id);
        $camion_id = $ouvrier->camion_id;

        $camion = Camion::find($camion_id);

        if ($poubelle->type==="plastique"){
            $camion->volume_actuelle_plastique+=$quantite;
        }else if($poubelle->type==="papier"){
            $camion->volume_actuelle_papier+=$quantite;
        }else if($poubelle->type==="composte"){
            $camion->volume_actuelle_composte+=$quantite;
        }else if($poubelle->type==="canette"){
            $camion->volume_actuelle_canette+=$quantite;
        }

        $poubelle->save();
        $camion->save();
        $myArray = [
            'poubelle_id'=>$poubelle->id,
            'type'=>$poubelle->type,
            'camion_id'=>$camion->id,
            'ouvrier_id'=>$ouvrier->id,
            'quantite'=>$quantite,
            'quantite_plastique_camion'=>$camion->volume_actuelle_plastique,
            'quantite_papier_camion'=>$camion->volume_actuelle_papier,
            'quantite_composte_camion'=>$camion->volume_actuelle_composte,
            'quantite_canette_camion'=>$camion->volume_actuelle_canette,
        ];
        return response()->json($myArray);
    }
    public function ViderCamion( $depot_id){
        // $ouvrier = Ouvrier::find($ouvrier_id);
        // $camion_id = $ouvrier->camion_id;

        $depot = Depot::find($depot_id);
        $zone_depot_id = $depot->zone_depot_id;
        $camion_id =$depot->camion_id;

        $camion = Camion::find($camion_id);
        $zone_depot = Zone_depot::find($zone_depot_id);

        $qt_plastique=$camion->volume_actuelle_plastique;
        $qt_canette=$camion->volume_actuelle_canette;
        $qt_composte=$camion->volume_actuelle_composte;
        $qt_papier=$camion->volume_actuelle_papier;

        $zone_depot->quantite_depot_actuelle_plastique+=$qt_plastique;
        $zone_depot->quantite_depot_actuelle_papier+=$qt_papier;
        $zone_depot->quantite_depot_actuelle_composte+=$qt_composte;
        $zone_depot->quantite_depot_actuelle_canette+=$qt_canette;

        $camion->volume_actuelle_plastique=0;
        $camion->volume_actuelle_canette=0;
        $camion->volume_actuelle_composte=0;
        $camion->volume_actuelle_papier=0;

        $camion->save();
        $zone_depot->save();
        $myArray = [
            'zone_depot_id'=>$zone_depot->id,
            'camion_id'=>$camion->id,
            'depot'=>$depot->id,
            'quantite_plastique_camion'=>$qt_papier,
            'quantite_papier_camion'=>$qt_papier,
            'quantite_composte_camion'=>$qt_composte,
            'quantite_canette_camion'=>$qt_canette,
            'quantite_plastique_zone_depot'=>$zone_depot->quantite_depot_actuelle_plastique,
            'quantite_papier_zone_depot'=>$zone_depot->quantite_depot_actuelle_papier,
            'quantite_composte_zone_depot'=>$zone_depot->quantite_depot_actuelle_composte,
            'quantite_canette_zone_depot'=>$zone_depot->quantite_depot_actuelle_canette,
        ];
        return response()->json($myArray);
    }

    public function ViderPoubelleQr($qr){
        $poubelle = Poubelle::where('nom',$qr)->first();
        if(!$poubelle){
            return response([
                'message' => 'poubelle introuvable'
            ],404);
        }


        $bloc_poubelle = Bloc_poubelle::find($poubelle->bloc_poubelle_id);
        if(!$bloc_poubelle){
            return response([
                'message' => 'bloc poubelle introuvable'
            ],404);
        }

        $etage_etablissement = Etage_etablissement::find($bloc_poubelle->etage_etablissement_id);
        if(!$etage_etablissement){
            return response([
                'message' => 'etage etablissement introuvable'
            ],404);
        }
        $bloc_etablissement = Bloc_etablissement::find($etage_etablissement->bloc_etablissement_id);
        
        if(!$bloc_etablissement){
            return response([
                'message' => 'bloc_etablissement introuvable'
            ],404);
        }
        
        $etablissement = Etablissement::find($bloc_etablissement->etablissement_id);
        if(!$etablissement){
            return response([
                'message' => 'etablissement introuvable'
            ],404);
        }
        return response([        
            
            "nom_etablissement"=>$etablissement->nom_etablissement,
            "nom_etage_etablissement"  =>$etage_etablissement->nom_etage_etablissement,
            "nbr_personnes"=>$etablissement->nbr_personnes,
            "nom_bloc_etablissement"=>$bloc_etablissement->nom_bloc_etablissement,
            "nom"=>$poubelle->nom,
            "Etat"=>$poubelle->Etat,
            "type"=>$poubelle->type,
            "temps_remplissage"=>$poubelle->temps_remplissage,
        ]);
    }
}
