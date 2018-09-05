<?php

namespace Larasaas\Tenant;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Larasaas\Tenant\Auth\JWTGuard;
use Larasaas\Tenant\Providers\JWTUserProvider;
use Larasaas\Tenant\JWT\JWTManager;
use Larasaas\Tenant\Support\Serializer;

class AuthClientServiceProvider extends ServiceProvider
{
    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__.'/../../config/jwt.php' => config_path('jwt.php')], 'config');

        $this->app['auth']->extend('jwt', function($app, $name, array $config)  {
            return new JWTGuard(
                new JWTUserProvider(),
                $app['request'],
                new JWTManager(
                    config('jwt.secret_key'),
                    config('jwt.jwt_token_duration'),
                    config('jwt.enable_refresh_token'),
                    config('jwt.refresh_token_duration')
                )
            );
        });

        $this->app->bind('jwt-auth-manager', function()
        {
            return new JWTManager(
                config('jwt.secret_key'),
                config('jwt.jwt_token_duration'),
                config('jwt.enable_refresh_token'),
                config('jwt.refresh_token_duration')
            );
        });


        $this->app->bind('jwt-auth-serializer', function()
        {
            return new Serializer(config('jwt.secret_key'));
        });
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }



//    public function retrieveById($identifier)
//    {
//        print_r($identifier);die();
//        $user = $this->conn->table($this->table)->find($identifier);
//
//        return $this->getGenericUser($user);
//    }
}
