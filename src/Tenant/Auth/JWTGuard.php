<?php

namespace Larasaas\Tenant\Auth;

//use Illuminate\Auth\GuardHelpers;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;

// use Larasaas\Tenant\Providers\UserProvider;
use Paulvl\JWTGuard\JWT\Token\CommonJWT;
use Paulvl\JWTGuard\JWT\Token\RefreshJWT;
use Larasaas\Tenant\JWT\JWTManager;

class JWTGuard implements Guard, JWTGuardInterface
{
    use GuardHelpersTrait, JWTGuardTrait ;

    public function __construct(UserProvider $provider, Request $request, JWTManager $jwtManager)
    {
        $this->request = $request;
        $this->provider = $provider;
        $this->jwtManager = $jwtManager;
        $this->inputKey = 'api_token';
    }


    public function getUserFromToken()
    {
        if ($this->token() instanceof CommonJWT && $this->validateToken() === true) {

            return $this->provider->retrieveById($this->token()->get()->id);
        }

        return null;
    }

    public function refreshToken()
    {
        if ($this->token() instanceof RefreshJWT && $this->validateToken() === true) {
            $user = $this->provider->retrieveById($this->token()->get()->id);
            $this->token()->blacklist();
            return $this->issueToken($user);
        }

        return null;
    }

    public function blacklistToken()
    {
        if (($this->token() instanceof CommonJWT || $this->token() instanceof RefreshJWT) && $this->validateToken() === true) {
            $this->token()->blacklist();
            return true;
        }
        return false;
    }
}
