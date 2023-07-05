<?php

namespace App\Models;

use App\Models\Logistik;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'inventaris';

    // One-to-One Relationship
    public function logistik()
    {
        return $this->hasMany(Logistik::class);
    }
}
