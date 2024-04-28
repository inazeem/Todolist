<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\App\ProfileController;
use Illuminate\Foundation\Application;

use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Tenant Routesgit
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {



Route::get('/', function () {
    return Inertia::render('App/Welcome', [
        'canLogin' => Route::has('alogin'),
        'canRegister' => Route::has('aregister'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::get('/app/dashboard', function () {

    return Inertia::render('App/Dashboard');
})->middleware(['auth', 'verified'])->name('app.dashboard');

Route::middleware('auth')->prefix("app")->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
    Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
    Route::post('/users/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
    Route::post('/users/updateroles', [App\Http\Controllers\UserController::class, 'updateRoles'])->name('user.updateroles');

    Route::get('/todos', [App\Http\Controllers\TodoController::class, 'index'])->name('todos');
    Route::post('/todos/store', [App\Http\Controllers\TodoController::class, 'store'])->name('todos.store');
    Route::put('/todos/{todo}/update', [App\Http\Controllers\TodoController::class, 'update'])->name('todos.update');
    Route::delete('/todos/{todo}', [App\Http\Controllers\TodoController::class, 'destroy'])->name('todos.delete');
    Route::put('/todos/{todo}/updatetask', [App\Http\Controllers\TodoController::class, 'updateTask'])->name('todos.updatetask');

    Route::get('/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
    Route::delete('/role/{id}/delete', [App\Http\Controllers\RoleController::class, 'destroy'])->name('role.destroy');
    Route::get('/role/{id}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->name('role.edit');
    Route::patch('/role/{id}/update', [App\Http\Controllers\RoleController::class, 'update'])->name('role.update');
    Route::get('/role/create', [App\Http\Controllers\RoleController::class, 'create'])->name('role.create');
    Route::post('/role/store', [App\Http\Controllers\RoleController::class, 'store'])->name('role.store');
    Route::post('/role/updatepermissions', [App\Http\Controllers\RoleController::class, 'updaetPermissions'])->name('role.updatepermissions');




    Route::get('/permissions', [App\Http\Controllers\PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permission/create', [App\Http\Controllers\PermissionController::class, 'create'])->name('permission.create');
    Route::post('/permission/store', [App\Http\Controllers\PermissionController::class, 'store'])->name('permission.store');
    Route::post('/permission/assignole', [App\Http\Controllers\PermissionController::class, 'assignRole'])->name('permission.assignrole');


});



require __DIR__.'/tenant_auth.php';

});


