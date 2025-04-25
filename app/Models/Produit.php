<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'type',
        'quantite_recoltee',
        'date_recolte',
        'statut',
    ];
    public function transactions()
{
    return $this->hasMany(Transaction::class);
}

public function stock()
{
    return $this->hasOne(Stock::class);
}

}
