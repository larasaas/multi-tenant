<?php

namespace Larasaas\Tenant\JWT;

use Carbon\Carbon;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Cache;
use Paulvl\JWTGuard\JWT\Token\CommonJWT;
use Paulvl\JWTGuard\JWT\Token\ErrorToken;
use Paulvl\JWTGuard\JWT\Token\RefreshJWT;
use Paulvl\JWTGuard\JWT\Token\TokenInterface;

class JWTManager
{
    private $key;

    public $jwtTokenDuration;

    public $enableRefreshToken;

    public $jwtRefreshTokenDuration;

    const REFRESH_TOKEN = RefreshJWT::class;
    const COMMON_TOKEN = CommonJWT::class;

    /**
     * JWTManager constructor.
     * @param $key
     */
    public function __construct($key, $jwtTokenDuration, $enableRefreshToken, $jwtRefreshTokenDuration)
    {
        $this->key = $key;
        $this->jwtTokenDuration = $jwtTokenDuration  * 60;
        $this->enableRefreshToken = $enableRefreshToken;
        $this->jwtRefreshTokenDuration = $jwtRefreshTokenDuration * 86400;
    }

    public function issue(array $data = [])
    {
        $refreshTokenReferenceData = [];
        $apiTokenReferenceData = [];
        $refreshTokenJit = uniqid(str_random(random_int(3,33)), true);

        if ($this->enableRefreshToken) {
            $refreshTokenReferenceData["rti"] = $refreshTokenJit;
            $refreshTokenReferenceData["rtd"] = $this->jwtRefreshTokenDuration;
        }

        $apiToken = new CommonJWT(array_merge($data, $refreshTokenReferenceData), $this->key, $this->jwtTokenDuration);

        $tokens = [
            'api_token' => $apiToken->encoded()
        ];

        if ($this->enableRefreshToken) {

            $refreshTokenData = array(
                "jti"   => $refreshTokenJit,
//                "exp"   => $apiToken->exp(),  //千万不能要，下面merge的时候，refresh_token的过期时间不对。
                "nbf"   => $apiToken->nbf(),
                "rtt"   => $apiToken->jti()
            );

            $refreshToken = new RefreshJWT(array_merge($refreshTokenData, $data), $this->key, $this->jwtRefreshTokenDuration);

            $tokens = array_merge($tokens, [
                'refresh_token' => $refreshToken->encoded()
            ]);

        }
        return $tokens;
    }

    public function rebuild($rawToken)
    {
        try {
            $decodedToken = $this->decode($rawToken);
            if (isset($decodedToken->rtt)) {
                return new RefreshJWT($rawToken, $this->key);
            } else {
                return new CommonJWT($rawToken, $this->key);
            }
        } catch (Exception $e) {
            $errorToken = new ErrorToken(null, null);
            $errorToken->setStatus(CommonJWT::getErrorType($e));
            return $errorToken;
        }
    }

    public function decode($rawToken)
    {
        $decode= JWT::decode($rawToken, $this->key, array('HS256'));
        return $decode;
    }

    public function validateToken(TokenInterface $token)
    {
        return $token->status();
    }

    public function isBlacklisted($token)
    {
        $decodedToken = $this->decode($token);

        $cachedReference = Cache::tags(['jtw_token', 'blacklist'])->get($decodedToken->jti);

        return !is_null($cachedReference);
    }

    public function blacklist($token)
    {
        $decodedToken = $this->decode($token);
    }

}