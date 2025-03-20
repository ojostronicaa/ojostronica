<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\reservaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect('/reservas');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/reservas', [reservaController::class, 'index'])->name('reservas.index');
    Route::post('/reservar', [reservaController::class, 'reservar']);
    Route::post('/cancelar', [reservaController::class, 'cancelar']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
