<?php

namespace App\View;

use App\View\Model\AnnounceView;
use App\View\Model\CategoryView;
use App\View\Model\User\UserView;

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
        $categoryView = new CategoryView();
        $annonceView = new AnnounceView();
        $userView = new UserView();
        $snippet = new Snippet();

        return <<<HTML
        <!-- Hero Area -->
        {$snippet->heroArea(true)}
        <!-- Hero Area End -->

        <!-- Trending Categories Section Start -->
        {$categoryView->trendingCategoriesSection()}
        <!-- Trending Categories Section End -->

        <!-- Latest Announcements Section Start -->
        {$annonceView->latestSection()}
        <!-- Latest Announcements Section End -->
        
        <!-- Featured Listings Start -->
        {$annonceView->featuredSection()}
        <!-- Featured Listings End -->

        <!-- Subscribe Section Start -->
        {$userView->suscribeSection()}
        <!-- Subscribe Section End -->
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
            <div class="bg-white rounded my-3 p-3">
                <h1 class="text-primary">Exception capturée.</h1>
                <div class="h3 text-secondary">{$e->getMessage()}</div>
                <div>Excéption jetée dans {$e->getFile()} à la ligne {$e->getLine()}.</div>
            </div>
        </div>
HTML;
    }

}