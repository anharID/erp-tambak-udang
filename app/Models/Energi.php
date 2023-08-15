<?php

namespace App\Models;

use App\Models\User;
use App\Models\Kolam;
use App\Models\Siklus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Energi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'energi';

    public function kolam()
    {
        return $this->belongsTo(Kolam::class);
    }
    public function penggunaan()
    {
        return $this->belongsTo(PenggunaanEnergi::class);
    }
    public function siklus()
    {
        return $this->belongsTo(Siklus::class);
    }
}
