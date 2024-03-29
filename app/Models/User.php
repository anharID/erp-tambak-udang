<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Pakan;
use App\Models\Energi;
use App\Models\Sampling;
use App\Models\Perlakuan;
use App\Models\Monitoring;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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
    public function perlakuan()
    {
        return $this->hasMany(Perlakuan::class);
    }
    public function energi()
    {
        return $this->hasMany(Energi::class);
    }
}
