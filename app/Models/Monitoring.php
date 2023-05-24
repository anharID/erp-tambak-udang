<?php

namespace App\Models;

use App\Models\User;
use App\Models\Kolam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Monitoring extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'kualitas_air';

    public function kolam()
    {
        return $this->belongsTo(Kolam::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function siklus()
    {
        return $this->belongsTo(Siklus::class);
    }
}
