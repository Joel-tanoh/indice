<?php

/**
 * Description
 * 
 * PHP version 7.1.9
 * 
 * @category Category
 * @package  Package
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com license_name
 * @version  GIT: Joel_tanoh
 * @link     Link
 */

namespace App\View\Page;

use App\File\Image\Logo;
use App\View\View;
use App\View\Page\Template;

/**
 * Classe qui gère tout ce qui est en rapport à une page.
 *  
 * @category Category
 * @package  App
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com license_name
 * @version  Release: 1
 * @link     Link
 */
class Page extends View
{
    private $metaTitle;
    private $description;
    private $view;
    private $navbarState;
    private $footerState;
    private $cssFiles = [];
    private $jsFiles = [];

    /**
     * Permet de créer une page.
     * 
     * @param string $metaTitle   Le titre qui sera affiché dans la page.
     * @param string $view        Le contenu de la page qui sera affiché dans
     *                            la page.
     * @param string $description La description de la page.
     */
    public function __construct(string $metaTitle = null, string $view = null, string $description = null, array $cssFiles = null, array $jsFiles = null)
    {
        $this->metaTitle = $metaTitle;
        $this->description = $description;
        $this->view = $view;
        $this->navbarState = true;
        $this->footerState = true;
        $this->cssFiles = $cssFiles;
        $this->jsFiles = $jsFiles;
    }

    /**
     * Permet de modifier le metaTitle de la page.
     * 
     * @param string $metaTitle
     * 
     * @return void
     */
    public function setMetaTitle(string $metaTitle)
    {
        $this->metaTitle = $metaTitle;
    }

    /**
     * Permet de modifier la meta description de la page.
     * 
     * @param string $description
     * 
     * @return void
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Permet de modifier le contenu de la page.
     * 
     * @param string $view
     * 
     * @return void
     */
    public function setView(string $view)
    {
        $this->view = $view;
    }

    /**
     * Permet de spécifier si l'on veut voir la navbar sur la page.
     * 
     * @param bool $navbarState True si on veut que la navbar apparaisse sur la page,
     *                          False sinon.
     */
    public function showNavbar(bool $navbarState)
    {
        $this->navbarState = $navbarState;
    }

    /**
     * Permet de spécifier si l'on veut voir le footer sur la page.
     * 
     * @param bool $navbarState true si on veut que le footer apparaisse sur la page,
     *                          false sinon.
     */
    public function showFooter(bool $footerState)
    {
        $this->footerState = $footerState;
    }

    /**
     * Permet d'ajouter un fichier css à cette page.
     * 
     * @param string $cssFileUrl L'url du fichier Css.
     */
    public function setCssFiles(string $cssFileUrl)
    {
        $this->cssFiles[] = $cssFileUrl;
    }

    /**
     * Permet d'ajouter un fichier js à cette page.
     * 
     * @param string $jsFileUrl L'url du fichier Js.
     */
    public function setJsFiles(string $jsFileUrl)
    {
        $this->jsFiles[] = $jsFileUrl;
    }

    /**
     * Affiche le code pour l'index de la partie publique
     * 
     * @return string
     **/
    public function show()
    {
        echo <<<HTML
        {$this->debutDePage("fr")}
        <head>
            {$this->metaData()}
            {$this->appCss()}
        </head>
        <body>
            {$this->template()}
            {$this->appJs()}
        </body>
        </html>
HTML;
    }

    /**
     * Template
     * 
     * @return string
     */
    private function template()
    {
        $navbar = new Navbar();
        $footer = new Footer();
        $template = new Template();

        if ($this->navbarState == true && $this->footerState == true) {
            return $template->navbarAndContentAndFooter(
                $navbar->get(), $this->view, $footer->get()
            );
        } elseif ($this->navbarState == true && $this->footerState == false) {
            return $template->navbarAndContent($navbar->get(), $this->view);
        } elseif ($this->navbarState == false && $this->footerState == true) {
            return $template->contentAndFooter($this->view, $footer->get());
        } else {
            return $this->view;
        }
    }

    /**
     * Code du début de la page.
     * 
     * @param string $htmlLanguage
     * 
     * @return string
     */
    private function debutDePage($htmlLanguage = "fr")
    {
        return <<<HTML
        <!DOCTYPE html>
        <html lang="{$htmlLanguage}">
HTML;
    }

    /**
     * Retourne les balises meta
     * 
     * @return string
     */
    private function metaData(string $base = APP_URL)
    {
        return <<<HTML
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="{$this->description}">
        <base href="{$base}">
        <title>{$this->metaTitle}</title>
        {$this->favicon()}
HTML;
    }
    
    /**
     * Retourne le code pour les icones.
     * 
     * @return string
     */
    private function favicon(string $logosDir = Logo::LOGOS_DIR_URL)
    {
        return <<<HTML
        <link rel="icon" href="{$logosDir}/faviconx2.png" type="image/png">
        <link rel="shortcut icon" href="{$logosDir}/faviconx2.png" type="image/png">
HTML;
    }

    /**
     * Retourne les fichiers css selon le thème passé en paramètre.
     *  
     * @return string
     */
    private function appCss()
    {
        $otherCssFiles = null;

        if (!empty($this->cssFiles)) {
            foreach($this->cssFiles as $cssFileUrl) {
                $otherCssFiles .= $this->cssFile($cssFileUrl);
            }
        }

        return <<<HTML
        {$this->cssFiles()}
        {$otherCssFiles}
HTML;
    }

    /**
     * Retourne les fichiers JS appelés.
     * 
     * @return string
     */
    private function appJs()
    {
        $otherJsFiles = null;

        if (!empty($this->jsFiles)) {
            foreach($this->jsFiles as $jsFileUrl) {
                $otherJsFiles .= $this->jsFile($jsFileUrl);
            }
        }

        return <<<HTML
        {$this->jsFiles()}
        {$otherJsFiles}
HTML;
    }

    /**
     * Retourne eles fichiers CSS utilisés sur toutes les pages.
     * 
     * @return string
     */
    private function cssFiles()
    {
        return <<<HTML
        <!-- Bootstrap CSS -->
        {$this->cssFile(ASSETS_DIR_URL."/css/bootstrap.min.css")}
        <!-- Slicknav -->
        {$this->cssFile(ASSETS_DIR_URL."/css/slicknav.css")}
        <!-- Nivo Lightbox -->
        {$this->cssFile(ASSETS_DIR_URL."/css/nivo-lightbox.css")}
        <!-- Animate -->
        {$this->cssFile(ASSETS_DIR_URL."/css/animate.css")}
        <!-- Owl carousel -->
        {$this->cssFile(ASSETS_DIR_URL."/css/owl.carousel.css")}
        <!-- Summernote -->
        {$this->cssFile(ASSETS_DIR_URL."/css/summernote.css")}
        <!-- Main Style -->
        {$this->cssFile(ASSETS_DIR_URL."/css/main.css")}
        <!-- Color Switcher -->
        {$this->cssFile(ASSETS_DIR_URL."/css/color-switcher.css")}
        <!-- Settings -->
        {$this->cssFile(ASSETS_DIR_URL."/css/settings.css")}
        <!-- Icon -->
        {$this->cssFile(ASSETS_DIR_URL."/fonts/line-icons.css")}
        <!-- Responsive Style -->
        {$this->cssFile(ASSETS_DIR_URL."/css/responsive.css")}
        <!-- Owl Theme -->
        {$this->cssFile(ASSETS_DIR_URL."/css/owl.theme.css")}
        <!-- Fontawesome -->
        {$this->cssFile(ASSETS_DIR_URL."/fontawesome/css/all.css")}
HTML;
    }

    /**
     * Retourne les fichiers JS appelés sur toutes les pages.
     * 
     * @return string
     */
    private function jsFiles()
    {
        return <<<HTML
        <!-- Jquery -->
        {$this->jsFile(ASSETS_DIR_URL."/js/jquery-min.js")}
        <!-- Popper -->
        {$this->jsFile(ASSETS_DIR_URL."/js/popper.min.js")}
        <!-- Bootstrap -->
        {$this->jsFile(ASSETS_DIR_URL."/js/bootstrap.min.js")}
        <!-- Summernote -->
        {$this->jsFile(ASSETS_DIR_URL."/js/summernote.js")}
        {$this->jsFile(ASSETS_DIR_URL . "/js/summernote-fr-FR.min.js")}
        <!-- CounterUp -->
        {$this->jsFile(ASSETS_DIR_URL."/js/jquery.counterup.min.js")}
        <!-- Waypoints -->
        {$this->jsFile(ASSETS_DIR_URL."/js/waypoints.min.js")}
        <!-- WOW -->
        {$this->jsFile(ASSETS_DIR_URL."/js/wow.js")}
        <!-- Carousel -->
        {$this->jsFile(ASSETS_DIR_URL."/js/owl.carousel.min.js")}
        <!-- Nivo Lightbox -->
        {$this->jsFile(ASSETS_DIR_URL."/js/nivo-lightbox.js")}
        {$this->jsFile(ASSETS_DIR_URL."/js/jquery.slicknav.js")}
        <!-- Main Js -->
        {$this->jsFile(ASSETS_DIR_URL."/js/main.js")}
        <!-- Form Validator -->
        {$this->jsFile(ASSETS_DIR_URL."/js/form-validator.min.js")}
        <!-- Contact Form script -->
        {$this->jsFile(ASSETS_DIR_URL."/js/contact-form-script.min.js")}
        <!-- Fontawesome -->
        {$this->jsFile(ASSETS_DIR_URL."/fontawesome/js/all.js")}
HTML;
    }

    /**
     * Retourne une balise link pour le fichiers css.
     * 
     * @param string $cssFileUrl Url du fichier css.
     * 
     * @return string
     */
    private function cssFile($cssFileUrl)
    {
        return <<<HTML
        <link rel="stylesheet" type="text/css" href="{$cssFileUrl}">
HTML;
    }

    /**
     * Retourne une balise script pour appeler le fichier javascript passé
     * en paramètre.
     * 
     * @param string $jsFileUrl Url du fichier javascript.
     * 
     * @return string
     */
    private function jsFile($jsFileUrl)
    {
        return <<<HTML
        <script src="{$jsFileUrl}"></script>
HTML;
    }

}
