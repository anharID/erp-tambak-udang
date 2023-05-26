<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KolamController;
use App\Http\Controllers\SiklusController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\FinansialController;
use App\Http\Controllers\MonitoringController;

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



    //Siklus
    Route::get('/dashboard/kolam/{kolamId}/tambah-siklus', [SiklusController::class, 'create'])->name('tambah_siklus');
    Route::post('/dashboard/kolam/{kolamId}/tambah-siklus/store', [SiklusController::class, 'addSiklus'])->name('store_siklus');
    Route::post('/dashboard/kolam/{kolamId}/tutup-siklus', [SiklusController::class, 'tutupSiklus'])->name('tutup_siklus');

    //Monitoring
    Route::get('/dashboard/kolam/{kolamId}/siklus/{siklus}/monitoring', [MonitoringController::class, 'index'])->name('monitoring');
    Route::get('/dashboard/kolam/{kolamId}/siklus/{siklus}/monitoring/create', [MonitoringController::class, 'create'])->name('monitoring.create');
    Route::post('/dashboard/kolam/{kolamId}/siklus/{siklus}/monitoring/store', [MonitoringController::class, 'store'])->name('monitoring.store');
    Route::get('/dashboard/kolam/{kolamId}/siklus/{siklus}/monitoring/{monitoring}/edit', [MonitoringController::class, 'edit'])->name('monitoring.edit');
    Route::put('/dashboard/kolam/{kolamId}/siklus/{siklus}/monitoring/{monitoring}/update', [MonitoringController::class, 'update'])->name('monitoring.update');
    Route::delete('/dashboard/kolam/{kolamId}/siklus/{siklus}/monitoring/{monitoring}/delete', [MonitoringController::class, 'destroy'])->name('monitoring.destroy');

    //Kolam
    Route::get('/dashboard/kolam/{kolam}/siklus/{siklus}', [KolamController::class, 'dataKolam'])->name('data_kolam');
    Route::resource('/dashboard/kolam', KolamController::class);

    Route::resource('/dashboard/users', UserController::class);
    Route::resource('/dashboard/karyawan', KaryawanController::class);
    Route::resource('/dashboard/finansial', FinansialController::class);
});

require __DIR__ . '/auth.php';
