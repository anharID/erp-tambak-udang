<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('hakSuperadmin', function ($user) {
            return $user->role == 'superadmin';
        });
        Gate::define('hakDirektur', function ($user) {
            return $user->role == 'superadmin' || $user->role == 'direktur';
        });
        Gate::define('hakTeknisi', function ($user) {
            return $user->role == 'superadmin' || $user->role == 'direktur' || $user->role == 'teknisi';
        });
        Gate::define('aksesKaryawan', function ($user) {
            return $user->role == 'admin' || $user->role == 'superadmin' || $user->role == 'direktur';
        });
        Gate::define('aksesFinansial', function ($user) {
            return $user->role == 'manajer keuangan' || $user->role == 'superadmin' || $user->role == 'direktur';
        });
        Gate::define('aksesInventarisKolamPeralatan', function ($user) {
            return $user->role == 'admin' || $user->role == 'superadmin' || $user->role == 'direktur' || $user->role == 'teknisi';
        });
    }
}
