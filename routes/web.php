<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('sobre');
})->name('sobre');

/**
 * Rotas de autenticação
 */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');


/**
 * Rotas protegidas (somente para usuários logados)
 */
Route::middleware('auth')->group(function () {
    // Página de home com as tarefas do usuário
    Route::get('/home', [TaskController::class, 'index'])->name('home');

    // Criar, atualizar e excluir tarefas
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Rota para logout
    Route::post('/logout', function () {
        auth()->logout();
        return redirect()->route('login')->with('success', 'Você saiu com sucesso!');
    })->name('logout');
});

