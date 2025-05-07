{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifier la transaction</h2>

    <form action="{{ route('transaction.update', $transaction) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Réutilise le même formulaire que dans create.blade.php, avec les valeurs déjà remplies -->
        <!-- Exemple : -->
        <div class="form-group">
            <label>Produit</label>
            <select name="produit_id" class="form-control">
                @foreach ($produits as $produit)
                    <option value="{{ $produit->id }}" {{ $transaction->produit_id == $produit->id ? 'selected' : '' }}>
                        {{ $produit->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Le reste du formulaire suit la même logique -->

        <button type="submit" class="btn btn-success">Mettre à jour</button>
    </form>
</div>
@endsection --}}
