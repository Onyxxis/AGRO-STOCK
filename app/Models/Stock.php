<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produit;

class Stock extends Model
{
    protected $fillable = ['produit_id', 'quantite_en_stock', 'lieu_stockage'];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
