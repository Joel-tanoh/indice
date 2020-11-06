<?php

namespace App\Views\Models;

use App\views\View;

/**
 * Classe de gestion des vues des annonces.
 */
class AnnounceView extends View
{
    protected $announce;

    /**
     * Constructeur de la vue des annonces.
     * 
     * @param \App\Models\Announce $announce
     */
    public function __construct(\App\Models\Announce $announce)
    {
        $this->announce = $announce;
    }
}