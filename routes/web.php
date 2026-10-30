<?php

use App\Http\Controllers\OrganogramaController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\UsuarioController;
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

// Login routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.post');

Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Organograma routes
Route::prefix('organograma')->name('organograma.')->group(function () {
    Route::get('/', [OrganogramaController::class, 'index'])->name('index');
    Route::get('/api', [OrganogramaController::class, 'api'])->name('api');
    Route::get('/buscar', [OrganogramaController::class, 'buscar'])->name('buscar');
    Route::get('/detalhes/{id}', [OrganogramaController::class, 'detalhes'])->name('detalhes');
});

// Cadastros routes (protegidas por autenticação + perfil de gestão)
Route::middleware(['auth', 'gestao'])->group(function () {
    Route::prefix('cadastros')->name('cadastros.')->group(function () {
        Route::resource('colaboradores', ColaboradorController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('usuarios', UsuarioController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    });
});