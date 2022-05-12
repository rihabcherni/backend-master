<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Responsable_etablissement extends Authenticatable{
    use HasFactory, SoftDeletes, Notifiable , HasApiTokens;
    protected $fillable = [
        'nom_etablissement',
        'nom_responsable',
        'numero_telephone',
        'adresse',
        'numero_fixe',
        'email',
        'mot_de_passe',
        'numero_telephone',
        'QRcode',
    ];

    public function etablissement(){
        return $this->belongsTo(etablissement::class);
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
