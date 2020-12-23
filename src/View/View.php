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

        return <<<HTML
        <!-- Hero Area -->
        {$snippet->heroArea(true)}
        <!-- Hero Area End -->

        <!-- Trending Categories Section Start -->
<<<<<<< HEAD
        <section class="categories-icon section-padding bg-drack">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-car"></i>
                                </div>
                                <h4>Vehicule</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-display"></i>
                                </div>
                                <h4>Electroniques</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-mobile"></i>
                                </div>
                                <h4>Mobiles</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-leaf"></i>
                                </div>
                                <h4>Fournitures</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-tshirt"></i>
                                </div>
                                <h4>Mode</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-briefcase"></i>
                                </div>
                                <h4>Jobs</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-home"></i>
                                </div>
                                <h4>Immobiliers</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-hand"></i>
                                </div>
                                <h4>Animaux</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-graduation"></i>
                                </div>
                                <h4>Education</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-laptop"></i>
                                </div>
                                <h4>Ordinateurs & PCs</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-paint-roller"></i>
                                </div>
                                <h4>Services</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-heart"></i>
                                </div>
                                <h4>Mariage</h4>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Trending Categories Section End -->

        <!-- Featured Section Start -->
        <section class="featured section-padding">
            <div class="container">
                <h1 class="section-title">Derniers Produits</h1>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                        <div class="featured-box">
                        <figure>
                            <div class="icon">
                            <i class="lni-heart"></i>
                            </div>
                            <a href="#"><img class="img-fluid" src="assets/img/featured/img1.jpg" alt=""></a>
                        </figure>
                        <div class="feature-content">
                            <div class="product">
                            <a href="#"><i class="lni-folder"></i> Telephones Portables</a>
                            </div>
                            <h4><a href="ads-details.html">Apple iPhone X</a></h4>
                            <span>Last Updated: 1 hours ago</span>
                            <ul class="address">
                            <li>
                                <a href="#"><i class="lni-map-marker"></i> New York, US</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-alarm-clock"></i> Feb 18, 2018</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-user"></i> Maria Barlow</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-package"></i> Used</a>
                            </li>
                            </ul>
                            <div class="listing-bottom">
                            <h3 class="price float-left">$200.00</h3>
                            <a href="account-myads.html" class="btn-verified float-right"><i class="lni-check-box"></i> Verified Ad</a>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                        <div class="featured-box">
                        <figure>
                            <div class="icon">
                            <i class="lni-heart"></i>
                            </div>
                            <a href="#"><img class="img-fluid" src="assets/img/featured/img2.jpg" alt=""></a>
                        </figure>
                        <div class="feature-content">
                            <div class="product">
                            <a href="#"><i class="lni-folder"></i> Immobilier</a>
                            </div>
                            <h4><a href="ads-details.html">Amazing Room for Rent</a></h4>
                            <span>Last Updated: 2 hours ago</span>
                            <ul class="address">
                            <li>
                                <a href="#"><i class="lni-map-marker"></i> Dallas, Washington</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-alarm-clock"></i> Jan 7, 2018</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-user"></i> John Smith</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-package"></i> N/A</a>
                            </li>
                            </ul>
                            <div class="listing-bottom">
                            <h3 class="price float-left">$450.00</h3>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                        <div class="featured-box">
                        <figure>
                            <div class="icon">
                            <i class="lni-heart"></i>
                            </div>
                            <a href="#"><img class="img-fluid" src="assets/img/featured/img3.jpg" alt=""></a>
                        </figure>
                        <div class="feature-content">
                            <div class="product">
                            <a href="#"><i class="lni-folder"></i> Electroniques</a>
                            </div>
                            <h4><a href="ads-details.html">Canon SX Powershot D-SLR</a></h4>
                            <span>Last Updated: 4 hours ago</span>
                            <ul class="address">
                            <li>
                                <a href="#"><i class="lni-map-marker"></i> Dallas, Washington</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-alarm-clock"></i> Mar 18, 2018</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-user"></i> David Givens</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-package"></i> Used</a>
                            </li>
                            </ul>
                            <div class="listing-bottom">
                            <h3 class="price float-left">$700.00</h3>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                        <div class="featured-box">
                        <figure>
                            <div class="icon">
                            <i class="lni-heart"></i>
                            </div>
                            <a href="#"><img class="img-fluid" src="assets/img/featured/img4.jpg" alt=""></a>
                        </figure>
                        <div class="feature-content">
                            <div class="product">
                            <a href="#"><i class="lni-folder"></i> Vehicules</a>
                            </div>
                            <h4><a href="ads-details.html">BMW 5 Series GT Car</a></h4>
                            <span>Last Updated: 5 hours ago</span>
                            <ul class="address">
                            <li>
                                <a href="#"><i class="lni-map-marker"></i> Dallas, Washington</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-alarm-clock"></i> Dec 18, 2018</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-user"></i> Elon Musk</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-package"></i> N/A</a>
                            </li>
                            </ul>
                            <div class="listing-bottom">
                            <h3 class="price float-left">$300.00</h3>
                            <a href="account-myads.html" class="btn-verified float-right"><i class="lni-check-box"></i> Verified Ad</a>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                        <div class="featured-box">
                        <figure>
                            <div class="icon">
                            <i class="lni-heart"></i>
                            </div>
                            <a href="#"><img class="img-fluid" src="assets/img/featured/img5.jpg" alt=""></a>
                        </figure>
                        <div class="feature-content">
                            <div class="product">
                            <a href="#"><i class="lni-folder"></i> Apple</a>
                            </div>
                            <h4><a href="ads-details.html">Apple Macbook Pro 13 Inch</a></h4>
                            <span>Last Updated: 4 hours ago</span>
                            <ul class="address">
                            <li>
                                <a href="#"><i class="lni-map-marker"></i>Louis, Missouri, US</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-alarm-clock"></i> May 18, 2018</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-user"></i> Will Ernest</a>
                            </li>
                            <li>
                                <a href="#"><i class="lni-package"></i> Brand New</a>
                            </li>
                            </ul>
                            <div class="listing-bottom">
                            <h3 class="price float-left">$450.00</h3>
                            <a href="account-myads.html" class="btn-verified float-right"><i class="lni-check-box"></i> Verified Ad</a>
                            </div>
                        </div>
                        </div>
                    </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="featured-box">
                    <figure>
                        <div class="icon">
                        <i class="lni-heart"></i>
                        </div>
                        <a href="#"><img class="img-fluid" src="assets/img/featured/img6.jpg" alt=""></a>
                    </figure>
                    <div class="feature-content">
                        <div class="product">
                        <a href="#"><i class="lni-folder"></i> Restaurant</a>
                        </div>
                        <h4><a href="ads-details.html">Cream Restaurant</a></h4>
                        <span>Last Updated: 4 hours ago</span>
                        <ul class="address">
                        <li>
                            <a href="#"><i class="lni-map-marker"></i> Dallas, Washington</a>
                        </li>
                        <li>
                            <a href="#"><i class="lni-alarm-clock"></i> Feb 18, 2018</a>
                        </li>
                        <li>
                            <a href="#"><i class="lni-user"></i>  Samuel Palmer</a>
                        </li>
                        <li>
                            <a href="#"><i class="lni-package"></i> Brand New</a>
                        </li>
                        </ul>
                        <div class="listing-bottom">
                        <h3 class="price float-left">$250.00</h3>
                        <a href="account-myads.html" class="btn-verified float-right"><i class="lni-check-box"></i> Verified Ad</a>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </section>
        <!-- Featured Section End -->
=======
        {$categoryView->trendingCategoriesSection()}
        <!-- Trending Categories Section End -->

        <!-- Latest Announcements Section Start -->
        {$annonceView->latestSection()}
        <!-- Latest Announcements Section End -->
>>>>>>> fbd9d76861163ef1a6f59acc5e0db793edc4e9c0
        
        <!-- Featured Listings Start -->
        {$annonceView->featuredSection()}
        <!-- Featured Listings End -->

        <!-- Subscribe Section Start -->
        {$userView->suscribeSection()}
        <!-- Subscribe Section End -->
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