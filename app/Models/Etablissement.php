<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Etablissement extends Model
{
    use HasFactory,  SoftDeletes;
    protected $fillable = [
        'zone_travail_id',
        'responsable_etablissement_id',
        'nom_etablissement',
        'type_etablissement',
        'nbr_personnes',
        'url_map',
        'adresse',
        'longitude',
        'latitude',
        'quantite_dechets_plastique',
        'quantite_dechets_composte',
        'quantite_dechets_papier',
        'quantite_dechets_canette',

    ];

    public function zone_travail(){
        return $this->belongsTo(Zone_travail::class);
    }

    public function responsable_etablissement() {
        return $this->hasOne(Responsable_etablissement::class);
    }
    public function bloc_etablissements() {
        return $this->hasMany(Bloc_etablissement::class);
    }

    protected $dates=['deleted_at'];
}
