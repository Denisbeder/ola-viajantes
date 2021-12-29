<?php

namespace App\Providers;

use App\Page;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Page' => 'App\Policies\PagePolicy',
        'App\Comment' => 'App\Policies\CommentPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->registerPermissions();
    }

    public function registerPermissions()
    {
        if (request()->is('admin/*')) {
            $configPermissions = collect(config('app.admin.permissions'));
            $routesPermissions = collect($configPermissions->pluck('route')->toArray());
            $pagesPermissions = Page::get(['id', 'manager']);

            //  Se o usuário for Super Admin da acesso total independente das permissions
            Gate::before(function ($user, $ability) {
                if ($user->is_super_admin) {
                    return true;
                }
            });

            // Se o usuário for Admin da acesso total para cada permission que o usuário tiver
            Gate::after(function ($user, $ability) {
                if ($user->is_admin) {
                    return true;
                }
            });

            // Define abilities das rotas estaticas
            foreach ($routesPermissions as $permission) {
                Gate::define($permission, function ($user) use ($permission) {
                    return collect($user->permissions['routes'] ?? [])->contains($permission);
                });
            }

            // Define abilities das paginas criadas
            foreach ($pagesPermissions as $page) {
                $ability = $page->present()->abilityName;
                Gate::define($ability, function ($user) use ($ability) {
                    return collect($user->permissions['pages'] ?? [])->contains($ability);
                });
            }
        }
    }
}
