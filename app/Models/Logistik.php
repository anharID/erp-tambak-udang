<?php

namespace App\Models;

use App\Models\Inventaris;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logistik extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'logistik';

    // One-to-Many Relationship
    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }
}
