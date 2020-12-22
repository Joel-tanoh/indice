<?php

namespace App\View\Model;

use App\Model\Announce;
use App\View\Card;
use App\View\View;

/**
 * Classe de gestion des vues des annonces.
 */
class AnnounceView extends View
{
    protected $announce;

    /**
     * Constructeur de la vue des annonces.
     * 
     * @param \App\Model\Announce $announce
     */
    public function __construct(\App\Model\Announce $announce = null)
    {
        $this->announce = $announce;
    }

    /**
     * Vue de la création d'une annonce.
     * 
     * @return string
     */
    public static function create()
    {
        return <<<HTML
        
HTML;
    }

    /**
     * Permet  d'afficher la vue des détails de l'annonce.
     * 
     * @return string Le code HTML de la vue.
     */
    public function read()
    {
        return <<<HTML
        
HTML;
    }

    /**
     * Un bloc de code HTML qui affiche aucune annonce lorqu'il n'y a pas 
     * d'annonce à afficher dans une partie de la page.
     * 
     * @return string
     */
    private function noAnnounces()
    {
        return <<<HTML
        <div class="col-12">
            <section class="d-flex justify-content-center align-items-center">
                <p class="h5 text-muted">Aucunes annonces</p>
            </section>
        </div>
HTML;
    }

    /**
     * Affiches les 6 dernières annonces postées.
     * 
     * @return string
     */
    public function latestSection()
    {
        return <<<HTML
        <section class="featured section-padding">
            <div class="container">
                <h1 class="section-title">Postées récemment</h1>
                <div class="row">
                    {$this->latestAnnouncesSectionCard()}
                    {$this->latestAnnouncesSectionCard()}
                    {$this->latestAnnouncesSectionCard()}
                    {$this->latestAnnouncesSectionCard()}
                    {$this->latestAnnouncesSectionCard()}
                    {$this->latestAnnouncesSectionCard()}
                </div>
            </div>
        </section>
HTML;
    }

    /**
     * Affiches les annonces vedettes, c'est-à-dire les plus vues.
     * 
     * @return string
     */
    public function featuredSection()
    {
        return <<<HTML
        <section class="featured-lis section-padding" >
            <div class="container">
                <div class="row">
                    <div class="col-md-12 wow fadeIn" data-wow-delay="0.5s">
                        <h3 class="section-title">Les Annonces vedettes</h3>
                        <div id="new-products" class="owl-carousel">
                            {$this->featuredCard()}
                            {$this->featuredCard()}
                            {$this->featuredCard()}
                            {$this->featuredCard()}
                            {$this->featuredCard()}
                            {$this->featuredCard()}
                            {$this->featuredCard()}
                            {$this->featuredCard()}
                        </div>
                    </div> 
                </div>
            </div>
        </section>
HTML;
    }

    /**
     * Une carte pour l'annonce.
     * 
     * @return string
     */
    public function latestAnnouncesSectionCard()
    {
        return <<<HTML
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
                        <a href="#"><i class="lni-folder"></i> Catégorie de l'annonce</a>
                    </div>
                    <h4><a href="ads-details.html">Titre de l'annonce</a></h4>
                    <span>Dernière date de mise à jour</span>
                    <ul class="address">
                        <li>
                            <a href="#"><i class="lni-map-marker"></i> Ville, Pays</a>
                        </li>
                        <li>
                            <a href="#"><i class="lni-alarm-clock"></i> Date de l'annonce</a>
                        </li>
                        <li>
                            <a href="#"><i class="lni-user"></i> Nom de posteur</a>
                        </li>
                    </ul>
                    <div class="listing-bottom">
                        <h3 class="price float-left">Prix XOF</h3>
                        <a href="account-myads.html" class="btn-verified float-right"><i class="lni-check-box"></i> Verified Ad</a>
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * La carte qui s'affiche dans la section featured.
     * 
     * @return string
     */
    public function featuredCard()
    {
        return <<<HTML
        <div class="item">
            <div class="product-item">
                <div class="carousel-thumb">
                    <img class="img-fluid" src="assets/img/product/img1.jpg" alt=""> 
                    <div class="overlay">
                    </div>
                </div>    
                <div class="product-content">
                    <h3 class="product-title"><a href="ads-details.html">Titre de l'annonce</a></h3>
                    <p>Début de la desciption...</p>
                    <span class="price">500 XOF</span>
                    <div class="meta">
                        <span class="count-review">
                            <span>1</span> Vue(s)
                        </span>
                    </div>
                    <div class="card-text">
                        <div class="float-left">
                            <a href="#"><i class="lni-map-marker"></i> Ville, Pays</a>
                        </div>
                        <div class="float-right">
                            <div class="icon">
                            <i class="lni-heart"></i>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Carte sous forme horizontale.
     * 
     * @return string
     */
    public function listFormat()
    {
        return <<<HTML
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="featured-box">
                <figure>
                    <div class="icon">
                        <i class="lni-heart"></i>
                    </div>
                    <a href="#">
                        <img class="img-fluid" src="assets/img/featured/img5.jpg" alt="">
                    </a>
                </figure>
                <div class="feature-content">
                    <div class="product">
                        <a href="#"><i class="lni-folder"></i> Catégorie de l'annonce</a>
                    </div>
                    <h4><a href="ads-details.html">Titre de l'annonce</a></h4>
                    <span>Date de mise à jour</span>
                    <ul class="address">
                        <li>
                            <a href="#"><i class="lni-map-marker"></i> Ville, Pays</a>
                        </li>
                        <li>
                            <a href="#"><i class="lni-alarm-clock"></i> Date de post</a>
                        </li>
                        <li>
                            <a href="#"><i class="lni-user"></i> Nom du user</a>
                        </li>
                    </ul>
                    <div class="listing-bottom">
                        <h3 class="price float-left">Prix. XOF</h3>
                        <a href="account-myads.html" class="btn-verified float-right"><i class="lni-check-box"></i> Annonce certifiée</a>
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Carte d'une annonce en format de grille. Elle s'affiche en format vertical.
     * 
     * @return string
     */
    public function gridFormat()
    {
        return <<<HTML
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="featured-box">
                <figure>
                    <div class="icon">
                        <i class="lni-heart"></i>
                    </div>
                    <a href="#">
                        <img class="img-fluid" src="assets/img/featured/img1.jpg" alt="">
                    </a>
                </figure>
                <div class="feature-content">
                    <div class="product">
                        <a href="#"><i class="lni-folder"></i> Catégorie de l'annonce</a>
                    </div>
                    <h4><a href="ads-details.html">Titre de l'annonce</a></h4>
                    <span>Date de mise à jour</span>
                    <ul class="address">
                        <li>
                            <a href="#"><i class="lni-map-marker"></i> Ville, Pays</a>
                        </li>
                        <li>
                            <a href="#"><i class="lni-alarm-clock"></i> Date de post</a>
                        </li>
                        <li>
                            <a href="#"><i class="lni-user"></i> Nom du user</a>
                        </li>
                    </ul>
                    <div class="listing-bottom">
                        <h3 class="price float-left">Prix. XOF</h3>
                        <a href="account-myads.html" class="btn-verified float-right"><i class="lni-check-box"></i> Annonce certifiée</a>
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

}