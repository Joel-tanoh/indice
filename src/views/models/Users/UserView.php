<?php

namespace App\views\Models;

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
    public function __construct(\App\Models\User $user)
    {
        $this->user = $user;
    }
}