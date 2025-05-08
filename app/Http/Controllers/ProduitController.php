<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ProduitController extends Controller
{
    public function create()
    {
        return view('produits.prod_create');
    }

    public function index()
    {
        $produits = Produit::all();
        return view('produits.produit', compact('produits'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'quantite_recoltee' => 'required|numeric|min:0',
        'date_recolte' => 'required|date',
        'statut' => 'required|in:Stocké,Vendu,Distribué',
    ]);

    Produit::create([
        'nom' => $request->input('nom'),
        'type' => $request->input('type'),
        'quantite_recoltee' => $request->input('quantite_recoltee'),
        'date_recolte' => $request->input('date_recolte'),
        'statut' => $request->input('statut'),
    ]);

    return redirect()->route('produits.index')->with('success', 'Produit ajouté avec succès.');
}
public function update(Request $request, Produit $produit)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'quantite_recoltee' => 'required|numeric|min:0',
        'date_recolte' => 'required|date',
        'statut' => 'required|in:Stocké,Vendu,Distribué',
    ]);

    // Sauvegarder l'ancienne quantité récoltée
    $ancienneQuantite = $produit->quantite_recoltee;

    // Mettre à jour le produit avec les nouvelles données
    $produit->update($request->all());

    // Mettre à jour le stock si le produit a déjà un stock
    $stock = $produit->stock;

    if ($stock) {
        // Calcul de la différence entre la nouvelle et l'ancienne quantité récoltée
        $difference = $produit->quantite_recoltee - $ancienneQuantite;

        // Mise à jour de la quantité stockée
        $stock->quantite_stockee += $difference;

        // S'assurer que la quantité stockée ne devient pas négative
        if ($stock->quantite_stockee < 0) {
            $stock->quantite_stockee = 0;
        }

        $stock->save();
    }

    return redirect()->route('produits.index')->with('success', 'Produit mis à jour avec succès !');
}


    public function destroy(Produit $produit)
    {
        $produit->delete();
        return redirect()->route('produits.index')->with('success', 'Produit supprimé avec succès !');
    }


    public function filter(Request $request)
        {
            $query = Produit::query();

            // Filtrer par type
            if ($request->filled('type') && $request->type != 'tout') {
                $query->where('type', $request->type);
            }

            // Filtrer par statut
            if ($request->filled('statut') && $request->statut != 'tout') {
                $query->where('statut', $request->statut);
            }

            // Filtrer par date (entre date de début et date de fin)
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('date_recolte', [
                    Carbon::parse($request->start_date)->startOfDay(),
                    Carbon::parse($request->end_date)->endOfDay()
                ]);
            } elseif ($request->filled('start_date')) {
                $query->where('date_recolte', '>=', Carbon::parse($request->start_date)->startOfDay());
            } elseif ($request->filled('end_date')) {
                $query->where('date_recolte', '<=', Carbon::parse($request->end_date)->endOfDay());
            }

            // Trier selon le critère choisi
            if ($request->filled('criteria')) {
                $criteria = $request->criteria;
                $query->orderBy($criteria);
            }

        $produits = $query->get();

        return view('produits.produit', compact('produits'));
    }

    public function edit(Produit $produit)
    {
        return view('produits.prod_create', compact('produit'));
    }

    public function search(Request $request)
    {
        // Récupérer la valeur de la recherche
        $searchTerm = $request->input('search');

        // Rechercher les produits qui correspondent au terme de recherche dans le nom, type ou statut
        $produits = Produit::where('nom', 'like', "%{$searchTerm}%")
                        ->orWhere('type', 'like', "%{$searchTerm}%")
                        ->orWhere('statut', 'like', "%{$searchTerm}%")
                        ->get();

        return view('produits.produit', compact('produits'));
    }






}
