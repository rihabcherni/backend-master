<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsableEtablissementsTable extends Migration{
    public function up(){
        Schema::create('responsable_etablissements', function (Blueprint $table) {
            $table->id();
            $table->string('nom_etablissement',20);
            $table->string('nom_responsable');
            $table->string('numero_telephone')->unique();;
            $table->string('numero_fixe')->unique();
            $table->string('email',40)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('mot_de_passe',255);
            $table->string('adresse');
            $table->string('QRcode',255)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down()
    {
        Schema::dropIfExists('responsable_etablissements');
    }
};
