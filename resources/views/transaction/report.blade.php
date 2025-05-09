{{-- <!DOCTYPE html>
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
                <td>{{ \Carbon\Carbon::parse($transaction->date_transaction)->format('d/m/Y') }}</td>
                <td>{{ $transaction->produit->nom }}</td>
                <td>{{ $transaction->type_transaction }}</td>
                <td>{{ $transaction->quantite }}</td>
                <td>
                    {{ number_format($transaction->prix_unitaire ?? 0, 0, ',', ' ') }} FCFA
                </td>
                <td>
                    {{ number_format(($transaction->quantite * $transaction->prix_unitaire) ?? 0, 0, ',', ' ') }} FCFA
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
        <div><strong>Chiffre d'Affaires:</strong> {{ number_format($chiffreAffaires, 0, ',', ' ') }} FCFA</div>
        @endif
    </div>
</body>
</html> --}}


<!DOCTYPE html>
<html>
<head>
    <title>Rapport des Transactions</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
            padding: 20px 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #055310;
            margin-bottom: 5px;
            font-size: 28px;
        }
        .header h2 {
            color: #2c3e50;
            margin-bottom: 5px;
            font-size: 24px;
        }
        .period {
            font-size: 16px;
            color: #7f8c8d;
            font-weight: 500;
        }
        .logo {
            height: 80px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        th {
            background-color: #3498db;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #f1f7fd;
        }
        .totals {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-top: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .totals div {
            margin-bottom: 12px;
            font-size: 15px;
            display: flex;
            justify-content: space-between;
            max-width: 300px;
        }
        .totals strong {
            color: #2c3e50;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 16px;
            color: #191a1a;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
        }
        .vente {
            background-color: #d4edda;
            color: #155724;
        }
        .distribution {
            background-color: #fff3cd;
            color: #856404;
        }
        .amount {
            font-weight: 600;
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="header">
        <!-- Remplacez par le chemin de votre logo si disponible-->
        <!-- <img src="{{ public_path('logo.png') }}" class="logo" alt="Logo"> -->
        <h1>AGRO-STOCK</h1>
        <h2>Rapport des Transactions</h2>
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
                <td>{{ \Carbon\Carbon::parse($transaction->date_transaction)->format('d/m/Y') }}</td>
                <td>{{ $transaction->produit->nom }}</td>
                <td>
                    <span class="badge {{ $transaction->type_transaction === 'vente' ? 'vente' : 'distribution' }}">
                        {{ $transaction->type_transaction }}
                    </span>
                </td>
                <td>{{ $transaction->quantite }}</td>
                <td class="amount">
                    {{ number_format($transaction->prix_unitaire ?? 0, 0, ',', ' ') }} FCFA
                </td>
                <td class="amount">
                    {{ number_format(($transaction->quantite * $transaction->prix_unitaire) ?? 0, 0, ',', ' ') }} FCFA
                </td>
                <td>{{ $transaction->destinataire }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div><strong>Total Ventes:</strong> <span class="amount">{{ $totalVentes }} unités</span></div>
        <div><strong>Total Distributions:</strong> <span class="amount">{{ $totalDistributions }} unités</span></div>
        @if($chiffreAffaires > 0)
        <div><strong>Chiffre d'Affaires:</strong> <span class="amount">{{ number_format($chiffreAffaires, 0, ',', ' ') }} FCFA</span></div>
        @endif
    </div>

    <div class="footer">
        Généré le {{ now()->format('d/m/Y à H:i') }} | © {{ date('Y') }} AGRO-STOCK. Groupe numero 10.
    </div>
</body>
</html>
