<?php

namespace App\Models;

use App\Models\Inventaris;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logistik extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'logistik';

    // One-to-Many Relationship
    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Listen for the "deleting" event
        static::deleting(function ($logistik) {
            $inventaris = $logistik->inventaris;

            // Retrieve the original stok value of the Inventaris before any Logistik data was added
            $stokOriginal = $inventaris->getOriginal('stok');

            // Calculate the total stok_masuk and stok_keluar values related to the Inventaris
            $totalStokMasuk = $inventaris->logistik()->sum('stok_masuk');
            $totalStokKeluar = $inventaris->logistik()->sum('stok_keluar');

            // Adjust the total stok_masuk and stok_keluar values based on the deleting logistik entry
            $totalStokMasuk = $logistik->stok_masuk;
            $totalStokKeluar = $logistik->stok_keluar;

            // Revert the stok value in the Inventaris model to the original value
            $stokInventaris = $stokOriginal - $totalStokMasuk + $totalStokKeluar;

            // Ensure the stok value doesn't go below zero
            $inventaris->stok = max(0, $stokInventaris);

            // Recalculate the nilai_inventaris value
            $inventaris->nilai_inventaris = $inventaris->stok * $inventaris->harga_satuan;

            // Save the changes to the Inventaris model
            $inventaris->save();
        });
    }
}
