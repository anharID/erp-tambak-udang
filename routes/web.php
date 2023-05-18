<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KolamController;
use App\Http\Controllers\SiklusController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

 Route::redirect('/', '/dashboard');


Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard/kolam/{kolamId}/tambah-siklus', [SiklusController::class, 'create'])->name('tambah_siklus');
    Route::post('/dashboard/kolam/{kolamId}/tambah-siklus/store', [SiklusController::class, 'addSiklus'])->name('store_siklus');

    Route::resource('/dashboard/users', UserController::class);
    Route::resource('/dashboard/karyawan', KaryawanController::class);
    Route::resource('/dashboard/kolam', KolamController::class);
});

require __DIR__ . '/auth.php';