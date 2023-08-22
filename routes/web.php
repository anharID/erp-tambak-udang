<?php

use App\Http\Controllers\DashboardController;
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
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\KelolaJenisBarangController;
use App\Http\Controllers\LogistikController;
use App\Http\Controllers\PeralatanController;
use App\Http\Controllers\PerlakuanController;
use App\Http\Controllers\MonitoringController;
use Illuminate\Support\Facades\Auth;

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


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Auth::routes(['verify' => true]);

//TODO perbaiki route dan midleware
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Siklus
    Route::get('/tambah-siklus', [SiklusController::class, 'create'])->middleware('role:superadmin,teknisi')->name('buat_siklus');
    Route::post('/tambah-siklus/store', [SiklusController::class, 'store'])->middleware('role:superadmin,teknisi')->name('siklus.store');
    Route::get('/siklus/{siklus}/edit', [SiklusController::class, 'edit'])->middleware('role:superadmin,teknisi')->name('edit_siklus');
    Route::put('/siklus/{siklus}/update', [SiklusController::class, 'updateSiklus'])->middleware('role:superadmin,teknisi')->name('update_siklus');
    Route::put('/siklus/{siklus}/tutup-siklus', [SiklusController::class, 'tutupSiklus'])->middleware('role:superadmin,teknisi')->name('tutup_siklus');
    Route::delete('/siklus/{siklus}/delete', [SiklusController::class, 'destroy'])->middleware('role:superadmin,teknisi')->name('hapus_siklus');

    Route::get('/siklus/budidaya/{siklus}/exportpdf', [SiklusController::class, 'export'])->name('exportpdf');
    Route::get('/finansial/{siklus}/exportpdf', [FinansialController::class, 'export'])->name('finansial_exportpdf');

    // Validasi
    Route::post('/kolam/{kolamId}/siklus/{siklus}/monitoring/{monitoring}/validasi', [MonitoringController::class, 'dataValidated'])->middleware('role:superadmin,teknisi')->name('validasi_monitoring');
    Route::post('/kolam/{kolamId}/siklus/{siklus}/pakan/{pakan}/validasi', [PakanController::class, 'dataValidated'])->middleware('role:superadmin,teknisi')->name('validasi_pakan');
    Route::post('/kolam/{kolamId}/siklus/{siklus}/sampling/{sampling}/validasi', [SamplingController::class, 'dataValidated'])->middleware('role:superadmin,teknisi')->name('validasi_sampling');
    Route::post('/kolam/{kolamId}/siklus/{siklus}/perlakuan/{perlakuan}/validasi', [PerlakuanController::class, 'dataValidated'])->middleware('role:superadmin,teknisi')->name('validasi_perlakuan');
    Route::post('/kolam/{kolamId}/siklus/{siklus}/panen/{panen}/validasi', [PanenController::class, 'dataValidated'])->middleware('role:superadmin,teknisi')->name('validasi_panen');

    //Kelola Jenis Barang
    Route::get('/inventaris/kelolajenisbarang', [KelolaJenisBarangController::class, 'index'])->middleware('role:superadmin')->name('kelola_barang');
    Route::get('/inventaris/kelolajenisbarang/create', [KelolaJenisBarangController::class, 'create'])->middleware('role:superadmin')->name('kelola_barang.create');
    Route::post('/inventaris/kelolajenisbarang/store', [KelolaJenisBarangController::class, 'store'])->middleware('role:superadmin')->name('kelola_barang.store');
    Route::get('/inventaris/kelolajenisbarang/{kelolajenisbarang}/edit', [KelolaJenisBarangController::class, 'edit'])->middleware('role:superadmin')->name('kelola_barang.edit');
    Route::put('/inventaris/kelolajenisbarang/{kelolajenisbarang}/update', [KelolaJenisBarangController::class, 'update'])->middleware('role:superadmin')->name('kelola_barang.update');
    Route::delete('/inventaris/kelolajenisbarang/{kelolajenisbarang}/destroy', [KelolaJenisBarangController::class, 'destroy'])->middleware('role:superadmin')->name('kelola_barang.destroy');

    //Kolam
    Route::get('/kolam/{kolam}/siklus/{siklus}', [KolamController::class, 'dataKolam'])->middleware('role:superadmin,admin,direktur,teknisi')->name('data_kolam');
    Route::resource('/kolam', KolamController::class)->middleware(['role:superadmin,admin,direktur,teknisi', 'detail-kolam']);

    Route::resource('/kolam/{kolamId}/siklus/{siklus}/monitoring', MonitoringController::class)->middleware(['role:superadmin,admin,direktur,teknisi', 'validated.data']);
    Route::resource('/kolam/{kolamId}/siklus/{siklus}/sampling', SamplingController::class)->middleware(['role:superadmin,admin,direktur,teknisi', 'validated.data']);
    Route::resource('/kolam/{kolamId}/siklus/{siklus}/pakan', PakanController::class)->middleware(['role:superadmin,admin,direktur,teknisi', 'validated.data']);
    Route::resource('/kolam/{kolamId}/siklus/{siklus}/panen', PanenController::class)->middleware(['role:superadmin,admin,direktur,teknisi', 'validated.data']);
    Route::resource('/kolam/{kolamId}/siklus/{siklus}/perlakuan', PerlakuanController::class)->middleware(['role:superadmin,admin,direktur,teknisi', 'validated.data']);
    Route::resource('/kolam/{kolamId}/siklus/{siklus}/energi', EnergiController::class)->middleware('role:superadmin,admin,direktur,teknisi');



    Route::resource('/users', UserController::class)->middleware('role:superadmin');

    Route::resource('/karyawan', KaryawanController::class)->middleware('role:superadmin,admin,direktur');

    Route::resource('/finansial', FinansialController::class)->middleware('role:superadmin,direktur,manajer keuangan');

    Route::resource('/peralatan', PeralatanController::class)->middleware('role:superadmin,admin,direktur,teknisi');

    Route::resource('/inventaris', InventarisController::class);
    Route::resource('/inventaris/{inventaris}/logistik', LogistikController::class);
    Route::post('/inventaris/{inventaris}/logistik/{logistik}', [LogistikController::class, 'update'])->name('logistik.update');
});



require __DIR__ . '/auth.php';
