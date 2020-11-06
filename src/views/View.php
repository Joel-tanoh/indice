<?php

namespace App\views;

/**
 * Classe View. Regroupe toutes les vues de l'application.
 */
class View
{

    public function index()
    {
        return <<<HTML
HTML;
    }

    public function pageNotFound()
    {
        return "Vue de la page 404";
    }
}