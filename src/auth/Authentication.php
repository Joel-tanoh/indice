<?php

namespace App\Auth;

use App\Auth\Password;
use App\Model\User\User;
use App\Utility\Utility;
use App\Utility\Validator;

/**
 * Fichier de classe gestionnaire de l'authentification des utilisateurs.
 * 
 * @author Joel <joel.developpeur@gmail.com>
 */
class Authentication
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
     * @param  $sessionValue La valeur de la session
     * 
     * @return void
     */
    public static function setSession($sessionKey, $sessionValue)
    {
        $_SESSION[$sessionKey] = ucfirst($sessionValue);
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

            if ($validator->email("email_address", $emailAddress)) {

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

    /**
     * Permet de rédiriger l'utilisateur sur sa
     * page de connexion s'il n'est pas authentifié.
     */
    public static function redirectUserIfNotAuthentified(string $where)
    {
        if (!Session::isActive() && !Cookie::userCookieIsset()) {
            Utility::redirect($where);
        }
    }

}