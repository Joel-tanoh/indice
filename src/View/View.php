<?php

namespace App\View;

use App\View\Model\AnnounceView;
use App\View\Model\CategoryView;
use App\View\Communication\NewsletterView;

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
        $newsletterView = new NewsletterView();
        $snippet = new Snippet();
        $advertising = new AdvertisingView();

        return <<<HTML

        <!-- Hero Area -->
        {$snippet->heroArea(true)}

        <!-- Le corps de la page -->
        <div class="container-fluid">
            <!-- La barre de publicité en haut -->
            {$advertising->top()}
            <div class="row">
                <aside class="d-none d-lg-block col-lg-2">
                    {$advertising->left()}
                </aside>
                <aside class="col-12 col-lg-8">
                    <!-- Trending Categories Section Start -->
                    {$categoryView->trendingCategoriesSection()}
                    <!-- Trending Categories Section End -->

                    <!-- Premium Listings Start -->
                    <!-- {$annonceView->premiumSection()} -->

                    <!-- Latest Announcements Section Start -->
                    {$annonceView->latestSection()}
                    
                    <!-- Subscribe Section Start -->
                    {$newsletterView->suscribeNewsletterSection()}
                </aside>
                <aside class="d-none d-lg-block col-lg-2">
                    {$advertising->right()}
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
    public static function page404(string $message, string $current)
    {
        $snippet = new Snippet();
        $home = APP_URL;
        $searchView = new SearchView();
    
        return <<<HTML
        {$snippet->pageHeader("404", $current)}

        <!-- Start Content -->
        <div class="error section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="error-content">
                            <div class="error-message">
                                <h2>404</h2>
                                <h3>Ne vous inquitez pas, c'est nous le problème...</h3>
                                <p>{$message}</p>
                            </div>
                            {$searchView->notFoundSearch()}
                            <div class="description">
                                <span>Ou allons à l' <a href="$home">Accueil</a></span>
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
                <p class="h3 text-secondary">{$e->getMessage()}</p>
                <p>Excéption jetée dans {$e->getFile()} à la ligne {$e->getLine()}.</p>
            </div>
        </div>
HTML;
    }

    /**
     * Affiche la page de succès.
     * 
     * @return string
     */
    public static function success(string $title, string $content, string $link = null)
    {
        $snippet = new Snippet;

        return <<<HTML
        {$snippet->pageHeader("Félicitation !", "")}
        {$snippet->success($title, $content, $link)}
HTML;
    }

}