<?php
/**
 * Created by PhpStorm.
 * User: zhoujun
 * Date: 2018/4/24
 * Time: 下午1:35
 */

namespace Larasaas\Tenant\Providers;


use Illuminate\Auth\GenericUser;
use Illuminate\Support\Str;
//use Illuminate\Contracts\Auth\UserProvider;
//use Illuminate\Database\ConnectionInterface;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
//use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Larasaas\Tenant\Providers\Authenticatable as UserContract;
use Paulvl\JWTGuard\Support\Facades\JWTManager;

class JWTUserProvider implements UserProvider
{
    protected $conn;

    /**
     * The hasher implementation.
     *
     * @var \Illuminate\Contracts\Hashing\Hasher
     */
    protected $hasher;

    /**
     * The table containing the users.
     *
     * @var string
     */
    protected $table;


    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById()
    {
        $request=request();
        $token = $request->input('api_token');

        if (empty($token)) {
            $token = $request->bearerToken();
        }

       $jwt_data= JWTManager::decode($token,true);

        $user=[
            'id'=>$jwt_data->user_id,
            'tenant_id'=>$jwt_data->tenant_id,
            'name'=>$jwt_data->username
        ];
//        print_r($user);die();
//        return $user;

//        $user = $this->conn->table($this->table)->find($identifier);

        return $this->getGenericUser($user);
    }

//    /**
//     * Retrieve a user by their unique identifier and "remember me" token.
//     *
//     * @param  mixed  $identifier
//     * @param  string  $token
//     * @return \Illuminate\Contracts\Auth\Authenticatable|null
//     */
//    public function retrieveByToken($identifier, $token)
//    {
////        $user = $this->getGenericUser(
////            $this->conn->table($this->table)->find($identifier)
////        );
//////
////        return $user && $user->getRememberToken() && hash_equals($user->getRememberToken(), $token)
////            ? $user : null;
//    }
//
//    /**
//     * Update the "remember me" token for the given user in storage.
//     *
//     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
//     * @param  string  $token
//     * @return void
//     */
//    public function updateRememberToken(UserContract $user, $token)
//    {
////        $this->conn->table($this->table)
////            ->where($user->getAuthIdentifierName(), $user->getAuthIdentifier())
////            ->update([$user->getRememberTokenName() => $token]);
//    }
//
//    /**
//     * Retrieve a user by the given credentials.
//     *
//     * @param  array  $credentials
//     * @return \Illuminate\Contracts\Auth\Authenticatable|null
//     */
//    public function retrieveByCredentials(array $credentials)
//    {
////        if (empty($credentials) ||
////            (count($credentials) === 1 &&
////                array_key_exists('password', $credentials))) {
////            return;
////        }
////
////        // First we will add each credential element to the query as a where clause.
////        // Then we can execute the query and, if we found a user, return it in a
////        // generic "user" object that will be utilized by the Guard instances.
////        $query = $this->conn->table($this->table);
////
////        foreach ($credentials as $key => $value) {
////            if (! Str::contains($key, 'password')) {
////                $query->where($key, $value);
////            }
////        }
////
////        // Now we are ready to execute the query to see if we have an user matching
////        // the given credentials. If not, we will just return nulls and indicate
////        // that there are no matching users for these given credential arrays.
////        $user = $query->first();
////
////        return $this->getGenericUser($user);
//    }
//
//
//    /**
//     * Validate a user against the given credentials.
//     *
//     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
//     * @param  array  $credentials
//     * @return bool
//     */
//    public function validateCredentials(UserContract $user, array $credentials)
//    {
////        return $this->hasher->check(
////            $credentials['password'], $user->getAuthPassword()
////        );
//    }


//=======

    /**
     * Get the generic user.
     *
     * @param  mixed  $user
     * @return \Illuminate\Auth\GenericUser|null
     */
    protected function getGenericUser($user)
    {
        if (! is_null($user)) {
            return new GenericUser((array) $user);
        }

    }

}