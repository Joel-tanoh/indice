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
     * @param string $userEmailAddress
     */
    public static function activate(string $userEmailAddress)
    {
        $_SESSION["session_id"] = $userEmailAddress;
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

    /**
     * Permet de désactiver la session de l'user connecté.
     * 
     * @return void
     */
    public static function deactivate()
    {
        session_start();
        session_unset();
        session_destroy();
    }
}