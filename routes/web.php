<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KolamController;
use App\Http\Controllers\PakanController;
use App\Http\Controllers\PanenController;
use App\Http\Controllers\EnergiController;
use App\Http\Controllers\SiklusController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\SamplingController;
use App\Http\Controllers\FinansialController;
use App\Http\Controllers\PeralatanController;
use App\Http\Controllers\PerlakuanController;
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

//TODO perbbaiki route dan midleware
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Siklus
    Route::get('/tambah-siklus', [SiklusController::class, 'create'])->middleware('role:superadmin,teknisi')->name('buat_siklus');
    Route::post('/tambah-siklus/store', [SiklusController::class, 'store'])->middleware('role:superadmin,teknisi')->name('siklus.store');
    Route::get('/siklus/{siklus}/edit', [SiklusController::class, 'edit'])->middleware('role:superadmin,teknisi')->name('edit_siklus');
    Route::put('/siklus/{siklus}/update', [SiklusController::class, 'updateSiklus'])->middleware('role:superadmin,teknisi')->name('update_siklus');



    // Route::get('/dashboard/kolam/{kolamId}/tambah-siklus', [SiklusController::class, 'create'])->middleware('role:superadmin,teknisi')->name('tambah_siklus');
    // Route::post('/dashboard/kolam/{kolamId}/tambah-siklus/store', [SiklusController::class, 'tambahSiklus'])->middleware('role:superadmin,teknisi')->name('store_siklus');
    // Route::put('/dashboard/kolam/{kolamId}/siklus/{siklus}/update', [SiklusController::class, 'updateSiklus'])->middleware('role:superadmin,teknisi')->name('update_siklus');
    // Route::delete('/dashboard/kolam/{kolamId}/siklus/{siklus}/delete', [SiklusController::class, 'destroy'])->middleware('role:superadmin,teknisi')->name('hapus_siklus');
    // Route::put('/dashboard/kolam/{kolamId}/tutup-siklus', [SiklusController::class, 'tutupSiklus'])->middleware('role:superadmin,teknisi')->name('tutup_siklus');

    //Kolam
    Route::get('/kolam/{kolam}/siklus/{siklus}', [KolamController::class, 'dataKolam'])->middleware('role:superadmin,admin,direktur,teknisi')->name('data_kolam');
    Route::resource('/kolam', KolamController::class)->middleware(['role:superadmin,admin,direktur,teknisi', 'detail-kolam']);
    Route::resource('/kolam/{kolamId}/siklus/{siklus}/monitoring', MonitoringController::class)->middleware('role:superadmin,admin,direktur,teknisi');
    Route::resource('/kolam/{kolamId}/siklus/{siklus}/sampling', SamplingController::class)->middleware('role:superadmin,admin,direktur,teknisi');
    Route::resource('/kolam/{kolamId}/siklus/{siklus}/pakan', PakanController::class)->middleware('role:superadmin,admin,direktur,teknisi');
    Route::resource('/kolam/{kolamId}/siklus/{siklus}/panen', PanenController::class)->middleware('role:superadmin,admin,direktur,teknisi');
    Route::resource('/kolam/{kolamId}/siklus/{siklus}/perlakuan', PerlakuanController::class)->middleware('role:superadmin,admin,direktur,teknisi');
    Route::resource('/kolam/{kolamId}/siklus/{siklus}/energi', EnergiController::class)->middleware('role:superadmin,admin,direktur,teknisi');


    Route::resource('/users', UserController::class)->middleware('role:superadmin');

    Route::resource('/karyawan', KaryawanController::class)->middleware('role:superadmin,admin,direktur');

    Route::resource('/finansial', FinansialController::class)->middleware('role:superadmin,admin,direktur,teknisi');

    Route::resource('/peralatan', PeralatanController::class)->middleware('role:superadmin,admin,direktur,teknisi');
});


require __DIR__ . '/auth.php';
