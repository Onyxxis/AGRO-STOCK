<!DOCTYPE html>
<html>
<head>
    <title>Rapport des Transactions</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .period { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .totals { margin-top: 30px; }
        .totals div { margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rapport des Transactions</h1>
        @if($start_date && $end_date)
        <div class="period">
            Période du {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}
        </div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Produit</th>
                <th>Type</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Total</th>
                <th>Destinataire</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->date_transaction->format('d/m/Y') }}</td>
                <td>{{ $transaction->produit->nom }}</td>
                <td>{{ $transaction->type_transaction }}</td>
                <td>{{ $transaction->quantite }}</td>
                <td>
                    @if($transaction->type_transaction === 'Vente')
                    {{ number_format($transaction->prix_unitaire, 2) }} €
                    @else
                    -
                    @endif
                </td>
                <td>
                    @if($transaction->type_transaction === 'Vente')
                    {{ number_format($transaction->quantite * $transaction->prix_unitaire, 2) }} €
                    @else
                    -
                    @endif
                </td>
                <td>{{ $transaction->destinataire }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div><strong>Total Ventes:</strong> {{ $totalVentes }} unités</div>
        <div><strong>Total Distributions:</strong> {{ $totalDistributions }} unités</div>
        @if($chiffreAffaires > 0)
        <div><strong>Chiffre d'Affaires:</strong> {{ number_format($chiffreAffaires, 2) }} €</div>
        @endif
    </div>
</body>
</html>
