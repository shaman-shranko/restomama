<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use function foo\func;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('accessAdminPanel', function ($user) {
            foreach($user->roles as $role){
                switch($role->alias){
                    case 'administrator':
                    case 'superuser':
                    case 'seo':
                    case 'content_manager':
                    case 'client_manager':
                    case 'restaurant':
                    case 'restaurant_manager':
                        return true;
                        break;
                }
            }
            return false;
        });
        Gate::define('accessAccount', function($user){
            foreach($user->roles as $role){
                switch($role->alias){
                    case 'customer':
                        return true;
                        break;
                }
            }
            return false;
        });
        Gate::define('edit-restaurant-categories', function ($user){
            foreach($user->roles as $role){
                switch($role->alias){
                    case 'administrator':
                    case 'superuser':
                    case 'seo':
                    case 'content_manager':
                        return true;
                        break;
                }
            }
            return false;
        });
        Gate::define('edit-cities', function ($user){
            foreach($user->roles as $role){
                switch($role->alias){
                    case 'administrator':
                    case 'superuser':
                    case 'seo':
                    case 'content_manager':
                        return true;
                        break;
                }
            }
            return false;
        });
        Gate::define('edit-restaurants', function ($user){
            foreach($user->roles as $role){
                switch($role->alias){
                    case 'administrator':
                    case 'superuser':
                    case 'seo':
                    case 'content_manager':
                        return true;
                        break;
                }
            }
            return false;
        });
        Gate::define('moderate-restaurants', function($user){
           foreach($user->roles as $role){
               switch($role->alias){
                   case 'superuser':
                   case 'administrator':
                   case 'client_manager':
                   case 'restaurant':
                   case 'restaurant_manager':
                       return true;
                       break;
               }
           }
           return false;
        });
        Gate::define('editSettings', function($user){
            foreach($user->roles as $role){
                switch($role->alias){
                    case 'superuser':
                    case 'administrator':
                        return true;
                        break;
                }
            }
           return false;
        });
        Gate::define('edit-articles', function($user){
            foreach($user->roles as $role){
                switch($role->alias){
                    case 'superuser':
                    case 'administrator':
                        return true;
                        break;
                }
            }
            return false;
        });
        Gate::define('create-users', function($user){
            foreach($user->roles as $role){
                switch($role->alias){
                    case 'superuser':
                    case 'administrator':
                        return true;
                        break;
                }
            }
            return false;
        });
    }
}
