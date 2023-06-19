<?php

namespace App\Models;

use App\Models\Kolam;
use App\Models\Pakan;
use App\Models\Panen;
use App\Models\Energi;
use App\Models\Sampling;
use App\Models\Monitoring;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siklus extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'siklus';

    public function kolam()
    {
        return $this->belongsTo(Kolam::class, 'kolam_id');
    }

    public function monitoring()
    {
        return $this->hasMany(Monitoring::class);
    }
    public function sampling()
    {
        return $this->hasMany(Sampling::class);
    }
    public function pakan()
    {
        return $this->hasMany(Pakan::class);
    }
    public function panen()
    {
        return $this->hasMany(Panen::class);
    }
    public function perlakuan()
    {
        return $this->hasMany(Perlakuan::class);
    }
    public function energi()
    {
        return $this->hasMany(Energi::class);
    }

    // public function getRouteKeyName()
    // {
    //     return 'tanggal_mulai';
    // }
}
