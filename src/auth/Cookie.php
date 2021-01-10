<?php

namespace App\Auth;

/**
 * Classe gestionnaire des variables relatives aux cookie.
 */
class Cookie extends Authentication
{
    /** Clé de la cookie */
    const KEY = "XsAdkJbeFgHDkjEklOpQbxZtv";

    /**
     * Retourne la variable cookie pour la partie administration.
     * 
     * @return string
     */
    public static function getAdministratorCookieVar()
    {
        return $_COOKIE[self::KEY];
    }

    /**
     * Retourne le contenu de la variable cookie de l'id de session du visiteur.
     * 
     * @return string
     */
    public static function get()
    {
        if (isset($_COOKIE[self::KEY])) {
            return $_COOKIE[self::KEY];
        }
    }

    /**
     * Vérifie si l'id de session du visiteur existe.
     * 
     * @return bool
     */
    public static function userCookieIsset()
    {
        return null !== self::get();
    }

    /**
     * Initialise les variables de cookie.
     * 
     * @param  $cookieKey La clé identifiant le cookie.
     * @param  $value     La valeur
     * @param string $domain 
     * 
     * @return void
     */
    public static function setCookie($cookieKey, $value, $domain = null)
    {
        setcookie(
            $cookieKey,
            $value,
            time()+(30*24*3600),
            null,
            $domain,
            false,
            true
        );
    }

    /**
     * Permet de détruire la session.
     */
    public static function destroy($cookieKey, $domain = null)
    {
        setcookie($cookieKey, '', 0);
    }

}