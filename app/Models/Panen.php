<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panen extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'panen';

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
