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

namespace App\views\Pages;

use App\Files\Image;
use App\views\View;
use App\views\Pages\Template;

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
    private $content;
    private $navbarState;
    private $footerState;

    /**
     * Permet de créer une page.
     * 
     * @param string $metaTitle   Le titre qui sera affiché dans la page.
     * @param string $content        Le contenu de la page qui sera affiché dans
     *                            la page.
     * @param string $description La description de la page.
     */
    public function __construct(string $metaTitle = null, string $content = null, string $description = null)
    {
        $this->metaTitle = $metaTitle;
        $this->description = $description;
        $this->content = $content;
        $this->navbarState = true;
        $this->footerState = true;
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
     * @param string $content
     * 
     * @return void
     */
    public function setView(string $content)
    {
        $this->content = $content;
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
            {$this->publicCss()}
        </head>
        <body>
            {$this->template()}
            {$this->publicJs()}
        </body>
        </html>
HTML;
    }

    /**
     * Page de connexion.
     * 
     * @return string
     */
    public function connexionPage()
    {
        echo <<<HTML
        {$this->debutDePage("fr")}
        <head>
            {$this->metaData()}
            {$this->adminCss()}  
        </head>
        <body id="adminSite">
            {$this->content}
            {$this->adminJs()}
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
                $navbar->publicNavbar(), $this->content, $footer->publicFooter()
            );
        } elseif ($this->navbarState == true && $this->footerState == false) {
            return $template->navbarAndContent($navbar->publicNavbar(), $this->content);
        } elseif ($this->navbarState == false && $this->footerState == true) {
            return $template->contentAndFooter($this->content, $footer->publicFooter());
        } else {
            return $this->content;
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
    private function metaData()
    {
        $base = APP_URL;

        return <<<HTML
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="{$this->description}">
        <base href="{$base}">
        <title>{$this->metaTitle}</title>
        {$this->appIcon()}
HTML;
    }
    
    /**
     * Retourne le code pour les icones.
     * 
     * @return string
     */
    private function appIcon()
    {
        $logosDir = Image::LOGOS_DIR_URL;

        return <<<HTML
        <link rel="icon" href="{$logosDir}/favicon.svg" type="image/x-icon">
        <link rel="shortcut icon" href="{$logosDir}/favicon.svg" type="image/x-icon">
HTML;
    }

    /**
     * Retourne les fichiers Css de la partie publique.
     * 
     * @return string
     */
    private function publicCss()
    {
        return <<<HTML
        {$this->generalAppCss()}
        {$this->callCssFile("app/css/slider.css")}
HTML;
    }

    /**
     * Retourne les fichiers Css de la partie administration.
     * 
     * @return string
     */
    private function adminCss()
    {
        return <<<HTML
        {$this->generalAppCss()}
        {$this->callCssFile("app/css/connexion.css")}
HTML;
    }

    /**
     * Javascript de la partie publique.
     * 
     * @return string
     */
    private function publicJs()
    {
        return <<<HTML
        {$this->generalAppJs()}
HTML;
    }

    /**
     * Retourne les fichiers Js de la partie administration.
     * 
     * @return string
     */
    private function adminJs()
    {
        return <<<HTML
        {$this->generalAppJs()}
        {$this->callJsFile("app/js/admin.js")}
HTML;
    }

    /**
     * Retourne les fichiers css selon le thème passé en paramètre.
     *  
     * @return string
     */
    private function generalAppCss()
    {
        return <<<HTML
        {$this->vendorCss()}
        {$this->callCssFile("app/css/main.css")}
        {$this->callCssFile("app/css/navbar.css")}
        {$this->callCssFile("app/css/sidebar.css")}
HTML;
    }

    /**
     * Retourne les fichiers JS appelés.
     * 
     * @return string
     */
    private function generalAppJs()
    {
        return <<<HTML
        {$this->vendorJs()}
        {$this->callJsFile("app/js/main.js")}
HTML;
    }

    /**
     * Retourne eles fichiers CSS utilisés sur toutes les pages.
     * 
     * @return string
     */
    private function vendorCss()
    {
        return <<<HTML
        <!-- Bootstrap -->
        <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
            crossorigin="anonymous"> -->
        {$this->callCssFile("vendor/bootstrap/css/bootstrap.min.css")}
        <!-- Fontawesome -->
        <!-- <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
            rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
            crossorigin="anonymous"> -->
        {$this->callCssFile("vendor/fontawesome/css/fontawesome.min.css")}
        <!-- icheck-bootstrap -->
        {$this->callCssFile("vendor/icheck-bootstrap/icheck-bootstrap.min.css")}
        <!-- Select2 -->
        {$this->callCssFile("vendor/select2/css/select2.min.css")}
        <!-- summernote -->
        {$this->callCssFile("vendor/summernote/summernote-bs4.min.css")}
        <!-- Google Font: Source Sans Pro -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
HTML;
    }

    /**
     * Retourne les fichiers JS appelés sur toutes les pages.
     * 
     * @return string
     */
    private function vendorJs()
    {
        return <<<HTML
        <!-- Jquery -->
        {$this->callJsFile("vendor/jquery/jquery.min.js")}
        <!-- Popper -->
        {$this->callJsFile("vendor/popper/popper.min.js")}
        <!-- Bootstrap -->
        {$this->callJsFile("vendor/bootstrap/js/bootstrap.bundle.min.js")}
        <!-- Fontawesome -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script> -->
        {$this->callJsFile("vendor/fontawesome/js/all.min.js")}
        <!-- Bootstrap Custom File Input -->
        {$this->callJsFile("vendor/bs-custom-file-input/bs-custom-file-input.min.js")}
        <!-- Select2 -->
        {$this->callJsFile("vendor/select2/js/select2.full.min.js")}
        <!-- Summernote -->
        {$this->callJsFile("vendor/summernote/summernote-bs4.min.js")}
        <!-- Summernote Langue -->
        {$this->callJsFile("vendor/summernote/lang/summernote-fr-FR.min.js")}
HTML;
    }

    /**
     * Retourne une balise link pour le fichiers css.
     * 
     * @param string $cssFileName Nom du fichier css.
     * 
     * @return string
     */
    private function callCssFile($cssFileName)
    {
        $assetsDir = ASSETS_DIR_URL;

        return <<<HTML
        <link rel="stylesheet" type="text/css" href="{$assetsDir}/{$cssFileName}">
HTML;
    }

    /**
     * Retourne une balise script pour appeler le fichier javascript passé
     * en paramètre.
     * 
     * @param string $jsFileName Nom du fichier javascript.
     * 
     * @return string
     */
    private function callJsFile($jsFileName)
    {
        $assetsDir = APP_URL . "/assets";

        return <<<HTML
        <script src="{$assetsDir}/{$jsFileName}"></script>
HTML;
    }

}
