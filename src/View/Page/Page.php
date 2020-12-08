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

use App\File\Image;
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
    private $content;
    private $navbarState;
    private $footerState;
    private $cssFiles = [];
    private $jsFiles = [];

    /**
     * Permet de créer une page.
     * 
     * @param string $metaTitle   Le titre qui sera affiché dans la page.
     * @param string $content        Le contenu de la page qui sera affiché dans
     *                            la page.
     * @param string $description La description de la page.
     */
    public function __construct(string $metaTitle = null, string $content = null, string $description = null, array $cssFiles = null, array $jsFiles = null)
    {
        $this->metaTitle = $metaTitle;
        $this->description = $description;
        $this->content = $content;
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
        $logosDir = LOGOS_DIR_URL;

        return <<<HTML
        <link rel="icon" href="{$logosDir}/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="{$logosDir}/favicon.ico" type="image/x-icon">
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
        {$this->vendorCss()}
        {$this->cssFile(ASSETS_DIR_URL . "/app/css/main.css")}
        {$this->cssFile(ASSETS_DIR_URL . "/app/css/navbar.css")}
        {$this->cssFile(ASSETS_DIR_URL . "/app/css/sidebar.css")}
        {$this->cssFile(ASSETS_DIR_URL . "/app/css/slider.css")}
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
        {$this->vendorJs()}
        {$this->jsFile(ASSETS_DIR_URL . "/app/js/main.js")}
        {$otherJsFiles}
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
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!-- {$this->cssFile(ASSETS_DIR_URL . "/vendor/bootstrap/css/bootstrap.min.css")} -->

        <!-- Fontawesome -->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <!-- {$this->cssFile(ASSETS_DIR_URL . "/vendor/fontawesome/css/fontawesome.min.css")} -->

        <!-- icheck-bootstrap -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
        <!-- {$this->cssFile(ASSETS_DIR_URL . "/vendor/icheck-bootstrap/icheck-bootstrap.min.css")} -->

        <!-- Select2 -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
        <!-- {$this->cssFile(ASSETS_DIR_URL . "/vendor/select2/css/select2.min.css")} -->

        <!-- summernote -->
        <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css"> -->
        {$this->cssFile(ASSETS_DIR_URL . "/vendor/summernote/summernote-bs4.min.css")}

        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
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
        <!-- {$this->jsFile(ASSETS_DIR_URL . "/vendor/jquery/jquery.min.js")} -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Popper -->
        <!-- {$this->jsFile(ASSETS_DIR_URL . "/vendor/popper/popper.min.js")} -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.4/umd/popper.min.js"></script>

        <!-- Bootstrap -->
        <!-- {$this->jsFile(ASSETS_DIR_URL . "/vendor/bootstrap/js/bootstrap.bundle.min.js")} -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

        <!-- Fontawesome -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
        <!-- {$this->jsFile(ASSETS_DIR_URL . "/vendor/fontawesome/js/all.min.js")} -->

        <!-- Bootstrap Custom File Input -->
        <!-- {$this->jsFile(ASSETS_DIR_URL . "/vendor/bs-custom-file-input/bs-custom-file-input.min.js")} -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bs-custom-file-input/1.3.4/bs-custom-file-input.min.js"></script>

        <!-- Select2 -->
        <!-- {$this->jsFile(ASSETS_DIR_URL . "/vendor/select2/js/select2.full.min.js")} -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>

        <!-- Summernote -->
        <!-- {$this->jsFile(ASSETS_DIR_URL . "/vendor/summernote/summernote-bs4.min.js")} -->
        <!-- {$this->jsFile(ASSETS_DIR_URL . "/vendor/summernote/lang/summernote-fr-FR.min.js")} -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/lang/summernote-fr-FR.min.js"></script>       
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
