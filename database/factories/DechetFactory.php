<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

use function PHPSTORM_META\type;

class DechetFactory extends Factory{
    public function definition(){
        $type= $this->faker->randomElement(['plastique', 'composte','papier','canette']);
        if($type==='plastique'){
            $prix_unitaire= 1200;
        }elseif ($type==='composte'){
            $prix_unitaire= 2000;
        }elseif ($type==='papier'){
            $prix_unitaire= 800;
        }elseif ($type==='canette'){
            $prix_unitaire= 1400;
        }
        return [
            'type_dechet'=> $type,
            'prix_unitaire'=>$prix_unitaire,
            'photo' => null,
        ];
    }
}
