<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Ouvrier extends Authenticatable{
    use HasFactory,  SoftDeletes, Notifiable , HasApiTokens;
    protected $fillable = [
        'zone_travail_id',
        'camion_id',
        'poste',
        'nom',
        'prenom',
        'adresse',
        'CIN',
        'photo',
        'mot_de_passe',
        'numero_telephone',
        'email',
        'QRcode',
    ];
    public function camion(){
        return $this->hasOne(Camion::class);
    }

    public function etablissement(){
        return $this->belongsTo(Etablissement::class);
    }
    protected $dates=['deleted_at'];
    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}

