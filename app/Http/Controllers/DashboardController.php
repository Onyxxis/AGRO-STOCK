<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;

class DashboardController extends Controller
{
    public function index()
    {
        // Compter le nombre de produits
        $produitCount = Produit::count();

        // Retourner la vue dashboard avec la variable $produitCount
        return view('dashboard.index', compact('produitCount'));
    }
}
