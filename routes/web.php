<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
    Route::get('/todos', [App\Http\Controllers\TodoController::class, 'index'])->name('todos');
    Route::post('/todos/store', [App\Http\Controllers\TodoController::class, 'store'])->name('todos.store');
    Route::put('/todos/{todo}/update', [App\Http\Controllers\TodoController::class, 'update'])->name('todos.update');
    Route::delete('/todos/{todo}', [App\Http\Controllers\TodoController::class, 'destroy'])->name('todos.delete');
    Route::put('/todos/{todo}/updatetask', [App\Http\Controllers\TodoController::class, 'updateTask'])->name('todos.updatetask');

    Route::get('/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
    Route::get('/role/{id}/delete', [App\Http\Controllers\RoleController::class, 'destroy'])->name('role.destroy');
    Route::get('/role/{id}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->name('role.edit');
    Route::patch('/role/{id}/update', [App\Http\Controllers\RoleController::class, 'update'])->name('role.update');
    Route::get('/role/create', [App\Http\Controllers\RoleController::class, 'create'])->name('role.create');
    Route::post('/role/store', [App\Http\Controllers\RoleController::class, 'store'])->name('role.store');


    Route::get('/permissions', [App\Http\Controllers\PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permission/create', [App\Http\Controllers\PermissionController::class, 'create'])->name('permission.create');
    Route::post('/permission/store', [App\Http\Controllers\PermissionController::class, 'store'])->name('permission.store');

    Route::get('/get-permissions', function () {
        return auth()->check()?auth()->user()->jsPermissions():0;
    });
});


require __DIR__.'/auth.php';
