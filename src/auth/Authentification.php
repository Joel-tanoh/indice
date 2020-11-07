<?php

namespace App\auth;

use App\Auth\Password;
use App\Models\Users\Administrator;
use App\Models\Learning\Users\Registered;
use App\Models\User;
use App\Utilities\Validator;

/**
 * Fichier de classe gestionnaire de l'authentification des utilisateurs.
 * 
 * @author Joel <joel.developpeur@gmail.com>
 */
class Authentification
{
    /**
     * Retourne le tableau contenant les valeurs de session.
     * 
     * @param string $sessionKey
     * 
     * @return array
     */
    public static function getSession(string $sessionKey = null)
    {
        if (null !== $sessionKey) {
            return $_SESSION[$sessionKey];
        }

        return $_SESSION;
    }

    /**
     * Retourne le tableau des valeurs de coockie.
     * 
     * @param string $cookieKey 
     * 
     * @return array
     */
    public function getCookies(string $cookieKey = null)
    {
        if (null !== $cookieKey) {
            return $_SESSION[$cookieKey];
        }

        return $_COOKIE;
    }
    
    /**
     * Initalise les variables de sessions en mettant le login de l'administrateur.
     * 
     * @param string $sessionKey   La clé de la session.
     * @param mixed  $sessionValue La valeur de la session
     * 
     * @return void
     */
    public static function setSession($sessionKey, $sessionValue)
    {
        $_SESSION[$sessionKey] = ucfirst($sessionValue);
    }

    /**
     * Initialise les variables de cookie.
     * 
     * @param mixed  $cookieKey La clé identifiant le cookie.
     * @param mixed  $value     La valeur
     * @param string $domain 
     * 
     * @return void
     */
    public static function setCookie($cookieKey, $value, $domain = null)
    {
        setcookie(
            $cookieKey,
            ucfirst($value),
            time()+(30*24*3600),
            null,
            $domain,
            false,
            true
        );
    }

    /**
     * Gère l'authentification des registereds.
     * 
     * @param string $emailAddress
     * @param string $password
     * 
     * @return bool
     */
    public static function authenticateUser($emailAddress, $password)
    {
        if (null === $emailAddress) {
            return false;
        } else {

            $validator = new Validator();

            if ($validator->isEmailAddress($emailAddress)) {

                $user = User::getByEmailAddress($emailAddress);

                if ($user) {

                    if (Password::verifyHash($password, $user->getPassword())) {
                        return true;
                    } else {
                        return false;
                    }

                } else {
                    return false;
                }

            } else {
                return false;
            }
        }
    }

}