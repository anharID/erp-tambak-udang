<?php

namespace App\Models;

use App\Models\Karyawan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jabatan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'jabatan';

    public function karyawan(): HasMany
    {
        return $this->hasMany(Karyawan::class);
    }
}
