<?php

namespace App\Http\Requests\GestionPoubelleEtablissements;

use Illuminate\Foundation\Http\FormRequest;

class Bloc_etablissementsRequest extends FormRequest{
    public function authorize()
    {
        return false;
    }

    public function rules()
    {
        if ($this->isMethod('post')) {
            return [
            'etablissement_id'=> 'required|numeric',
            'nom_bloc_etablissement'=> 'required|string',
            ];
        }else if($this->isMethod('PUT')){
            return [
                // 'responsable_etablissement_id'=> 'required|numeric',
                // 'quantite'=> 'required|numeric',
                // 'montant_total'=> 'required|numeric',
                // 'date_commande'=> 'required|date_format:Y-m-d',
                // 'date_livraison'=> 'required|date_format:Y-m-d',
               ];
        }

    }
}
