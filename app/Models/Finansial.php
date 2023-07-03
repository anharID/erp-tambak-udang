<?php

namespace App\Models;

use App\Models\Siklus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finansial extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'finansial';

    public function siklus()
    {
        return $this->belongsTo(Siklus::class);
    }
}
