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
        $produits = Produit::doesntHave('stock')->get(); // Pour éviter les doublons
        return view('stockage.create', compact('produits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id|unique:stocks,produit_id',
            'quantite_stockee' => 'required|numeric|min:0',
            'lieu_stockage' => 'required|string|max:255',
        ]);

        Stock::create($validated);
        return redirect()->route('stockage.index')->with('success', 'Stock ajouté avec succès');
    }

    public function edit(Stock $stock)
    {
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
}
