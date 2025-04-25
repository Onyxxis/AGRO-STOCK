<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;

class RapportController extends Controller
{
    //
    public function exportPDF()
    {
        $transactions = Transaction::with('produit')->get();
        $pdf = Pdf::loadView('rapports.transactions', compact('transactions'));
        return $pdf->download('rapport-transactions.pdf');
    }
}
