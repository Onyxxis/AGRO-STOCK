<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Stock;
use App\Models\Produit;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('produit')->latest()->paginate(10);
        $produits = Produit::all();
        return view('transaction.index', compact('transactions', 'produits'));
    }

    public function create()
    {
        $produits = Produit::all();
        return view('transaction.create', compact('produits'));
    }

    public function store(Request $request)
    {
        try {
            Log::info('1. Début de la méthode store avec données: ' . json_encode($request->all()));

            $request->validate([
                'produit_id' => 'required|exists:produits,id',
                'type_transaction' => 'required|in:Vente,Distribution',
                'date_transaction' => 'required|date',
                'quantite' => 'required|numeric|min:0.01',
                'prix_unitaire' => 'nullable|required_if:type_transaction,Vente|numeric|min:0',
                'destinataire' => 'required|string|max:255',
            ]);

            Log::info('2. Validation réussie');

            // Chercher le stock pour ce produit
            $stock = Stock::where('produit_id', $request->produit_id)->first();

            Log::info('3. Stock récupéré: ' . ($stock ? 'Oui' : 'Non'));

            // Si le stock n'existe pas, afficher un message d'erreur
            if (!$stock) {
                Log::info('4. Stock non récupéré');
                return back()->withErrors(['stock' => 'Stock non récupéré pour ce produit.']);
            }

            // Vérifier que le stock est suffisant
            if ($stock->quantite_stockee < $request->quantite) {
                Log::info('5. Stock insuffisant');
                return back()->withErrors(['quantite' => 'Stock insuffisant pour cette transaction.']);
            }

            Log::info('6. Stock suffisant, création de la transaction');

            // Créer la transaction
            $transaction = Transaction::create([
                'produit_id' => $request->produit_id,
                'type_transaction' => $request->type_transaction,
                'date_transaction' => $request->date_transaction,
                'quantite' => $request->quantite,
                'prix_unitaire' => $request->prix_unitaire,
                'destinataire' => $request->destinataire,
            ]);

            Log::info('7. Transaction créée avec succès');

            // Mettre à jour le stock
            $stock->quantite_stockee -= $request->quantite;
            $stock->save();

            Log::info('8. Stock mis à jour');

            Log::info('9. Tentative de redirection');

            return redirect()->route('transaction.index')->with('success', 'Transaction enregistrée avec succès.');
        } catch (\Exception $e) {
            Log::error('ERREUR dans store: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            return back()->withErrors(['error' => 'Une erreur est survenue: ' . $e->getMessage()]);
        }
    }

    public function edit(Transaction $transaction)
    {
        $produits = Produit::all();
        return view('transaction.edit', compact('transaction', 'produits'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'type_transaction' => 'required|in:Vente,Distribution',
            'date_transaction' => 'required|date',
            'quantite' => 'required|numeric|min:0.01',
            'prix_unitaire' => 'nullable|required_if:type_transaction,Vente|numeric|min:0',
            'destinataire' => 'required|string|max:255',
        ]);

        $ancienne_quantite = $transaction->quantite;
        $stock = Stock::where('produit_id', $transaction->produit_id)->first();

        // Remettre l'ancienne quantité avant d'appliquer la nouvelle
        $stock->quantite_stockee += $ancienne_quantite;

        // Vérifier que le stock est suffisant après la remise de l'ancienne quantité
        if ($stock->quantite_stockee < $request->quantite) {
            return back()->withErrors(['quantite' => 'Stock insuffisant pour cette modification.']);
        }

        $transaction->update($request->all());

        // Appliquer la nouvelle quantité
        $stock->quantite_stockee -= $request->quantite;
        $stock->save();

        return redirect()->route('transaction.index')->with('success', 'Transaction modifiée avec succès.');
    }

    public function destroy(Transaction $transaction)
    {
        $stock = Stock::where('produit_id', $transaction->produit_id)->first();

        if ($stock) {
            $stock->quantite_stockee += $transaction->quantite;
            $stock->save();
        }

        $transaction->delete();

        return redirect()->route('transaction.index')->with('success', 'Transaction supprimée avec succès.');
    }

    public function filter(Request $request)
    {
        $query = Transaction::with('produit');

        if ($request->filled('type_transaction') && $request->type_transaction != 'tout') {
            $query->where('type_transaction', $request->type_transaction);
        }

        if ($request->filled('produit_id') && $request->produit_id != 'tout') {
            $query->where('produit_id', $request->produit_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date_transaction', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay(),
            ]);
        }

        $transactions = $query->get();
        $produits = Produit::all();

        return view('transaction.index', compact('transactions', 'produits'));
    }

    public function search(Request $request)
    {
        $term = $request->input('search');

        $transactions = Transaction::with('produit')
            ->where('destinataire', 'like', "%{$term}%")
            ->orWhereHas('produit', function ($q) use ($term) {
                $q->where('nom', 'like', "%{$term}%");
            })
            ->get();

        return view('transaction.index', compact('transactions'));
    }
}
