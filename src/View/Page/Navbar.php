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
    public function publicNavbar()
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
                            <li class="nav-item dropdown active">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Accueil
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="categories">
                                Categories
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Listings
                                </a>
                                <div class="dropdown-menu">
                                <a class="dropdown-item" href="adlistinggrid.html">Ad Grid</a>
                                <a class="dropdown-item" href="adlistinglist.html">Ad Listing</a>
                                <a class="dropdown-item" href="ads-details.html">Listing Detail</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Pages 
                                </a>
                                <div class="dropdown-menu">
                                <a class="dropdown-item" href="about.html">About Us</a>
                                <a class="dropdown-item" href="services.html">Services</a>
                                <a class="dropdown-item" href="ads-details.html">Ads Details</a>
                                <a class="dropdown-item" href="post-ads.html">Ads Post</a>
                                <a class="dropdown-item" href="pricing.html">Packages</a>
                                <a class="dropdown-item" href="testimonial.html">Testimonial</a>
                                <a class="dropdown-item" href="faq.html">FAQ</a>
                                <a class="dropdown-item" href="404.html">404</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Blog 
                                </a>
                                <div class="dropdown-menu">
                                <a class="dropdown-item" href="blog.html">Blog - Right Sidebar</a>
                                <a class="dropdown-item" href="blog-left-sidebar.html">Blog - Left Sidebar</a>
                                <a class="dropdown-item" href="blog-grid-full-width.html"> Blog full width </a>
                                <a class="dropdown-item" href="single-post.html">Blog Details</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="contact.html">
                                Contact
                                </a>
                            </li>
                        </ul>
                        <ul class="sign-in">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="lni-user"></i> My Account</a>
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
                        <a class="tg-btn" href="post-ads.html">
                        <i class="lni-pencil-alt"></i> Poster une annonce
                        </a>
                    </div>
                </div>

                <!-- Mobile Menu Start -->
                <ul class="mobile-menu">
                    <li>
                        <a class="active" href="#">
                        Home
                        </a>
                        <ul class="dropdown">
                            <li><a class="active" href="index.html">Home 1</a></li>
                            <li><a href="index-2.html">Home 2</a></li>
                            <li><a href="index-3.html">Home 2</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="category.html">Categories</a>
                    </li>
                    <li>
                        <a href="#">
                        Listings
                        </a>
                            <ul class="dropdown">
                            <li><a href="adlistinggrid.html">Ad Grid</a></li>
                            <li><a href="adlistinglist.html">Ad Listing</a></li>
                            <li><a href="ads-details.html">Listing Detail</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Pages</a>
                        <ul class="dropdown">
                            <li><a href="about.html">About Us</a></li>
                            <li><a href="services.html">Services</a></li>
                            <li><a href="ads-details.html">Ads Details</a></li>
                            <li><a href="post-ads.html">Ads Post</a></li>
                            <li><a href="pricing.html">Packages</a></li>
                            <li><a href="testimonial.html">Testimonial</a></li>
                            <li><a href="faq.html">FAQ</a></li>
                            <li><a href="404.html">404</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Blog</a>
                        <ul class="dropdown">
                            <li><a href="blog.html">Blog - Right Sidebar</a></li>
                            <li><a href="blog-left-sidebar.html">Blog - Left Sidebar</a></li>
                            <li><a href="blog-grid-full-width.html"> Blog full width </a></li>
                            <li><a href="single-post.html">Blog Details</a></li>
                        </ul>
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
                <!-- Mobile Menu End -->

            </nav>
            <!-- Navbar End -->

            <!-- Hero Area Start -->
            <div id="hero-area">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xs-12 text-center">
                            <div class="contents">
                                <h1 class="head-title">Welcome to <span class="year">ClassiXER</span></h1>
                                <p>Buy And Sell Everything From Used Cars To Mobile Phones And Computers, <br> Or Search For Property, Jobs And More</p>
                                <div class="search-bar">
                                    <div class="search-inner">
                                        <form class="search-form">
                                            <div class="form-group inputwithicon">
                                                <i class="lni-tag"></i>
                                                <input type="text" name="customword" class="form-control" placeholder="Enter Product Keyword">
                                            </div>
                                            <div class="form-group inputwithicon">
                                                <i class="lni-map-marker"></i>
                                                <div class="select">
                                                    <select>
                                                        <option value="none">Locations</option>
                                                        <option value="none">New York</option>
                                                        <option value="none">California</option>
                                                        <option value="none">Washington</option>
                                                        <option value="none">Birmingham</option>
                                                        <option value="none">Chicago</option>
                                                        <option value="none">Phoenix</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group inputwithicon">
                                                <i class="lni-menu"></i>
                                                <div class="select">
                                                    <select>
                                                        <option value="none">Categories</option>
                                                        <option value="none">Jobs</option>
                                                        <option value="none">Electronics</option>
                                                        <option value="none">Mobile</option>
                                                        <option value="none">Training</option>
                                                        <option value="none">Pets</option>
                                                        <option value="none">Real Estate</option>
                                                        <option value="none">Services</option>
                                                        <option value="none">Training</option>
                                                        <option value="none">Vehicles</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <button class="btn btn-common" type="button"><i class="lni-search"></i> Search Now</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Hero Area End -->

        </header>
    <!-- Header Area wrapper End -->
HTML;
    }

    /**
     * Barre de navigation supérieure de la partie publique.
     * 
     * @return string
     */
    public function publicNavbar2()
    {
        return <<<HTML
        <nav class="navbar navbar-expand-md navbar-light">
            {$this->navbarBrand(Logo::LOGOS_DIR_URL."/1.png", APP_URL, APP_NAME)}
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="navbar-toggler-icon"></i>
            </button>
            <div class="collapse navbar-collapse d-md-flex justify-content-between" id="navbarNav">
                {$this->publicNavbarLinks()}
            </div>
        </nav>
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

    /**
     * Retourne les liens de la navbar publique.
     * 
     * @return string
     */
    private function publicNavbarLinks()
    {
        return <<<HTML
        <ul class="navbar-nav">
            {$this->navLink(APP_URL, "Accueil")}
        </ul>
HTML;
    }

    private function navLink(string $href, string $caption)
    {
        return <<<HTML
        <li class="nav-item">
            <a class="nav-link" href="{$href}">{$caption}</a>
        </li>
HTML;
    }

}