@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ajouter un stock</h2>

    <form method="POST" action="{{ route('stockage.store') }}">
        @csrf

        <div class="mb-3">
            <label for="produit_id" class="form-label">Produit</label>
            <select name="produit_id" class="form-control" required>
                <option value="">-- Sélectionner --</option>
                @foreach($produits as $produit)
                    <option value="{{ $produit->id }}">{{ $produit->nom }}</option>
                @endforeach
            </select>
            @error('produit_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Quantité stockée</label>
            <input type="number" name="quantite_stockee" class="form-control" required>
            @error('quantite_stockee')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Lieu de stockage</label>
            <input type="text" name="lieu_stockage" class="form-control" required>
            @error('lieu_stockage')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-success">Enregistrer</button>
        <a href="{{ route('stockage.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
