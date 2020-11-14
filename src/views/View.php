<?php

namespace App\views;

use App\Views\Models\AnnounceView;

/**
 * Classe View. Regroupe toutes les vues de l'application.
 */
class View
{
    /**
     * Vue de l'index de l'application.
     * 
     * @return string
     */
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
                <h1 class="text-primary">Exception capturée.</h1>
                <div class="h3 text-secondary">{$e->getMessage()}</div>
                <div>Excéption jetée dans {$e->getFile()} à la ligne {$e->getLine()}.</div>
            </div>
        </div>
HTML;
    }

}