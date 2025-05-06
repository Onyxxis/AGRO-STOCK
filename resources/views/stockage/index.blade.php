@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Liste des stocks</h2>
    <a href="{{ route('stockage.create') }}" class="btn btn-primary mb-3">Ajouter un stock</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité stockée</th>
                <th>Lieu de stockage</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $stock)
            <tr>
                <td>{{ $stock->produit->nom }}</td>
                <td>{{ $stock->quantite_stockee }}</td>
                <td>{{ $stock->lieu_stockage }}</td>
                <td>
                    <a href="{{ route('stockage.edit', $stock) }}" class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('stockage.destroy', $stock) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
