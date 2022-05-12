<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateCamionsTable extends Migration{
    public function up(){
        Schema::create('camions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zone_travail_id')->constrained('zone_travails')->onDelete('cascade')->onUpdate('cascade');
            $table->string('matricule');
            $table->string('QRcode',255)->nullable();
            $table->datetime('heure_sortie')->nullable();
            $table->datetime('heure_entree')->nullable();
            $table->double('longitude');
            $table->double('latitude');
            $table->float('volume_maximale_camion');
            $table->float('volume_actuelle_plastique');
            $table->float('volume_actuelle_papier');
            $table->float('volume_actuelle_composte');
            $table->float('volume_actuelle_canette');
            $table->float('volume_carburant_consomme')->default(0);
            $table->float('Kilometrage')->default(0);
            $table->unique( array('longitude','latitude') );
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }
    public function down()
    {
        Schema::table("camions",function(Blueprint $table){
            $table->dropForeignKey("zone_travail_id");
        });
        Schema::dropIfExists('camions');
    }
}
