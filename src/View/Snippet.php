<?php

/**
 * Fichier de classe.
 * 
 * @author Joel <Joel.developpeur@gmail.com>
 */

namespace App\View;

use App\File\Image\Image;
use App\Router\Router;
use App\Model\Entity;
use App\Model\User\Visitor;

/**
 * Gère les fragments de code.
 * 
 * @author Joel <Joel.developpeur@gmail.com>
 */
class Snippet extends View
{
    /**
     * Affiche l'avatar d'un utilisateur.
     * 
     * @param string $avatarImgSrc
     * @param string $altText
     * 
     * @return string
     */
    public function showAvatar(string $avatarImgSrc, string $altText = null)
    {
        return <<<HTML
        <div>
            <img src="{$avatarImgSrc}" alt="{$altText}" class="user-avatar img-fluid"/>
        </div>
HTML;
    }

    /**
     * Hero Area
     * 
     * @param bool $showWelcomeText
     * 
     * @return string
     */
    public function heroArea(bool $showWelcomeText = true)
    {
        $welcomeText = null;
        if ($showWelcomeText) {
            $welcomeText = <<<HTML
            <h1 class="head-title">Bienvenue sur <span class="year">Indice</span></h1>
            <p>Achetez et vendez de tout, des voitures d'occasion aux téléphones mobiles et aux ordinateurs, <br> ou recherchez une propriété, des emplois et plus encore</p>
HTML;
        }

        return <<<HTML
        <!-- Hero Area Start -->
        <div id="hero-area">
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xs-12 text-center">
                        <div class="contents">
                            {$welcomeText}
                            {$this->heroAreaSearchBar()}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero Area End -->
HTML;
    }

    /**
     * Hero Area
     * 
     * @return string
     */
    public function heroArea2()
    {
        return <<<HTML
        <!-- Hero Area Start -->
        <div id="hero-area">
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xs-12 text-center">
                        <div class="contents-ctg">
                            {$this->heroAreaSearchBar()}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero Area End -->
HTML;
    }

    /**
     * Le header qui permet d'afficher le nom de la page sur laquelle
     * on se trouve avec le breadcrumbs.
     * 
     * @return string
     */
    public function pageHeader()
    {
        return <<<HTML
        <!-- Page Header Start -->
        <div class="page-header" style="background: url(assets/img/banner1.jpg);">
            <div class="container">
                <div class="row">         
                    <div class="col-md-12">
                        <div class="breadcrumb-wrapper">
                            <h2 class="product-title">Détails</h2>
                            <ol class="breadcrumb">
                                <li><a href="#">Accueil /</a></li>
                                <li class="current">Détails</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Header End -->
HTML;
    }

    /**
     * La barre de recherche qui s'affiche dans le bloc au début de la page juste en
     * dessous de la barre de navigation.
     * 
     * @return string
     */
    public function heroAreaSearchBar()
    {
        return <<<HTML
        <div class="search-bar">
            <div class="search-inner">
                <form method="" action="" class="search-form">
                    <div class="form-group inputwithicon">
                        <i class="lni-tag"></i>
                        <input type="text" name="customword" class="form-control" placeholder="Entrer un mot">
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
                                <option value="none">Catégories</option>
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
                    <button class="btn btn-common" type="button"><i class="lni-search"></i> Chercher</button>
                </form>
            </div>
        </div>
HTML;
    }

    /**
     * Counter Area. C'est un bloc de code qui affiche des nombres auquels on a un effet
     * d'incrémentation très rapide.
     * 
     * @return string
     */
    public function counterArea()
    {
        return <<<HTML
        <!-- Counter Area Start-->
        <section class="counter-section section-padding">
            <div class="container">
                <div class="row">
                    <!-- Counter Item -->
                    <div class="col-md-3 col-sm-6 work-counter-widget text-center">
                        <div class="counter">
                            <div class="icon"><i class="lni-layers"></i></div>
                            <h2 class="counterUp">12090</h2>
                            <p>Regular Ads</p>
                        </div>
                    </div>
                    <!-- Counter Item -->
                    <div class="col-md-3 col-sm-6 work-counter-widget text-center">
                        <div class="counter">
                            <div class="icon"><i class="lni-map"></i></div>
                            <h2 class="counterUp">350</h2>
                            <p>Locations</p>
                        </div>
                    </div>
                    <!-- Counter Item -->
                    <div class="col-md-3 col-sm-6 work-counter-widget text-center">
                        <div class="counter">
                            <div class="icon"><i class="lni-user"></i></div>
                            <h2 class="counterUp">23453</h2>
                            <p>Reguler Members</p>
                        </div>
                    </div>
                    <!-- Counter Item -->
                    <div class="col-md-3 col-sm-6 work-counter-widget text-center">
                        <div class="counter">
                            <div class="icon"><i class="lni-briefcase"></i></div>
                            <h2 class="counterUp">250</h2>
                            <p>Premium Ads</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Counter Area End-->
HTML;
    }

    /**
     * Pricing Section. La section qui affiche le code pour les prémiums.
     * 
     * @return string
     */
    public function pricingSection()
    {
        return <<<HTML
        <!-- Pricing section Start --> 
        <section id="pricing-table" class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mainHeading">
                            <h2 class="section-title">Select A Package</h2>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="table">
                            <div class="icon">
                                <i class="lni-gift"></i>
                            </div>
                            <div class="title">
                                <h3>SILVER</h3>
                            </div>
                            <div class="pricing-header">
                                <p class="price-value"><sup>$</sup>29<span>/ Mo</span></p>
                            </div>
                            <ul class="description">
                                <li><strong>Free</strong> ad posting</li>
                                <li><strong>No</strong> Featured ads availability</li>
                                <li><strong>For 30</strong> days</li>
                                <li><strong>100%</strong> Secure!</li>
                            </ul>
                            <button class="btn btn-common">Buy Now</button>
                        </div> 
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="table" id="active-tb">
                            <div class="icon">
                                <i class="lni-leaf"></i>
                            </div>
                            <div class="title">
                                <h3>STANDARD</h3>
                            </div>
                            <div class="pricing-header">
                                <p class="price-value"><sup>$</sup>89<span>/ Mo</span></p>
                            </div>
                            <ul class="description">
                                <li><strong>Free</strong> ad posting</li>
                                <li><strong>6</strong> Featured ads availability</li>
                                <li><strong>For 30</strong> days</li>
                                <li><strong>100%</strong> Secure!</li>
                            </ul>
                            <button class="btn btn-common">Buy Now</button>
                        </div> 
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="table">
                            <div class="icon">
                                <i class="lni-layers"></i>
                            </div>
                            <div class="title">
                                <h3>PLATINIUM</h3>
                            </div>
                            <div class="pricing-header">
                                <p class="price-value"><sup>$</sup>99<span>/ Mo</span></p>
                            </div>
                            <ul class="description">
                                <li><strong>Free</strong> ad posting</li>
                                <li><strong>20</strong> Featured ads availability</li>
                                <li><strong>For 25</strong> days</li>
                                <li><strong>100%</strong> Secure!</li>
                            </ul>
                            <button class="btn btn-common">Buy Now</button>
                        </div> 
                    </div>
                </div>
            </div>
        </section>
        <!-- Pricing Table Section End -->
HTML;
    }

    /**
     * Testimonail Section. Section des témoignages.
     * 
     * @return string
     */
    public function testimonialSection()
    {
        return <<<HTML
        <!-- Testimonial Section Start -->
        <section class="testimonial section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div id="testimonials" class="owl-carousel">
                            <div class="item">
                                <div class="testimonial-item">
                                    <div class="img-thumb">
                                        <img src="assets/img/testimonial/img1.png" alt="">
                                    </div>
                                    <div class="content">
                                        <h2><a href="#">John Doe</a></h2>
                                        <p class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo quidem, excepturi facere magnam illum, at accusantium doloremque odio.</p>
                                        <h3>Developer at of <a href="#">xyz company</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="testimonial-item">
                                    <div class="img-thumb">
                                        <img src="assets/img/testimonial/img2.png" alt="">
                                    </div>
                                    <div class="content">
                                        <h2><a href="#">Jessica</a></h2>
                                        <p class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo quidem, excepturi facere magnam illum, at accusantium doloremque odio.</p>
                                        <h3>Developer at of <a href="#">xyz company</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="testimonial-item">
                                    <div class="img-thumb">
                                        <img src="assets/img/testimonial/img3.png" alt="">
                                    </div>
                                    <div class="content">
                                        <h2><a href="#">Johnny Zeigler</a></h2>
                                        <p class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo quidem, excepturi facere magnam illum, at accusantium doloremque odio.</p>
                                        <h3>Developer at of <a href="#">xyz company</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="testimonial-item">
                                    <div class="img-thumb">
                                        <img src="assets/img/testimonial/img1.png" alt="">
                                    </div>
                                    <div class="content">
                                        <h2><a href="#">John Doe</a></h2>
                                        <p class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo quidem, excepturi facere magnam illum, at accusantium doloremque odio.</p>
                                        <h3>Developer at of <a href="#">xyz company</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="testimonial-item">
                                    <div class="img-thumb">
                                        <img src="assets/img/testimonial/img2.png" alt="">
                                    </div>
                                    <div class="content">
                                        <h2><a href="#">Jessica</a></h2>
                                        <p class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo quidem, excepturi facere magnam illum, at accusantium doloremque odio.</p>
                                        <h3>Developer at of <a href="#">xyz company</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Testimonial Section End -->
HTML;
    }

    /**
     * Bloc de code pour la publicité. Elle doit prendre en paramètre une
     * image de taille 300x400.
     * 
     * @return string
     */
    public function advertisementSection()
    {
        return <<<HTML
        <div class="widget">
            <h4 class="widget-title">Advertisement</h4>
            <div class="add-box">
                <img class="img-fluid" src="assets/img/img1.jpg" alt="">
            </div>
        </div>
HTML;
    }

    /**
     * Retourne le vue pour lire la vidéo issue de Youtube.
     * 
     * @param string $youtubeVideoLink
     * 
     * @return string
     */
    public function youtubeIframe(string $youtubeVideoLink)
    {
        return <<<HTML
        <iframe src="https://www.youtube.com/embed/{$youtubeVideoLink}" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen class="w-100 video" style="height:25rem"></iframe>
HTML;
    }

}