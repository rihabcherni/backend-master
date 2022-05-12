<?php

namespace App\Http\Requests\GestionCompte;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class Client_dechetRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }
    public function rules()  {
        if ($this->isMethod('post')) {
            return [
            'nom' => 'required|string|regex:/^[A-Za-z ]*$/i',
            'prenom' => 'required|string|regex:/^[A-Za-z ]*$/i',
            'CIN' => 'required|numeric|unique:client_dechets,CIN',
            'numero_telephone'=> 'required|integer',
            'mot_de_passe' => 'required|string|min:6',
            'email' => 'required|unique:client_dechets,email,|email|max:50',
            'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'adresse' => 'required|string'
            ];
        }else if($this->isMethod('PUT')){
             return [
            'nom' => 'required|string|regex:/^[A-Za-z ]*$/i',
            'prenom' => 'required|string|regex:/^[A-Za-z ]*$/i',
            'CIN' => "required|numeric|unique:client_dechets,CIN,".\Request::instance()->id,
            'numero_telephone'=> 'required|regex:/^([1-9])([0-9]){7,10}$/',
            'email' => 'required','email',
            'mot_de_passe' => 'required|string|min:6',
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
