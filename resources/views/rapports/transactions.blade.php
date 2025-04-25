<!DOCTYPE html>
<html>
<head>
    <title>Rapport des Transactions</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #000; text-align: left; }
    </style>
</head>
<body>
    <h2>Rapport des Ventes et Distributions</h2>
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Type</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Acheteur / Bénéficiaire</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->produit->nom }}</td>
                    <td>{{ $transaction->type_transaction }}</td>
                    <td>{{ $transaction->quantite }}</td>
                    <td>{{ $transaction->prix_unitaire ?? '-' }}</td>
                    <td>{{ $transaction->destinataire }}</td>
                    <td>{{ $transaction->date_transaction }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
