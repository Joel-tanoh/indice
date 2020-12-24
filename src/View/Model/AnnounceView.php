<?php

namespace App\View\Model;

use App\Model\Announce;
use App\View\Card;
use App\View\Model\User\UserView;
use App\View\Snippet;
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
    public function create()
    {
        $userView = new UserView();
        $snippet = new Snippet();

        return <<<HTML
        <!-- Enête de la page -->
        {$snippet->pageHeader("Poster mon Annonce", "Poster mon annonce")}

        <!-- Start Content -->
        <div id="content" class="section-padding">
            <div class="container">
                <div class="row">

                    <!-- Sidebar de la page de post -->
                    {$userView->userSidebar()}

                    <!-- Contenu de la page -->
                    {$this->createPageContent()}
                </div>
            </div>      
        </div>
        <!-- End Content -->
HTML;
    }

    /**
     * Permet  d'afficher la vue des détails de l'annonce.
     * 
     * @return string Le code HTML de la vue.
     */
    public function read()
    {
        $snippet = new Snippet();

        return <<<HTML
        <!-- Header de la page -->
        {$snippet->pageHeader("Détails", "Détails")}

        <!-- Contenu de la page -->
        {$this->details()}
HTML;
    }

    /**
     * Détails de l'annonce.
     * 
     * @return string
     */
    private function details()
    {
        return <<<HTML
        <!-- Ads Details Start -->
        <div class="section-padding">
            <div class="container">
                <!-- Product Info Start -->
                {$this->detailsInfos()}
                <!-- Product Info End -->
            </div>    
        </div>
        <!-- Ads Details End -->

        <!-- Featured Listings Start -->
        {$this->featuredSection()}
        <!-- Featured Listings End -->
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
     * Une carte pour l'annonce. La carte qui s'affiche dans la section :
     * posté(e)s dernièrement.
     * 
     * @return string
     */
    public function latestAnnouncesSectionCard()
    {
        return <<<HTML
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="featured-box">
                {$this->announceCardImg()}
                {$this->announceCardContent()}
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
                    <p>Début de la description...</p>
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
     * Carte de l'annonce sous forme horizontale.
     * 
     * @return string
     */
    public function listFormat()
    {
        return <<<HTML
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="featured-box">
                {$this->announceCardImg()}
                {$this->announceCardContent()}
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
                {$this->announceCardImg()}
                {$this->announceCardContent()}
            </div>
        </div>
HTML;
    }

    /**
     * Affiche le contenu sur les cartes vedettes.
     * 
     * @return string
     */
    private function announceCardContent()
    {
        return <<<HTML
        <div class="feature-content">
            <div class="product">
                <a href="category"><i class="lni-folder"></i> Catégorie de l'annonce</a>
            </div>
            <h4><a href="category/annonce">Titre de l'annonce</a></h4>
            <span>Date de mise à jour</span>
            <ul class="address">
                <li>
                    <i class="lni-map-marker"></i> Ville, Pays
                </li>
                <li>
                    <i class="lni-alarm-clock"></i> Date de post
                </li>
                <li>
                    <a href="users/posts"><i class="lni-user"></i> Nom du user</a>
                </li>
            </ul>
            <div class="listing-bottom">
                <h3 class="price float-left">Prix. XOF</h3>
                <a href="category" class="btn-verified float-right"><i class="lni-check-box"></i> Annonce certifiée</a>
            </div>
        </div>
HTML;
    }

    /**
     * Permet d'afficher l'image de l'annonce sur les cartes featured (vedettes).
     * 
     * @return string
     */
    public function announceCardImg()
    {
        return <<<HTML
        <figure>
            <div class="icon">
                <i class="lni-heart"></i>
            </div>
            <a href="category/annonce">
                <img class="img-fluid" src="assets/img/featured/img1.jpg" alt="">
            </a>
        </figure>
HTML;
    }

    /**
     * Last posted in footer code.
     * 
     * @param string $title
     * @param int $price
     * @param string $date
     * 
     * @return string
     */
    public function lastPostedCardInFooter(string $title, int $price = null, string $date = null)
    {
        return <<<HTML
        <li>
            <div class="media-left">
                <img class="img-fluid" src="assets/img/art/img2.jpg" alt="">
                <div class="overlay">
                    <span class="price">{$price} XOF</span>
                </div>
            </div>
            <div class="media-body">
                <h4 class="post-title"><a href="category/annonce">{$title}</a></h4>
                <span class="date">{$date}</span>
            </div>
        </li>
HTML;
    }

    /**
     * Contenu de la page créer une annonce.
     * 
     * @return string
     */
    private function createPageContent()
    {
        return <<<HTML
        <div class="col-sm-12 col-md-8 col-lg-9">
            <div class="row page-content">
                <!-- Announce detail -->
                {$this->enterAnnounceDetails()}
                <!-- Contact detail -->
                {$this->contactDetails()}
            </div>
        </div>
HTML;
    }

    /**
     * Bloc des infos sur l'annonce. Elle affiche le titre et les informations
     * connexes sur l'annonce.
     * 
     * @return string
     */
    private function detailsInfos()
    {
        return <<<HTML
        <div class="product-info row">
            <!-- Images Section -->
            {$this->images()}

            <!-- Title and others informations section -->
            {$this->detailsBox()}
        </div>
HTML;
    }

    /**
     * Bloc des spécifications de l'annonce.
     * 
     * @return string
     */
    private function specifications()
    {
        return <<<HTML
        <h4 class="title-small mb-3">Specification:</h4>
        <ul class="list-specification">
            <li><i class="lni-check-mark-circle"></i> 256GB PCIe flash storage</li>
            <li><i class="lni-check-mark-circle"></i> 2.7 GHz dual-core Intel Core i5</li>
            <li><i class="lni-check-mark-circle"></i> Turbo Boost up to 3.1GHz</li>
            <li><i class="lni-check-mark-circle"></i> Intel Iris Graphics 6100</li>
            <li><i class="lni-check-mark-circle"></i> 8GB memory</li>
            <li><i class="lni-check-mark-circle"></i> 10 hour battery life</li>
            <li><i class="lni-check-mark-circle"></i> 13.3" Retina Display</li>
            <li><i class="lni-check-mark-circle"></i> 1 Year international warranty</li>
        </ul>
HTML;
    }

    /**
     * Show the images of this annonces.
     * 
     * @return string
     */
    private function images()
    {
        return <<<HTML
        <div class="col-lg-7 col-md-12 col-xs-12">
            <div class="details-box ads-details-wrapper">
                <div id="owl-demo" class="owl-carousel owl-theme">
                    <div class="item">
                        <div class="product-img">
                            <img class="img-fluid" src="assets/img/productinfo/img1.jpg" alt="">
                        </div>
                        <span class="price">500 XOF</span>
                    </div>
                    <div class="item">
                        <div class="product-img">
                            <img class="img-fluid" src="assets/img/productinfo/img2.jpg" alt="">
                        </div>
                        <span class="price">500 XOF</span>
                    </div>
                    <div class="item">
                        <div class="product-img">
                            <img class="img-fluid" src="assets/img/productinfo/img3.jpg" alt="">
                        </div>
                        <span class="price">500 XOF</span>
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Affiche le titre et les autres infos textuelles de l'annonce concernée.
     * 
     * @return string
     */
    private function detailsBox()
    {
        return <<<HTML
        <div class="col-lg-5 col-md-12 col-xs-12">
            <div class="details-box">
                <div class="ads-details-info">
                    <h2>Titre de l'annonce</h2>
                    {$this->showDescription()}
                    {$this->metadata()}
                </div>
                <ul class="advertisement mb-4">
                    <li>
                        <p><strong><i class="lni-folder"></i> Catégories :</strong> <a href="category">Electronics</a></p>
                    </li>
                    <li>
                        <p><a href="users/john/posts"><i class="lni-users"></i> Plus d'annonces de <span>John</span></a></p>
                    </li>
                </ul>
                {$this->infosForJoinUser()}
                {$this->shareMe()}
            </div>
        </div>
HTML;
    }

    /**
     * Affiche la description de l'annonce.
     * 
     * @return string
     */
    private function showDescription()
    {
        return <<<HTML
        <div class="description">
            <h5>Description</h5>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
            </p>
        </div>
HTML;
    }

    /**
     * Affiche l'heure, le lieu et le nom de l'utilisateur.
     * 
     * @return string
     */
    private function metadata()
    {
        return <<<HTML
        <div class="details-meta">
            <span><i class="lni-alarm-clock"></i> Date et heure de post</span>
            <span><i class="lni-map-marker"></i>  Ville</span>
            <span><i class="lni-eye"></i> 200 vue(s)</span>
        </div>
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
     * Affiche l'adresse email et le numéro à joindre pour l'annonce.
     * 
     * @return string
     */
    private function infosForJoinUser()
    {
        return <<<HTML
        <div class="ads-btn mb-4">
            <a href="#" class="btn btn-common btn-reply"><i class="lni-envelope"></i> adresse@email.com</a>
            <a href="#" class="btn btn-common"><i class="lni-phone-handset"></i> 01154256643</a>
        </div>
HTML;
    }

    /**
     * Bloc de code qui permet de partager l'annonce en cours.
     * 
     * @return string
     */
    private function shareMe()
    {
        return <<<HTML
        <div class="share">
            <span>Partager: </span>
            <div class="social-link">  
                <a class="facebook" href="#"><i class="lni-facebook-filled"></i></a>
                <a class="twitter" href="#"><i class="lni-twitter-filled"></i></a>
                <a class="linkedin" href="#"><i class="lni-linkedin-fill"></i></a>
                <a class="google" href="#"><i class="lni-google-plus"></i></a>
            </div>
        </div>
HTML;
    }

    /**
     * Les champs pour entrer les détails de l'annonce lors de sa création.
     * 
     * @return string
     */
    private function enterAnnounceDetails()
    {
        $categoryView = new CategoryView();

        return <<<HTML
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
            <div class="inner-box">
                <div class="dashboard-box">
                    <h2 class="dashbord-title">Détails de l'annonce</h2>
                </div>
                <div class="dashboard-wrapper">
                    <div class="form-group mb-3">
                        <label class="control-label">Titre</label>
                        <input class="form-control input-md" name="Title" placeholder="Titre" type="text">
                    </div>
                    <div class="form-group mb-3 tg-inputwithicon">
                        <label class="control-label">Catégories</label>
                        <div class="tg-select form-control">
                            <select>
                                <option value="none">Sélectionner la catégorie</option>
                                {$categoryView->selectOptions()}
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="control-label">Prix</label>
                        <input class="form-control input-md" name="price" placeholder="Ajouter le prix" type="text">
                        <div class="tg-checkbox mt-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="tg-priceoncall">
                                <label class="custom-control-label" for="tg-priceoncall">Prix à l'appel</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group md-3">
                        <section id="editor">
                            <div id="summernote">
                            </div>
                        </section>
                    </div>
                    <label class="tg-fileuploadlabel" for="tg-photogallery">
                        <span>Glissez votre fichier pour le charger</span>
                        <span>Ou</span>
                        <span class="btn btn-common">Séléctionner un fichier</span>
                        <span>Taille maximum des fichiers: 2 MB</span>
                        <input id="tg-photogallery" class="tg-fileinput" type="file" name="file">
                    </label>
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Permet d'enter les détails sur le contact pour l'annonce.
     * 
     * @return string
     */
    private function contactDetails()
    {
        return <<<HTML
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
            <div class="inner-box">
                <div class="tg-contactdetail">
                    <div class="dashboard-box">
                        <h2 class="dashbord-title">Contacts</h2>
                    </div>
                    <div class="dashboard-wrapper">
                        <div class="form-group mb-3">
                            <strong>Je suis :</strong>
                            <div class="tg-selectgroup">
                                <span class="tg-radio">
                                    <input id="tg-sameuser" type="radio" name="usertype" value="same user" checked="">
                                    <label for="tg-sameuser">L'annonceur</label>
                                </span>
                                <span class="tg-radio">
                                    <input id="tg-someoneelse" type="radio" name="usertype" value="someone else">
                                    <label for="tg-someoneelse">Une autre personne</label>
                                </span>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Prénoms*</label>
                            <input class="form-control input-md" name="name" type="text">
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Nom*</label>
                            <input class="form-control input-md" name="name" type="text">
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Téléphone*</label>
                            <input class="form-control input-md" name="phone" type="text">
                        </div>
                        <div class="tg-checkbox">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="tg-agreetermsandrules">
                                <label class="custom-control-label" for="tg-agreetermsandrules">D'accord avec les <a href="javascript:void(0);">Terms of Use &amp; Posting Rules</a></label>
                            </div>
                        </div>
                        <button class="btn btn-common" type="button">Poster</button>
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

}