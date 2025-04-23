<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'produit_id',
        'type_transaction',
        'date_transaction',
        'quantite',
        'prix_unitaire',
        'destinataire'
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}