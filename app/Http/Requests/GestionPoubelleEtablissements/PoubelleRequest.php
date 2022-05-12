<?php

namespace App\Http\Requests\GestionPoubelleEtablissements;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class PoubelleRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }
    public function rules()  {
        if ($this->isMethod('post')) {
            return [
                'bloc_poubelle_id' =>'required',
                'nom' =>'required|string',
                'compteur'=>'nullable|integer',
                'qrcode' =>'required|string',
                'capacite_poubelle'=> 'required',
                'type'=>'required',Rule::in(['composte', 'plastique','papier','canette']),
                'Etat'=> 'required|between:0,100',
                'temps_remplissage' => 'required',

            ];
        }else if($this->isMethod('PUT')){
            return [
            //     'bloc_poubelle_id' =>'required',
            //     'nom' =>'required|string',
            // 'compteur'=>'nullable',
            //     'qrcode'=>'required|string',
            //     'capacite_poubelle'=> 'required',
            //     'type'=>'required',Rule::in(['composte', 'plastique','papier','canette']),
            //     'Etat'=> 'required|between:0,100',
            //     'temps_remplissage' => 'date_format:Y-m-d',
             ];
        }

    }
    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'Validation errors',
                'validation_error' => $validator->errors()
            ]));
    }
}
