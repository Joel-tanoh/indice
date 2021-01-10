<?php

namespace App\Auth;

/**
 * Fichier de classe gestionnaire des variables de session.
 */
class Session extends Authentication
{
    const KEY = "AxbjZteKoPflTdjUheXsDtvAjOp";

    /**
     * Initie la variable de session qui permet d'identifier l'utilisateur
     * connecté.
     * 
     * @param string $value
     */
    public static function activate(string $value)
    {
        $_SESSION[self::KEY] = $value;
    }

    /**
     * Permet de vérifier si la session est active.
     * 
     * @return bool
     */
    public static function isActive()
    {
        return isset($_SESSION[self::KEY]) && !empty($_SESSION[self::KEY]);
    }

    /**
     * Retourne l'identifiant de la session de l'utilisateur.
     * 
     * @return string
     */
    public static function get()
    {
        if (self::isActive()) {
            return $_SESSION[self::KEY];
        }
    }

    /**
     * Permet de désactiver la session de l'user connecté.
     * 
     * @return void
     */
    public static function deactivate()
    {
        session_unset();
        session_destroy();
    }
}