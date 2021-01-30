<?php

/**
 * Description
 * 
 * PHP version 7.1.9
 * 
 * @category Category
 * @package  Package
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com License
 * @link     Link
 */

namespace App\View\Page;

use App\File\Image\Logo;
use App\View\Model\CategoryView;
use App\View\Model\User\UserView;
use App\View\Snippet;

/**
 * Perlet de gérer tout ce qui concerne la barre de navigation supérieure.
 * 
 * @category Category
 * @package  App\
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com License
 * @link     Link
 */
class Navbar extends Snippet
{
    private $brandImgSrc;
    private $userAvatarSrc;

    public function __construct(string $brandImgSrc = null, string $userAvatarSrc = null)
    {
        $this->brandImgSrc = Logo::LOGOS_DIR_URL ."/logo-white.png";
        $this->userAvatarSrc = $userAvatarSrc;
    }

    /**
     * Barre de navigation supérieure de la partie publique.
     * 
     * @return string
     */
    public function get()
    {
        $appUrl = APP_URL;
        $logoAltText = Logo::ALT_TEXT;
        $userView = new UserView();
        $categoryView = new CategoryView();

        return <<<HTML
        <!-- Header Area wrapper Starts -->
        <header id="header-wrap">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand-lg fixed-top scrolling-navbar">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar" aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                            <span class="lni-menu"></span>
                            <span class="lni-menu"></span>
                            <span class="lni-menu"></span>
                        </button>
                        <a href="{$appUrl}" class="navbar-brand"><img id="logo" src="{$this->brandImgSrc}" alt="{$logoAltText}"></a>
                    </div>
                    <div class="collapse navbar-collapse" id="main-navbar">
                        <!-- Partie pour afficher les liens dans la Navabr -->
                        <ul class="navbar-nav mr-auto">
                            {$categoryView->navbarList()}
                            <li>
                                <a class="nav-link" href="announces">Annonces</a>
                            </li>
                        </ul>
                        {$userView->navbarMenu()}
                        <a class="tg-btn" href="post"><i class="lni-pencil-alt"></i> Poster une annonce</a>
                    </div>
                </div>

                <!-- Mobile Menu Start -->
                {$this->mobileMenu()}
                <!-- Mobile Menu End -->

            </nav>
            <!-- Navbar End -->

        </header>
    <!-- Header Area wrapper End -->
HTML;
    }

    /**
     * Le menu affiché sur les écrans des mobiles.
     * 
     * @return string
     */
    private function mobileMenu()
    {
        $userView = new UserView();

        return <<<HTML
        <ul class="mobile-menu">
            {$userView->mobileNavbar()}
        </ul>
HTML;
    }

    /**
     * Permet d'afficher le logo dans la navbar.
     * 
     * @param string $brandSrc Le lien vers l'image.
     * @param string $href     L'url exécuté lors du click sur le logo.
     * @param string $caption  Le texte à afficher si l'image introuvable.
     * 
     * @return string
     */
    private function navbarBrand(string $brandSrc, string $href = null, string $caption = null)
    {
        return <<<HTML
        <a class="navbar-brand" href="{$href}">
            <img src="{$brandSrc}" alt="{$caption}" class="brand" style="width:15rem">
        </a>
HTML;
    }

    /**
     * Retourne l'image miniature de l'utilisateur connecté dans la navbar.
     * 
     * @param string $avatarSrc
     * @param string $caption
     * 
     * @return string
     */
    private function navbarUserAvatar(string $avatarSrc, string $caption = null)
    {
        return <<<HTML
        <div>
            <img src="{$avatarSrc}" alt="{$caption}" class="navbar-user-avatar img-circle shdw mr-2"/>
        </div>
HTML;
    }

}