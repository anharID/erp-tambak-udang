<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggunaanEnergi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'penggunaan_energi';

    public function energi()
    {
        return $this->hasMany(Energi::class);
    }
}
