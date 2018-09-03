<?php

namespace Larasaas\Tenant\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Larasaas\Tenant\Model;
use Larasaas\Tenant\Tenant;
use Paulvl\JWTGuard\JWT\Token\TokenInterface;
use Paulvl\JWTGuard\JWT\Token\CommonJWT;
use Paulvl\JWTGuard\JWT\Token\RefreshJWT;
use Paulvl\JWTGuard\JWT\Token\ErrorToken;

trait JWTGuardTrait
{

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The name of the field on the request containing the API token.
     *
     * @var string
     */
    protected $inputKey;

    protected $jwtManager;

    protected $token;

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (! is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        if (! empty($this->token())) {
            $user = $this->getUserFromToken();
        }

        return $this->user = $user;
    }

    public function token()
    {
        if (! is_null($this->token)) {
            return $this->token;
        }

        $rawToken = $this->getTokenForRequest();

        return $this->token = $this->jwtManager->rebuild($rawToken);
    }

    /**
     * Get the token for the current request.
     *
     * @return string
     */
    public function getTokenForRequest()
    {
        $token = $this->request->input($this->inputKey);

        if (empty($token)) {
            $token = $this->request->bearerToken();
        }

        return $token;
    }

    public function tokenIsApi()
    {
        return $this->token() instanceof CommonJWT;
    }

    public function tokenIsRefresh()
    {
        return $this->token() instanceof RefreshJWT;
    }

    public function validateToken($tokenType = null)
    {
        $errors = [];

        if (!is_null($tokenType) && !$this->token() instanceof ErrorToken) {
            switch ($tokenType) {
                case self::API_TOKEN:
                    if (!$this->tokenIsApi()) {
                        $errors['code'] = 401;
                        $errors['message'] = "Request must contain a valid API token.";
                        return $errors;
                    }
                    break;
                case self::REFRESH_TOKEN:
                    if (!$this->tokenIsRefresh()) {
                        $errors['code'] = 401;
                        $errors['message'] = "Request must contain a valid refresh token.";
                        return $errors;
                    }
                    break;
                default:
                    $errors['code'] = 401;
                    $errors['message'] = "Token must be a $tokenType.";
                    return $errors;

            }
        }

        $tokenStatus = $this->jwtManager->validateToken($this->token());

        switch ($tokenStatus) {
            case TokenInterface::BEFORE_VALID_TOKEN:
                $errors['code'] = 403;
                $errors['message'] = 'Token can not be used yet.';
                break;
            case TokenInterface::EXPIRED_TOKEN:
                $errors['code'] = 401;
                $errors['message'] = 'Token is expired.';
                break;
            case TokenInterface::DOMAIN_INVALID_TOKEN:
                $errors['code'] = 401;
                $errors['message'] = 'Token is invalid.';
                break;
            case TokenInterface::SIGNATURE_INVALID_TOKEN:
                $errors['code'] = 401;
                $errors['message'] = 'Token is invalid.';
                break;
            case TokenInterface::BLACKLISTED_TOKEN:
                $errors['code'] = 401;
                $errors['message'] = 'Token is invalid.';
                break;
            case null:
                $errors['code'] = 401;
                $errors['message'] = 'Unauthenticated.';
                break;
        }

        return empty($errors) ? true : $errors;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {

        if ($this->provider->retrieveByCredentials($credentials)) {
            return true;
        }

        return false;
    }

    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param  array  $credentials
     * @param  bool   $remember
     * @param  bool   $login
     * @return bool
     */
    public function attempt(array $credentials = [], $issueToken = true)
    {
        $user = $this->provider->retrieveByCredentials($credentials);

        // If an implementation of UserInterface was returned, we'll ask the provider
        // to validate the user against the given credentials, and if they are in
        // fact valid we'll log the users into the application and return true.
        if ($this->hasValidCredentials($user, $credentials)) {
            if ($issueToken) {
                return $this->issueToken($user);
            }

            return true;
        }

        return false;
    }

    /**
     * Determine if the user matches the credentials.
     *
     * @param  mixed  $user
     * @param  array  $credentials
     * @return bool
     */
    public function hasValidCredentials($user, $credentials)
    {
        return ! is_null($user) && $this->provider->validateCredentials($user, $credentials);
    }

    /**
     * Set the current request instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }



    public function issueToken(AuthenticatableContract $user)
    {
        $tenant= Tenant::find($user->tenant_id);
//        return $this->jwtManager->issue([
//            'tenant_id'=>$user->tenant_id,
//            'tenant_type'=>$tenant->type,
//            'id' => $user->id,
//            'account' =>$user->account,
//            'account_type'=>$user->account_type,
//            'name'=>$user->name,
//            'is_admin'=>$user->is_admin
//        ]);
        return $this->jwtManager->issue([
            't_i'=>$user->tenant_id,
            't_t'=>$tenant->type,
            'id' => $user->id,
            'ac' =>$user->account,
            'ac_t'=>$user->account_type,
            'na'=>$user->name,
            'is_a'=>$user->is_admin,
        ]);
//        return $this->jwtManager->issue($user);


    }
}
