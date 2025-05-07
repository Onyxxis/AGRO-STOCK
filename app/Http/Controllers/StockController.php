<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Produit;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('produit')->get();
        return view('stockage.stock', compact('stocks'));
    }

    public function create()
    {
        // Pour éviter les doublons : on ne propose que les produits sans stock
        $produits = Produit::doesntHave('stock')->get();
        return view('stockage.stock_create', compact('produits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id|unique:stocks,produit_id',
            'quantite_stockee' => 'required|numeric|min:0',
            'lieu_stockage' => 'required|string|max:255',
        ]);

        Stock::create($validated);
        return redirect()->route('stockage.index')->with('success', 'Stock ajouté avec succès.');
    }

    public function edit(Stock $stock)
    {
        $stock->load('produit');
        $produits = Produit::all(); // Pour permettre de modifier le produit lié
        return view('stockage.stock_create', compact('stock', 'produits'));
    }

    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id|unique:stocks,produit_id,' . $stock->id,
            'quantite_stockee' => 'required|numeric|min:0',
            'lieu_stockage' => 'required|string|max:255',
        ]);

        $stock->update($validated);
        return redirect()->route('stockage.index')->with('success', 'Stock mis à jour avec succès.');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stockage.index')->with('success', 'Stock supprimé avec succès.');
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

        return view('stockage.stock', compact('stocks'));
    }
}
