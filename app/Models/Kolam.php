<?php

namespace App\Models;

use App\Models\Pakan;
use App\Models\Siklus;
use App\Models\Sampling;
use App\Models\Monitoring;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kolam extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'kolam';

    public function siklus()
    {
        return $this->hasMany(Siklus::class);
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
}
