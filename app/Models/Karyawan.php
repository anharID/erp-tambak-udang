<?php

namespace App\Models;

use App\Models\Jabatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'karyawan';

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
