<?php

namespace App\View;

use App\Model\User\User;
use App\View\Model\AnnounceView;
use App\View\Model\CategoryView;
use App\View\Communication\NewsletterView;
use App\View\Model\User\RegisteredView;

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
        {$snippet->heroArea(true)}
        <div class="container-fluid">
            {$advertising->top()}
            <div class="row">
                <aside class="d-none d-lg-block col-lg-2">
                    {$advertising->left()}
                </aside>
                <aside class="col-12 col-lg-8">
                    {$categoryView->trendingCategoriesSection()}
                    {$annonceView->moreViewed()}
                    {$annonceView->latest()}
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
    public static function pageNotFound(string $message, string $current)
    {
        $snippet = new Snippet();
        $home = APP_URL;
        $searchView = new SearchView();
    
        return <<<HTML
        {$snippet->pageHeader("Oup's ! Page non trouvée", $current)}
        <div class="error">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="error-content">
                            <div class="error-message">
                                <h2>404</h2>
                                <h3>Oup's ! Nous n'avons trouvé la page que vous recherchez...</h3>
                                <p>{$message}</p>
                            </div>
                            {$searchView->notFoundSearch()}
                            <div class="description">
                                <span>Retour vers à l'<a href="$home">accueil</a></span>
                            </div>
                        </div>
                    </div>
                </div>      
            </div>
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
    public static function success(string $title, string $content, string $linkCaption = null, string $href = null, string $current = null)
    {
        $snippet = new Snippet;

        return <<<HTML
        {$snippet->pageHeader("Félicitation !", $current)}
        {$snippet->success($title, $content, $linkCaption, $href, $current)}
HTML;
    }

    /**
     * Affiche la page de succès.
     * 
     * @return string
     */
    public static function failed(string $title, string $content, string $linkCaption = null, string $href = null, string $current = null)
    {
        $snippet = new Snippet;

        return <<<HTML
        {$snippet->pageHeader("Oup's !", $current)}
        {$snippet->failed($title, $content, $linkCaption, $href, $current)}
HTML;
    }

    /**
     * Affiche la vue pour l'administration avec une sidebar. Cette vue est disposée
     * de façon responsive avec les class bootstrap.
     * 
     * @param string $content Le contenu de la page d'administration. Le contenu doit 
     *                        contenir des class de disposition (col) afin d'être
     *                        bien disposée en fonction des écrans.
     * @param string $title   Le titre qui va s'afficher dans le bannière du haut.
     * @param string $current Le texte qui sera affiché dans le
     * @return string
     */
    public static function administrationTemplate(string $content, string $title, string $current, string $message = null)
    {
        $snippet = new Snippet;
        $registeredView = new RegisteredView();

        return <<<HTML
        {$snippet->pageHeader($title, $current)}
        {$message}
        <div id="content" class="my-3">
            <div class="container-fluid">
                <div class="row">
                    {$registeredView->sidebarNav(User::authenticated())}
                    <div class="col-sm-12 col-md-9">
                        {$content}
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Template avec la barre heraoArea 2 seulement. Hero area est une bannière avec un formulaire
     * de recherche.
     * @param string $content Le contenu de la page.
     * @return string
     */
    public static function heroArea2Template(string $content)
    {
        $snippet = new Snippet();

        return <<<HTML
        {$snippet->heroArea2()}
        <div class="container">
            <aside class="col-12">
                {$content}
            </aside>
        </div>
HTML;
    }

    /**
     * Template avec la barre heraoArea avec la barre de recherche et les publicités sur les cotés et haut.
     * Hero area est une bannière avec un formulaire de recherche.
     * @param string $content Le contenu de la page.
     * @return string
     */
    public static function heroArea2WithAdvertisingTemplate(string $content)
    {
        $snippet = new Snippet();
        $advertising = new AdvertisingView();

        return <<<HTML
        {$snippet->heroArea2()}
        <div class="container-fluid mb-3">
            {$advertising->top()}
            <div class="row">
                <aside class="d-none d-lg-block col-lg-2">
                    {$advertising->left()}
                </aside>
                <aside class="col-12 col-lg-8">
                    {$content}
                </aside>
                <aside class="d-none d-lg-block col-lg-2">
                    {$advertising->right()}
                </aside>
            </div>
        </div>
HTML;
    }

    /**
     * Template avec la barre heraoArea 1 les publicités sur les cotés et haut.
     * Hero area est une bannière avec un formulaire de recherche.
     * @param string $content Le contenu de la page.
     * @return string
     */
    public static function heroArea2WithTopAdvertising(string $content)
    {
        $snippet = new Snippet();
        $advertising = new AdvertisingView();

        return <<<HTML
        {$snippet->heroArea2()}
        <div class="container">
            {$advertising->top()}
            <aside>
                {$content}
            </aside>
        </div>
HTML;
    }

    /**
     * Template avec la page header et les publicités.
     * 
     * @param string $title   Le titre qui va s'afficher dans le page header.
     * @param string $current Le texte à afficher pour indiquer à quel niveau nous sommes.
     * @param string $content Le contenu de la page
     * 
     * @return string
     */
    public static function pageHeaderWithAdvertisingTemplate(string $title, string $current, string $content)
    {
        $snippet = new Snippet;
        $advertising = new AdvertisingView;

        return <<<HTML
        {$snippet->pageHeader($title, $current)}
        <div class="main-container py-3">
            <div class="container-fluid">
                {$advertising->top()}
                <div class="row">
                    <aside class="d-none d-lg-block col-lg-2">
                        {$advertising->left()}
                    </aside>
                    <aside class="col-12 col-lg-8">
                        {$content}
                    </aside>
                    <aside class="d-none d-lg-block col-lg-2">
                        {$advertising->right()}
                    </aside>
                </div>
            </div>
        </div> 
HTML;
    }

    /**
     * Template avec la page header uniquement.
     * 
     * @param string $title   Le titre qui va s'afficher dans le page header.
     * @param string $current Le texte à afficher pour indiquer à quel niveau nous sommes.
     * @param string $content Le contenu de la page.
     * 
     * @return string
     */
    public static function pageHeaderTemplate(string $title, string $current, string $content)
    {
        $snippet = new Snippet;

        return <<<HTML
        {$snippet->pageHeader($title, $current)}
        <div class="main-container py-3">
            <div class="container">
                <aside>
                    {$content}
                </aside>
            </div>
        </div> 
HTML;
    }

    /**
     * La vue qui affiche le about.
     * 
     * @return string
     */
    public static function aboutUs()
    {
        $content = <<<HTML
        <section id="about" class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-xs-12">
                        <div class="about-wrapper">
                            <h2 class="intro-title">Lorem Ipsum Dolor Sit Amet, Consectetur Adipisicing Elit Sed Do</h2>
                            <p class="intro-desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum, doloremque quaerat sit tempora eius est reiciendis accusamus magnam quae. Explicabo dolore officia, iure a ullam aliquam nemo excepturi, repellat. uod ut delectus ad tempora.
                            </p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi laboriosam sit nam animi, distinctio maiores possimus! Suscipit officiis reiciendis vitae omnis eligendi? Tempora at ullam repudiandae, magnam nemo fuga omnis.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xs-12">
                        <img class="img-fluid" src="assets/img/about/about.png" alt="Une image du fondateur de L'indice.ci">
                    </div>
                </div>
            </div>
        </section>
HTML;
        return self::pageHeaderTemplate("A propos de nous", "A propos de nous", $content);
    }

    /**
     * La vue qui affiche le FAQ.
     * 
     * @return string
     */
    public static function FAQ()
    {
        $faqs = null;
        $tag = 0;

        foreach(self::faqs() as $title => $value) {
            $tag = $tag + 1;
            $faqs .= (new Snippet)->accordeon(ucfirst($title), ucfirst($value), $tag);
        }

        $content = <<<HTML
        <div class="faq section-padding">
            <div class="container">        
                <div class="row">
                    <div class="col-md-12">
                        <div class="head-faq text-center">
                            <h2 class="section-title">QUESTIONS FREQUENTES</h2>
                        </div>
                        <p class="mb-3">Vous vous posez des questions, trouvez la reponse ici.</p>
                        <div class="panel-group" id="accordion">
                            {$faqs}
                        </div>  
                    </div>      
                </div>
            </div>      
        </div>
HTML;
        return self::pageHeaderTemplate("QUESTIONS FREQUENTES", "Questions fréquentes", $content);
    }

    /**
     * Les questions de la Faqs.
     * @return array
     */
    private static function faqs()
    {
        return [
            "Title" => "value"
            , "Title_2" => "value"
        ];
    }

}