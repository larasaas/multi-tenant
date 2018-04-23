<?php

namespace Larasaas\Tenant;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

interface JWTGuardInterface
{
    const API_TOKEN = "api_token";
    const REFRESH_TOKEN = "refresh_token";

    public function token();

    public function getTokenForRequest();

    public function getUserFromToken();

    public function tokenIsApi();

    public function tokenIsRefresh();

    public function validateToken($tokenType = null);

    public function validate(array $credentials = []);

    public function attempt(array $credentials = [], $issueToken = true);

    public function hasValidCredentials($user, $credentials);

    public function setRequest(Request $request);

    public function issueToken(AuthenticatableContract $user);

    public function refreshToken();

    public function blacklistToken();
}
