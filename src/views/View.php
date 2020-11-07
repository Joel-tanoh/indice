<?php

namespace App\views;

use App\Views\Models\AnnounceView;

/**
 * Classe View. Regroupe toutes les vues de l'application.
 */
class View
{
    public static function index()
    {
        $announceView = new AnnounceView();

        return <<<HTML
        <div class="container">
            {$announceView->showLastPosted(5)}
            {$announceView->showMoreViewed(5)}
        </div>
HTML;
    }

    public static function pageNotFound()
    {
        return "Vue de la page 404";
    }

    /**
     * La vue à afficher lorsqu'on rencontre une erreur de type exception.
     * 
     * @param \Error|\TypeError|\Exception|\PDOException $e
     */
    public static function exception($e)
    {
        return <<<HTML
        <div class="container">
            <div class="bg-white rounded p-3">
                <h1 class="text-primary">Erreur</h1>
                <div class="h3 text-secondary">{$e->getMessage()}</div>
                <div>{$e->getFile()} à la ligne {$e->getLine()}.</div>
            </div>
        </div>
HTML;
    }

}