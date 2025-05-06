<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Produit;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('produit')->get();
        return view('stocks.stock_create', compact('stocks'));
    }

    public function create()
    {
        $produits = Produit::all(); // pour le dropdown des produits
        return view('stocks.stock', compact('produits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite_stockee' => 'required|numeric|min:0',
            'lieu_stockage' => 'required|string|max:255',
        ]);

        Stock::create([
            'produit_id' => $request->produit_id,
            'quantite_stockee' => $request->quantite_stockee,
            'lieu_stockage' => $request->lieu_stockage,
        ]);

        return redirect()->route('stocks.index')->with('success', 'Stock ajouté avec succès.');
    }

    public function edit(Stock $stock)
    {
        $produits = Produit::all();
        return view('stocks.stock_create', compact('stock', 'produits'));
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite_stockee' => 'required|numeric|min:0',
            'lieu_stockage' => 'required|string|max:255',
        ]);

        $stock->update([
            'produit_id' => $request->produit_id,
            'quantite_stockee' => $request->quantite_stockee,
            'lieu_stockage' => $request->lieu_stockage,
        ]);

        return redirect()->route('stocks.index')->with('success', 'Stock mis à jour avec succès.');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stocks.index')->with('success', 'Stock supprimé avec succès.');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $stocks = Stock::whereHas('produit', function ($query) use ($search) {
                $query->where('nom', 'like', "%{$search}%");
            })
            ->orWhere('lieu_stockage', 'like', "%{$search}%")
            ->with('produit')
            ->get();

        return view('stocks.stock', compact('stocks'));
    }
}
