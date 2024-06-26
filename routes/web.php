<?php

use App\Http\Controllers\DemandeLicenceController;
use App\Http\Controllers\LicenceChoisieController;
use App\Http\Controllers\LicenceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route des licences disponibles
    Route::resource('/licence', LicenceController::class);

    // Routes de licences choisies
    Route::resource('/mes-licences', LicenceChoisieController::class);
    Route::post('/mes-licences/ajouterLicenceClient', [LicenceChoisieController::class, 'ajouterLicenceClient'])->name('mes-licences.ajouterLicenceClient');
    Route::patch('/mes-licences/renouvelerLicenceClient/{demandeRenouvellement}', [LicenceChoisieController::class, 'renouvelerLicenceClient'])->name('mes-licences.renouvelerLicenceClient');

    // Routes de demandes de licences
    Route::resource('/demande-licence', DemandeLicenceController::class);
    Route::post('/demande-licence/renouveler/{licenceChoisie}', [DemandeLicenceController::class, 'renouveler'])->name('demande-licence.renouveler');
    Route::post('/demande-licence/ajouter/{licence}', [DemandeLicenceController::class, 'ajouter'])->name('demande-licence.ajouter');
});

require __DIR__.'/auth.php';
