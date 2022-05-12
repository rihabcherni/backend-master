<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Commande_poubelle extends Model{
    use HasFactory, SoftDeletes;
      protected $fillable = [
        'responsable_etablissement_id',
        'quantite',
        'montant_total',
        'date_commande',
        'date_livraison',
    ];
      public function responsable_etablissement(){
            return $this->hasOne(Responsable_etablissement::class);
        }
      public function detail_commande_poubelle(){
            return $this->hasOne(Detail_commande_poubelle::class);
        }
      protected $dates=['deleted_at'];
}
