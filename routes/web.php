<?php
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StatistiqueController;
use App\Models\Produit;
use Illuminate\Http\Request;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/signup', function () {
    return view('auth.signup');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



Route::get('/produit', [ProduitController::class, 'index'])->name('produits.index');  // Afficher la liste des produits
Route::get('/produit/create', [ProduitController::class, 'create'])->name('produits.create');  // Créer un produit
Route::post('/produit', [ProduitController::class, 'store'])->name('produits.store');  // Enregistrer un produit
Route::put('/produit/{produit}', [ProduitController::class, 'update'])->name('produits.update');  // Mettre à jour un produit
// Route::get('/produit/{produit}', [ProduitController::class, 'show'])->name('produits.show');  // Voir un produit spécifique
Route::get('/produit/{produit}/edit', [ProduitController::class, 'edit'])->name('produits.edit');
Route::delete('/produit/{produit}', [ProduitController::class, 'destroy'])->name('produits.destroy');  // Supprimer un produit
Route::get('/produit/filter', [ProduitController::class, 'filter'])->name('produits.filter');
Route::get('/produit/search', [ProduitController::class, 'search'])->name('produits.search');




Route::get('/stockage', function () {
    return view('stockage.stock');
});


Route::get('/statistique', function () {
    return view('statistique.stat');
});

Route::get('/transaction', function () {
    return view('transaction.commande');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Route::middleware(['auth', 'role:admin'])->group(function () {
    //     Route::get('/admin', function () {
    //         return "Bienvenue sur le tableau de bord admin";
    //     });

});

require __DIR__.'/auth.php';
