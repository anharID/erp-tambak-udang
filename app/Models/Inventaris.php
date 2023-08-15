<?php

namespace App\Models;

use App\Models\KelolaJenisBarang;
use App\Models\Logistik;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'inventaris';

    public function kelolajenisbarang()
    {
        return $this->belongsTo(KelolaJenisBarang::class, 'jenisbarang_id');
    }
    
    public function logistik()
    {
        return $this->hasMany(Logistik::class);
    }
}
