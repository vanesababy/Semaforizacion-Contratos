<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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


    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/roles', [UserController::class, 'vistaroles'])->name('rol.rol');
    Route::get('/usuarios/{id}/edit', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');
    Route::get('/usuarios/crear', [UserController::class, 'createUser'])->name('usuarios.create');
    Route::post('/usuarios-crear', [UserController::class, 'storeUser'])->name('usuarios.store');

    Route::get('roles/{id}/edit', [UserController::class, 'editRole'])->name('roles.edit');
    Route::put('roles/{id}', [UserController::class, 'updateRole'])->name('roles.update');
    Route::get('roles/create', [UserController::class, 'createRole'])->name('roles.create');
    Route::post('roles', [UserController::class, 'storeRole'])->name('roles.store');
    Route::delete('/roles/{id}', [UserController::class, 'deleteRole'])->name('roles.delete');

    
   

















});



require __DIR__.'/auth.php';
