<?php

namespace App\Http\Requests\GestionPoubelleEtablissements;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class Zone_travailRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }
    public function rules()  {
        if ($this->isMethod('post')) {
            return [
                'region' => 'required|string|unique:zone_travails',
                'quantite_total_collecte_plastique'=> 'required|numeric',
                'quantite_total_collecte_composte'=> 'required|numeric',
                'quantite_total_collecte_papier'=> 'required|numeric',
                'quantite_total_collecte_canette'=> 'required|numeric',

            ];
        }else if($this->isMethod('PUT')){
            // $id = $this->route('zone_travail');
            return [
                'region' => "required|regex:/^([a-zA-Z]+)(\s[a-zA-Z0-9]+)*$/|unique:zone_travails,region,".\Request::instance()->id,
                'quantite_total_collecte_plastique'=> 'required|numeric',
                'quantite_total_collecte_composte'=> 'required|numeric',
                'quantite_total_collecte_papier'=> 'required|numeric',
                'quantite_total_collecte_canette'=> 'required|numeric',
             ];
        }

    }
    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'Validation errors',
                'validation_error'      => $validator->errors()
            ]));
    }
}
