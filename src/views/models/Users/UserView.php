<?php

namespace App\views\Models\users;

use App\views\Models\ModelView;

/**
 * Classe de gestion des vues de User.
 */
class UserView extends ModelView
{
    private $user;

    /**
     * Constructeur de la vue du user.
     * 
     * @param \App\Models\User $user
     */
    public function __construct(\App\Models\User $user = null)
    {
        $this->user = $user;
    }

    /**
     * Vue de la connexion.
     * 
     * @return string
     */
    public static function userConnexion()
    {
        return <<<HTML
        Vue pour la connexion d'un utilisateur
HTML;
    }

    /**
     * Vue pour la création d'un compte.
     * 
     * @return string
     */
    public static function createAccount()
    {
        return <<<HTML
        Vue pour la création d'un compte utilisateur.
HTML;
    }
}