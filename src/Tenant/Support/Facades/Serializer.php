<?php

namespace Larasaas\Tenant\Support\Facades;


use Illuminate\Support\Facades\Facade;

class Serializer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'jwt-auth-serializer';
    }
}
