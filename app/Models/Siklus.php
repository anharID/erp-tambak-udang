<?php

namespace App\Models;

use App\Models\Kolam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siklus extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'siklus';

    public function kolam(){
        return $this->belongsTo(Kolam::class, 'kolam_id');
    }
}
