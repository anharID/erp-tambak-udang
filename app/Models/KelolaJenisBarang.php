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

    public function inventaris()
    {
        return $this->HasMany(Inventaris::class);
    }
}
