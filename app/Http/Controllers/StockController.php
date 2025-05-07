<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Produit;


class StockController extends Controller
{
    //
    public function index()
    {
        $stocks = Stock::with('produit')->get();
        return view('stockage.index', compact('stocks'));

    }

    public function create()
    {
        // $produits = Produit::doesntHave('stock')->get(); // Pour éviter les doublons
        $produits = Produit::all();
        return view('stockage.create', compact('produits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'lieu_stockage' => 'required|string|max:255',
        ]);

        $produit = Produit::findOrFail($validated['produit_id']);

        // Quantité à ajouter
        $quantiteAjoutee = $produit->quantite_recoltee;

        $stock = Stock::where('produit_id', $produit->id)->first();

        if ($stock) {
            $stock->quantite_stockee += $quantiteAjoutee;
            $stock->lieu_stockage = $validated['lieu_stockage'];
            $stock->save();
        } else {
            Stock::create([
                'produit_id' => $produit->id,
                'quantite_stockee' => $quantiteAjoutee,
                'lieu_stockage' => $validated['lieu_stockage'],
            ]);
        }

        return redirect()->route('stockage.index')->with('success', 'Stock mis à jour avec succès');
    }


    public function edit(Stock $stock)
    {
        $stock->load('produit'); // Assure le chargement de la relation
        return view('stockage.edit', compact('stock'));
    }

    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'quantite_stockee' => 'required|numeric|min:0',
            'lieu_stockage' => 'required|string|max:255',
        ]);

        $stock->update($validated);
        return redirect()->route('stockage.index')->with('success', 'Stock mis à jour');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stockage.index')->with('success', 'Stock supprimé');
    }

    public function search(Request $request)
{
    $search = $request->input('search');

    $stocks = Stock::with('produit')
        ->whereHas('produit', function($query) use ($search) {
            $query->where('nom', 'like', "%$search%");
        })
        ->orWhere('lieu_stockage', 'like', "%$search%")
        ->get();

    return view('stockage.index', compact('stocks'));
}
}
