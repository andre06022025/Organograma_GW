<?php

use App\Http\Controllers\OrganogramaController;
use App\Http\Controllers\Organograma2Controller;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\CadastroController;
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
    Route::post('/posicoes', [OrganogramaController::class, 'salvarPosicoes'])->name('posicoes');
    Route::post('/{colaborador}/foto', [OrganogramaController::class, 'atualizarFoto'])->name('foto');
});

// Organograma 2 (alternativo)
Route::prefix('organograma2')->name('organograma2.')->group(function () {
    Route::get('/', [Organograma2Controller::class, 'index'])->name('index');
    Route::post('/posicoes', [Organograma2Controller::class, 'salvarPosicoes'])->name('posicoes');
});

// Cadastros routes (sem autenticação)
Route::prefix('cadastros')->name('cadastros.')->group(function () {
    Route::get('/', [CadastroController::class, 'index'])->name('index');
    Route::get('create', [CadastroController::class, 'create'])->name('create');
    Route::post('/', [CadastroController::class, 'store'])->name('store');
    Route::get('{cadastro}/edit', [CadastroController::class, 'edit'])->name('edit');
    Route::put('{cadastro}', [CadastroController::class, 'update'])->name('update');

    Route::resource('colaboradores', ColaboradorController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->parameters(['colaboradores' => 'colaborador']);
});