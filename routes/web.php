<?php
use Illuminate\Http\Request; 

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ActController;

Route::get('/contracts/create', [ContractController::class, 'create'])->name('contracts.create');
Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');
Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.index');





Route::get('/', function () {
    return view('welcome');
});
Route::get('/contracts/{id}/edit', [ContractController::class, 'edit'])->name('contracts.edit');
Route::put('/contracts/{id}', [ContractController::class, 'update'])->name('contracts.update');
Route::put('/contracts/{contract}', [ContractController::class, 'update'])->name('contracts.update');

Route::get('/contracts/{contract}/acts/create', [ActController::class, 'create'])->name('acts.create');
Route::post('/contracts/{contract}/acts', [ActController::class, 'store'])->name('acts.store');
Route::get('/contracts/{contract}/acts', [ActController::class, 'index'])->name('contracts.acts.index');


