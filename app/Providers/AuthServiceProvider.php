<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Permission;



class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();

        // Dynamically register permissions with Laravel's Gate
        Permission::all()->each(function ($permission) {
            Gate::define($permission->name, function ($user) use ($permission) {
                return $user->hasPermission($permission->name);
            });
        });
    }
}
