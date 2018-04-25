<?php
/**
 * Created by PhpStorm.
 * User: zhoujun
 * Date: 2018/4/24
 * Time: 下午1:35
 */

namespace Larasaas\Tenant\Providers;


interface UserProvider
{
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById();

//    /**
//     * Retrieve a user by their unique identifier and "remember me" token.
//     *
//     * @param  mixed   $identifier
//     * @param  string  $token
//     * @return \Illuminate\Contracts\Auth\Authenticatable|null
//     */
//    public function retrieveByToken($identifier, $token);
//
//    /**
//     * Update the "remember me" token for the given user in storage.
//     *
//     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
//     * @param  string  $token
//     * @return void
//     */
//    public function updateRememberToken(Authenticatable $user, $token);
//
//    /**
//     * Retrieve a user by the given credentials.
//     *
//     * @param  array  $credentials
//     * @return \Illuminate\Contracts\Auth\Authenticatable|null
//     */
//    public function retrieveByCredentials(array $credentials);
//
//    /**
//     * Validate a user against the given credentials.
//     *
//     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
//     * @param  array  $credentials
//     * @return bool
//     */
//    public function validateCredentials(Authenticatable $user, array $credentials);
}
