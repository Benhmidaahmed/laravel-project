<?php

namespace App\Services;

use App\Models\User;
use App\Models\Utilisateur;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Hash;

class CustomUserDetailsService implements UserProvider
{
    /**
     * Rehash the password if required.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @param  bool  $force
     * @return bool
     */
    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false): bool
    {
        if ($force || !Hash::check($credentials['password'], $user->password)) {
            $user->password = Hash::make($credentials['password']);
            if (method_exists($user, 'save')) {
                if ($user instanceof Utilisateur) {
                    if ($user instanceof Utilisateur) {
                        if ($user instanceof Utilisateur) {
                            if ($user instanceof Utilisateur) {
                                if ($user instanceof Utilisateur) {
                                    $user->save();
                                } else {
                                    throw new \RuntimeException('The user instance does not support the save method.');
                                }
                            } else {
                                throw new \RuntimeException('The user instance does not support the save method.');
                            }
                        } else {
                            throw new \RuntimeException('The user instance does not support the save method.');
                        }
                    } else {
                        throw new \RuntimeException('The user instance does not support the save method.');
                    }
                } else {
                    throw new \RuntimeException('The user instance does not support the save method.');
                }
            } else {
                throw new \RuntimeException('The save method is not defined for the user instance.');
            }
            return true;
        }

        return false;
    }
    /**
     * Retrieve the user by their email.
     *
     * @param  string  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        return Utilisateur::find($identifier);
    }

    /**
     * Retrieve the user by their email.
     *
     * @param  string  $email
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
{
    if (isset($credentials['email'])) {
        $user = Utilisateur::where('email', $credentials['email'])->first();
        return $user instanceof Utilisateur ? $user : null;
    }
    return null;
}

    public function retrieveByToken($identifier, $token)
{
    return Utilisateur::where('id', $identifier)
                      ->where('remember_token', $token)
                      ->first();
}

public function updateRememberToken(Authenticatable $user, $token)
{
    $user->setRememberToken($token);
    $user->save();
}


    /**
     * Retrieve a user by their credentials (email and password).
     *
     * @param  string  $email
     * @param  string  $password
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        if (Hash::check($credentials['password'], $user->password)) {
            return true;
        }

        return false;
    }

    /**
     * Retrieve the user by their email.
     *
     * @param  string  $email
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function retrieveByEmail($email)
    {
        return Utilisateur::where('email', $email)->first();
    }
}
