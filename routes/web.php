<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/signup', function () {
    return view('auth.signup');
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
});

Route::get('/produit', function () {
    return view('dashboard.produit');
});

Route::get('/stockage', function () {
    return view('dashboard.stock');
});

Route::get('/statistique', function () {
    return view('dashboard.stat');
});

Route::get('/transaction', function () {
    return view('dashboard.commande');
});
