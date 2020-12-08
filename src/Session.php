<?php

namespace App\backend;

use App\Auth\Authentication;

/**
 * Fichier de classe gestionnaire des variables de session.
 */
class Session extends Authentication
{
    /**
     * Initie la variable de session qui permet d'identifier l'utilisateur
     * connecté.
     * 
     * @param mixed $value
     */
    public static function setSessionId($value)
    {
        $_SESSION["session_id"] = $value;
    }

    /**
     * Retourne l'identifiant de la session de l'utilisateur.
     * 
     * @return string
     */
    public static function getSessionId()
    {
        return $_SESSION["session_id"];
    }
}