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
        $this->brandImgSrc = Logo::LOGOS_DIR_URL ."/logo1.png";
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
                        <a href="{$appUrl}" class="navbar-brand"><img src="{$this->brandImgSrc}" alt="{$logoAltText}"></a>
                    </div>
                    <div class="collapse navbar-collapse" id="main-navbar">
                        <ul class="navbar-nav mr-auto">
                        </ul>
                        <ul class="sign-in">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="lni-user"></i> Mon compte</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="account-profile-setting.html"><i class="lni-home"></i> Account Home</a>
                                    <a class="dropdown-item" href="account-myads.html"><i class="lni-wallet"></i> My Ads</a>
                                    <a class="dropdown-item" href="account-favourite-ads.html"><i class="lni-heart"></i> Favourite ads</a>
                                    <a class="dropdown-item" href="account-archived-ads.html"><i class="lni-folder"></i> Archived</a>
                                    <a class="dropdown-item" href="login.html"><i class="lni-lock"></i> Log In</a>
                                    <a class="dropdown-item" href="signup.html"><i class="lni-user"></i> Signup</a>
                                    <a class="dropdown-item" href="forgot-password.html"><i class="lni-reload"></i> Forgot Password</a>
                                    <a class="dropdown-item" href="account-close.html"><i class="lni-close"></i>Account close</a>
                                </div>
                            </li>
                        </ul>
                        <a class="tg-btn" href="creer-une-annonce">
                        <i class="lni-pencil-alt"></i> Poster une annonce
                        </a>
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
    public function mobileMenu()
    {
        return <<<HTML
        <ul class="mobile-menu">
            <li>
                <a class="active" href="#">
                Accueil
                </a>
            </li>
            <li>
                <a href="contact.html">Contact Us</a>
            </li>
            <li>
                <a>My Account</a>
                <ul class="dropdown">
                    <li><a href="account-profile-setting.html"><i class="lni-home"></i> Account Home</a></li>
                    <li><a href="account-myads.html"><i class="lni-wallet"></i> My Ads</a></li>
                    <li><a href="account-favourite-ads.html"><i class="lni-heart"></i> Favourite ads</a></li>
                    <li><a href="account-archived-ads.html"><i class="lni-folder"></i> Archived</a></li>
                    <li><a href="login.html"><i class="lni-lock"></i> Log In</a></li>
                    <li><a href="signup.html"><i class="lni-user"></i> Signup</a></li>
                    <li><a href="forgot-password.html"><i class="lni-reload"></i> Forgot Password</a></li>
                    <li><a href="account-close.html"><i class="lni-close"></i>Account close</a></li>
                </ul>
            </li>
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