@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifier le stock du produit : {{ $stock->produit->nom ?? 'Produit non défini' }}</h2>    <form method="POST" action="{{ $stock->id ? route('stockage.update', $stock->id) : '#' }}">
         @method('PUT')

        <div class="mb-3">
            <label>Quantité stockée</label>
            <input type="number" name="quantite_stockee" value="{{ old('quantite_stockee', $stock->quantite_stockee) }}" class="form-control" required>
            @error('quantite_stockee')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Lieu de stockage</label>
            <input type="text" name="lieu_stockage" value="{{ old('lieu_stockage', $stock->lieu_stockage) }}" class="form-control" required>
            @error('lieu_stockage')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('stockage.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
