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
        $advertising = new AdvertisingView();

        return <<<HTML

        <!-- Hero Area -->
        {$snippet->heroArea(true)}

        <!-- Le corps de la page -->
        <div class="container-fluid">
            <!-- La barre de publicité en haut -->
            {$advertising->top()}
            <div class="row">
                {$advertising->side()}
                <aside class="col-12 col-lg-8">       
                    <!-- Trending Categories Section Start -->
                    {$categoryView->trendingCategoriesSection()}
                    <!-- Trending Categories Section End -->

                    <!-- Premium Listings Start -->
                    {$annonceView->premiumSection()}
                    <!-- Premium Listings End -->

                    <!-- Latest Announcements Section Start -->
                    {$annonceView->latestSection()}
                    <!-- Latest Announcements Section End -->
                    
                    <!-- Subscribe Section Start -->
                    {$userView->suscribeNewsletterSection()}
                    <!-- Subscribe Section End -->
                </aside>
                {$advertising->side()}
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
        $form = new Form("/announces/search", "form-error-search");

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
                            {$form->open()}
                                <input type="search" name="search_query" class="form-control" placeholder="Une recherche...">
                                <button class="btn btn-common btn-search" type="submit">Chercher</button>
                            </form>
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
                <div class="h3 text-secondary">{$e->getMessage()}</div>
                <div>Excéption jetée dans {$e->getFile()} à la ligne {$e->getLine()}.</div>
            </div>
        </div>
HTML;
    }

}