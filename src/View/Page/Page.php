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
                $navbar->publicNavbar(), $this->view, $footer->publicFooter()
            );
        } elseif ($this->navbarState == true && $this->footerState == false) {
            return $template->navbarAndContent($navbar->publicNavbar(), $this->view);
        } elseif ($this->navbarState == false && $this->footerState == true) {
            return $template->contentAndFooter($this->view, $footer->publicFooter());
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
        {$this->appIcon()}
HTML;
    }
    
    /**
     * Retourne le code pour les icones.
     * 
     * @return string
     */
    private function appIcon(string $logosDir = Logo::LOGOS_DIR_URL)
    {
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
        <!-- Bootstrap CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!-- Icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css" integrity="sha512-QKC1UZ/ZHNgFzVKSAhV5v5j73eeL9EEN289eKAEFaAjgAiobVAnVv/AGuPbXsKl1dNoel3kNr6PYnSiTzVVBCw==" crossorigin="anonymous" />
        <!-- Slicknav -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/SlickNav/1.0.10/slicknav.min.css" integrity="sha512-heyoieAHmpAL3BdaQMsbIOhVvGb4+pl4aGCZqWzX/f1BChRArrBy/XUZDHW9WVi5p6pf92pX4yjkfmdaIYa2QQ==" crossorigin="anonymous" />
        <!-- Nivo Lightbox -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nivo-lightbox/1.3.1/nivo-lightbox.min.css" integrity="sha512-1+H7MGc+v6ZUF1LzWl8mGsU2vaFj6ZCKCaiO0K0zD71cqcFaWlXswBVv3P3eu27s1xpANVx08Cgg0tqxhd9rYA==" crossorigin="anonymous" />
        <!-- Animate -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==" crossorigin="anonymous" />
        <!-- Owl carousel -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css" integrity="sha512-X/RSQYxFb/tvuz6aNRTfKXDnQzmnzoawgEQ4X8nZNftzs8KFFH23p/BA6D2k0QCM4R0sY1DEy9MIY9b3fwi+bg==" crossorigin="anonymous" />
        <!-- Summernote -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <!-- {$this->cssFile(ASSETS_DIR_URL."/css/bootstrap.min.css")} -->
        <!-- Icon -->
        <!-- {$this->cssFile(ASSETS_DIR_URL."/css/font/line-icons.css")} -->
        <!-- Slicknav -->
        <!-- {$this->cssFile(ASSETS_DIR_URL."/css/slicknav.css")} -->
        <!-- Nivo Lightbox -->
        <!-- {$this->cssFile(ASSETS_DIR_URL."/css/nivo-lightbox.css")} -->
        <!-- Animate -->
        <!-- {$this->cssFile(ASSETS_DIR_URL."/css/animate.css")} -->
        <!-- Owl carousel -->
        <!-- {$this->cssFile(ASSETS_DIR_URL."/css/owl.carousel.css")} -->
        <!-- Owl Theme -->
        <!-- {$this->cssFile(ASSETS_DIR_URL."/css/owl.theme.css")} -->
        <!-- Responsive Style -->
        <!-- {$this->cssFile(ASSETS_DIR_URL."/css/responsive.css")} -->
        <!-- Summernote -->
        <!-- {$this->cssFile(ASSETS_DIR_URL."/css/summernote.css")} -->
        <!-- Main Style -->
        {$this->cssFile(ASSETS_DIR_URL."/css/main.css")}
        <!-- Color Switcher -->
        {$this->cssFile(ASSETS_DIR_URL."/css/color-switcher.css")}
        <!-- Settings -->
        {$this->cssFile(ASSETS_DIR_URL."/css/settings.css")}
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
        <!-- Popper -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js" integrity="sha512-BmM0/BQlqh02wuK5Gz9yrbe7VyIVwOzD1o40yi1IsTjriX/NGF37NyXHfmFzIlMmoSIBXgqDiG1VNU6kB5dBbA==" crossorigin="anonymous"></script>
        <!-- Bootstrap -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.min.js" integrity="sha512-8qmis31OQi6hIRgvkht0s6mCOittjMa9GMqtK9hes5iEQBQE/Ca6yGE5FsW36vyipGoWQswBj/QBm2JR086Rkw==" crossorigin="anonymous"></script>
        <!-- Summernote -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js" integrity="sha512-+cXPhsJzyjNGFm5zE+KPEX4Vr/1AbqCUuzAS8Cy5AfLEWm9+UI9OySleqLiSQOQ5Oa2UrzaeAOijhvV/M4apyQ==" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/lang/summernote-fr-FR.min.js" integrity="sha512-M/dO2WzUHujRv2L5krC41AAmXJm1edIN1B2rd6KFNH/Xpu8NK4X+Rj9aDMVeNevG7ibdnbzPH7QhUwig6Eo7ew==" crossorigin="anonymous"></script>
        <!-- CounterUp -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js" integrity="sha512-d8F1J2kyiRowBB/8/pAWsqUl0wSEOkG5KATkVV4slfblq9VRQ6MyDZVxWl2tWd+mPhuCbpTB4M7uU/x9FlgQ9Q==" crossorigin="anonymous"></script>
        <!-- Waypoints -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/noframework.waypoints.min.js" integrity="sha512-fHXRw0CXruAoINU11+hgqYvY/PcsOWzmj0QmcSOtjlJcqITbPyypc8cYpidjPurWpCnlB8VKfRwx6PIpASCUkQ==" crossorigin="anonymous"></script>
        <!-- WOW -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js" integrity="sha512-Eak/29OTpb36LLo2r47IpVzPBLXnAMPAVypbSZiZ4Qkf8p/7S/XRG5xp7OKWPPYfJT6metI+IORkR5G8F900+g==" crossorigin="anonymous"></script>
        <!-- Carousel -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js" integrity="sha512-9CWGXFSJ+/X0LWzSRCZFsOPhSfm6jbnL+Mpqo0o8Ke2SYr8rCTqb4/wGm+9n13HtDE1NQpAEOrMecDZw4FXQGg==" crossorigin="anonymous"></script>
        <!-- Nivo Lightbox -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/nivo-lightbox/1.3.1/nivo-lightbox.min.js" integrity="sha512-fTsZSmOARwC81gLD0Cftat+G/ouB/dYN8q0DvJPdQdPK1Ec7ET4zmlwWGDO50vPKhu8wnEwaEpXYXkETtbsNBg==" crossorigin="anonymous"></script>
        <!-- Slicknav -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/SlickNav/1.0.10/jquery.slicknav.min.js" integrity="sha512-FmCXNJaXWw1fc3G8zO3WdwR2N23YTWDFDTM3uretxVIbZ7lvnjHkciW4zy6JGvnrgjkcNEk8UNtdGTLs2GExAw==" crossorigin="anonymous"></script>
        
        <!-- Jquery -->
        <!-- {$this->jsFile(ASSETS_DIR_URL."/js/jquery-min.js")} -->
        <!-- Popper -->
        <!-- {$this->jsFile(ASSETS_DIR_URL."/js/popper.min.js")} -->
        <!-- Bootstrap -->
        <!-- {$this->jsFile(ASSETS_DIR_URL."/js/bootstrap.min.js")} -->
        <!-- Summernote -->
        <!-- {$this->jsFile(ASSETS_DIR_URL."/summernote.js")} -->
        <!-- {$this->jsFile(ASSETS_DIR_URL . "/js/summernote-fr-FR.min.js")} -->
        <!-- CounterUp -->
        <!-- {$this->jsFile(ASSETS_DIR_URL."/js/jquery.counterup.min.js")} -->
        <!-- Waypoints -->
        <!-- {$this->jsFile(ASSETS_DIR_URL."/js/waypoints.min.js")} -->
        <!-- WOW -->
        <!-- {$this->jsFile(ASSETS_DIR_URL."/js/wow.js")} -->
        <!-- Carousel -->
        <!-- {$this->jsFile(ASSETS_DIR_URL."/js/owl.carousel.min.js")} -->
        <!-- Nivo Lightbox -->
        <!-- {$this->jsFile(ASSETS_DIR_URL."/js/nivo-lightbox.js")} -->
        <!-- Slicknav -->
        <!-- {$this->jsFile(ASSETS_DIR_URL."/js/jquery.slicknav.js")} -->

        <!-- Main Js -->
        {$this->jsFile(ASSETS_DIR_URL."/js/main.js")}
        <!-- Form Validator -->
        {$this->jsFile(ASSETS_DIR_URL."/js/form-validator.min.js")}
        <!-- Contact Form script -->
        {$this->jsFile(ASSETS_DIR_URL."/js/contact-form-script.min.js")}
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
