<?php

use Illuminate\Support\Facades\Route;

// Área pública (catálogo + detalhes)
use App\Http\Controllers\Site\VehicleCatalogController;
use App\Http\Controllers\Site\VehicleController as SiteVehicleController;

// Área administrativa
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CarModelController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use App\Http\Controllers\Admin\VehiclePhotoController;

/*
|--------------------------------------------------------------------------
| Rotas Web
|--------------------------------------------------------------------------
*/

// HOME (catálogo público com filtros bonitos)
Route::get('/', [VehicleCatalogController::class, 'index'])->name('home');

// Página de detalhes do veículo (pública)
Route::get('/veiculos/{vehicle}', [SiteVehicleController::class, 'show'])->name('vehicles.show');

// Rotas de autenticação (Breeze)
require __DIR__.'/auth.php';

// Compat: após login, Breeze usa 'dashboard' → redireciona para o admin
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

// Área administrativa (precisa estar logado E ser admin)
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard admin → redireciona para veículos
        Route::get('/', fn () => redirect()->route('admin.vehicles.index'))->name('dashboard');

        // CRUDs
        Route::resources([
            'brands'        => BrandController::class,
            'models'        => CarModelController::class,
            'colors'        => ColorController::class,
            'vehicles'      => AdminVehicleController::class,
            'vehiclephotos' => VehiclePhotoController::class, // se não usar, pode remover
        ]);
    });



