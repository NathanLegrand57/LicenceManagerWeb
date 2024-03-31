<?php

use App\Http\Controllers\DemandeLicenceController;
use App\Http\Controllers\LicenceChoisieController;
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
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/mes-licences', LicenceChoisieController::class);
    Route::resource('/demande-licence', DemandeLicenceController::class);
    Route::post('/demande-licence/renouveler/{licenceChoisie}', [DemandeLicenceController::class, 'renouveler'])->name('demande-licence.renouveler');
});

require __DIR__.'/auth.php';
