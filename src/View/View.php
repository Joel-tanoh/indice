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

        <div class="container-fluid">
            <div class="row">
                <aside class="d-none d-lg-block col-lg-2">
                    Publicité
                </aside>
                <aside class="col-12 col-lg-8">       
                    <!-- Trending Categories Section Start -->
                    {$categoryView->trendingCategoriesSection()}
                    <!-- Trending Categories Section End -->

                    <!-- Featured Listings Start -->
                    {$annonceView->featuredSection()}
                    <!-- Featured Listings End -->

                    <!-- Latest Announcements Section Start -->
                    {$annonceView->latestSection()}
                    <!-- Latest Announcements Section End -->
                    
                    <!-- Subscribe Section Start -->
                    {$userView->suscribeNewsletterSection()}
                    <!-- Subscribe Section End -->
                </aside>
                <aside class="d-none d-lg-block col-lg-2">
                    Publicité
                </aside>
            </div>
        </div>
HTML;
    }

    /**
     * La vue à afficher lorsqu'on ne trouve pas la ressource.
     * 
     * @return string
     */
    public static function page404(string $pageHeader, string $current)
    {
        $snippet = new Snippet();

        return <<<HTML
        {$snippet->pageHeader($pageHeader, $current)}

        <!-- Start Content -->
        <div class="error section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="error-content">
                            <div class="error-message">
                                <h2>404</h2>
                                <h3><span>En cours!</span> Ne vous inquitez pas, c'est nous le problème...</h3>
                            </div>
                            <form class="form-error-search">
                                <input type="search" name="search" class="form-control" placeholder="Une recherche...">
                                <button class="btn btn-common btn-search" type="button">Chercher</button>
                            </form>
                            <div class="description">
                                <span>Ou allons à l' <a href="">Accueil</a></span>
                            </div>
                        </div>
                    </div>
                </div>      
            </div>
        </div>
        <!-- End Content -->
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