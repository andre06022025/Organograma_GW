<?php

use App\Http\Controllers\OrganogramaController;
use App\Http\Controllers\ColaboradorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to organograma
Route::get('/', function () {
    return redirect()->route('organograma.index');
});

// Organograma routes
Route::prefix('organograma')->name('organograma.')->group(function () {
    Route::get('/', [OrganogramaController::class, 'index'])->name('index');
    Route::get('/detalhes/{id}', [OrganogramaController::class, 'detalhes'])->name('detalhes');
});

// Cadastros routes (sem autenticação)
Route::prefix('cadastros')->name('cadastros.')->group(function () {
    Route::resource('colaboradores', ColaboradorController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->parameters(['colaboradores' => 'colaborador']);
});