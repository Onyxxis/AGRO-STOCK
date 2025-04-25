<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produit;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'produit_id',
        'quantite_stockee',
        'lieu_stockage',
    ];

    /**
     * Relation avec le modèle Produit
     */
    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
}
