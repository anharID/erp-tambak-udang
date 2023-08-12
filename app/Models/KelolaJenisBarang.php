<?php

namespace App\Models;

use App\Models\Inventaris;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelolaJenisBarang extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'kelolajenisbarang';

    // One-to-Many Relationship
    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($kelolajenisbarang) {
            if ($kelolajenisbarang->isDirty('jenisbarang')) {
                Inventaris::where('jenis_barang', $kelolajenisbarang->getOriginal('jenisbarang'))
                    ->update(['jenis_barang' => $kelolajenisbarang->jenisbarang]);
            }
        });
    }
}
