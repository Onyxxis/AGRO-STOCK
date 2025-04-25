<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;


class StatController extends Controller
{
    //
    public function index()
    {
        $ventes = Transaction::selectRaw('DATE(date_transaction) as date, SUM(quantite) as total')
            ->where('type_transaction', 'Vente')
            ->groupBy('date_transaction')
            ->orderBy('date_transaction')
            ->get();

        return view('statistique.stat', compact('ventes'));
    }
}
