<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_commande_poubelle extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'commande_poubelle_id',
        'stock_poubelle_id',
        'quantite',
        'prix_unitaires',
    ];
    public function commande_poubelle(){
        return $this->belongsTo(Commande_poubelle::class);
    }
}

