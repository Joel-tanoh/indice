<?php

namespace App\View\Model;

use App\Auth\Cookie;
use App\Model\Announce;
use App\Model\User\Registered;
use App\View\Snippet;
use App\View\View;
use App\View\Form;
use App\Auth\Session;
use App\View\Model\User\RegisteredView;

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
     * @param string $message Le message retourné en fonction de l'issue de 
     *                        l'action.
     * 
     * @return string
     */
    public function create(string $message = null)
    {
        $registeredView = new RegisteredView(new Registered(Session::get()));
        $snippet = new Snippet();

        return <<<HTML
        <!-- Enête de la page -->
        {$snippet->pageHeader("Poster mon Annonce", "Poster mon annonce")}

        <!-- Message affiché en fonction de l'issue de l'action -->
        {$message}

        <!-- Start Content -->
        <div id="content" class="section-padding">
            <div class="container">
                <div class="row">
                    <!-- Sidebar de la page de post -->
                    {$registeredView->sidebarNav()}

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
     * La vue qui permet qui permet de manager l'annonce.
     * 
     * @return string
     */
    public function manage(\App\Model\User\Registered $registered)
    {
        $snippet = new Snippet;
        $registeredView = new RegisteredView($registered);

        return <<<HTML
        {$snippet->pageHeader($this->announce->getTitle(), "Gestion de mon announce")}

        <div id="content" class="section-padding">
            <div class="container">
                <div class="row">
                    {$registeredView->sidebarNav()}
                    <div class="col-sm-12 col-md-8 col-lg-9">
                        <section class="row">
                            {$this->productInfosImgSection("col-lg-8 col-md-12 col-xs-12")}
                            <section class="col-lg-4 col-md-12 col-xs-12">
                                {$this->metadataTable()}
                            </section>
                        </section>
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * La vue qui permet de modifier une announce.
     * 
     * @return string
     */
    public function update(string $message = null)
    {
        return <<<HTML

HTML;
    }

    /**
     * Affiches les 6 dernières annonces postées.
     * 
     * @return string
     */
    public function latestSection()
    {
        $content = null;
        $announces = Announce::getLastPosted(6);

        if (empty($content)) {
            $content = AnnounceView::noAnnounces();
        } else {
            foreach ($announces as $item) {
                $announce = new Announce($item["id"]);
                $announceView = new AnnounceView($announce);
                $content .= $announceView->latestAnnouncesSectionCard();
            }
        }

        return <<<HTML
        <section class="featured section-padding">
            <div class="container">
                <h1 class="section-title">Postées récemment</h1>
                <div class="row">
                    {$content}
                </div>
            </div>
        </section>
HTML;
    }

    /**
     * Affiches les annonces vedettes.
     * 
     * @return string
     */
    public function featuredSection()
    {
        $content = null;
        $announces = Announce::getFeatured(6);

        if (empty($content)) {
            $content = AnnounceView::noAnnounces();
        } else {
            foreach ($announces as $item) {
                $announce = new Announce($item["id"]);
                $announceView = new AnnounceView($announce);
                $content .= $announceView->featuredCard();
            }
        }

        return <<<HTML
        <section class="featured-lis section-padding" >
            <div class="container">
                <div class="row">
                    <div class="col-md-12 wow fadeIn" data-wow-delay="0.5s">
                        <h3 class="section-title">Les Annonces vedettes</h3>
                        <div id="new-products" class="owl-carousel">
                            {$content}
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
                    <img class="img-fluid" src="{$this->announce->getProductImgSrc()}" alt="Une image de {$this->announce->getSlug()}"> 
                    <div class="overlay">
                    </div>
                </div>    
                <div class="product-content">
                    <h3 class="product-title"><a href="ads-details.html">{$this->announce->getTitle()}</a></h3>
                    <p>{$this->announce->getDescription(75)}</p>
                    <span class="price">{$this->announce->getPrice()}</span>
                    <div class="meta">
                        <span class="count-review">
                            <span>{$this->announce->getViews()}</span> Vue(s)
                        </span>
                    </div>
                    <div class="card-text">
                    <div class="float-left">
                        {$this->showLocation()}
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
     * Last posted in footer code.
     * 
     * @return string
     */
    public function lastPostedCardInFooter()
    {
        return <<<HTML
        <li>
            <div class="media-left">
                <img class="img-fluid" src="{$this->announce->getArtInFooterImgSrc()}" alt="Photo de {$this->announce->getSlug()}">
                <div class="overlay">
                    <span class="price">{$this->announce->getPrice()}</span>
                </div>
            </div>
            <div class="media-body">
                <h4 class="post-title"><a href="{$this->announce->getLink()}">{$this->announce->getTitle()}</a></h4>
                <span class="date">{$this->announce->getCreatedAt()}</span>
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
        $form = new Form($_SERVER["REQUEST_URI"], "row page-content");

        return <<<HTML
        <div class="col-sm-12 col-md-8 col-lg-9">
            {$form->open()}
                <!-- Announce detail -->
                {$this->enterAnnounceDetails()}
                <!-- Contact detail -->
                {$this->contactDetails()}
            {$form->close()}
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
            {$this->productInfosImgSection()}

            <!-- Title and others informations section -->
            {$this->detailsBox()}
        </div>
HTML;
    }

    /**
     * Permet d'afficher l'image de l'annonce sur les cartes featured (vedettes).
     * 
     * @return string
     */
    private function announceCardImg()
    {
        return <<<HTML
        <figure>
            <div class="icon">
                <i class="lni-heart"></i>
            </div>
            <a href="{$this->announce->getLink()}">
                <img class="img-fluid" src="{$this->announce->getProductImgSrc()}" alt="Photo de {$this->announce->getSlug()}">
            </a>
        </figure>
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
                <a href="{$this->announce->getCategory()->getSlug()}"><i class="lni-folder"></i> {$this->announce->getCategory()->getTitle()}</a>
            </div>
            <h4><a href="{$this->announce->getLink()}">{$this->announce->getTitle()}</a></h4>
            <span>{$this->announce->getUpdatedAt()}</span>
            <ul class="address">
                <li>
                    {$this->showLocation()}
                </li>
                <li>
                    <i class="lni-alarm-clock"></i> {$this->announce->getCreatedAt()}
                </li>
                <li>
                    <a href="users/posts"><i class="lni-user"></i> {$this->announce->getOwner()->getName()} {$this->announce->getOwner()->getFirstNames()}</a>
                </li>
            </ul>
            <div class="listing-bottom">
                <h3 class="price float-left">{$this->announce->getPrice()}</h3>
                <a href="{$this->announce->getCategory()->getSlug()}" class="btn-verified float-right"><i class="lni-check-box"></i> Annonce validée</a>
            </div>
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
     * @param string $bootstrapColClass
     * 
     * @return string
     */
    private function productInfosImgSection(string $bootstrapColClass = "col-lg-7 col-md-12 col-xs-12")
    {
        $imgSection = null;
        foreach ($this->announce->getAllProductInfoImg() as $src) {
            $imgSection .= $this->productInfoImg($src, "Photo de " . $this->announce->getSlug(), $this->announce->getPrice());
        }
        
        return <<<HTML
        <div class="{$bootstrapColClass}">
            <div class="details-box ads-details-wrapper">
                <div id="owl-demo" class="owl-carousel owl-theme">
                    {$imgSection}
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Affiche une image sur la page de détails d'une annonce.
     */
    private function productInfoImg(string $imgSrc, string $altText, string $price)
    {
        return <<<HTML
        <div class="item">
            <div class="product-img">
                <img class="img-fluid" src="{$imgSrc}" alt="{$altText}">
            </div>
            <span class="price">{$price}</span>
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
                    <h2>{$this->announce->getTitle()}</h2>
                    {$this->manageButtons()}
                    {$this->showDescription()}
                    {$this->metadata()}
                </div>
                <ul class="advertisement mb-4">
                    <li>
                        <p><strong><i class="lni-folder"></i> Catégories :</strong> <a href="{$this->announce->getCategory()->getSlug()}">{$this->announce->getCategory()->getTitle()}</a></p>
                    </li>
                    <li>
                        <p><a href="/posts/{$this->announce->getOwner()->getPseudo()}"><i class="lni-users"></i> Plus d'annonces de <span>{$this->announce->getOwner()->getName()}</span></a></p>
                    </li>
                </ul>
                {$this->infosForJoinUser()}
                {$this->shareMe()}
                {$this->showComments()}
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
            <p>{$this->announce->getDescription()}</p>
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
            <span><i class="lni-alarm-clock"></i> {$this->announce->getCreatedAt()}</span>
            <span>{$this->showLocation()}</span>
            <span><i class="lni-eye"></i> {$this->announce->getViews()} vue(s)</span>
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
            <a class="btn btn-common text-white btn-reply"><i class="lni-envelope"></i> {$this->announce->getUserToJoin()}</a>
            <a class="btn btn-common text-white"><i class="lni-phone-handset"></i> {$this->announce->getPhoneNumber()}</a>
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
        $snippet = new Snippet();

        return <<<HTML
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
            <div class="inner-box">
                <div class="dashboard-box">
                    <h2 class="dashbord-title">Détails de l'annonce</h2>
                </div>
                <div class="dashboard-wrapper">
                    <div class="form-group mb-3">
                        <label class="control-label">Titre :</label>
                        <input class="form-control input-md" name="title" placeholder="Titre" type="text" required>
                    </div>
                    <div class="form-group mb-3 tg-inputwithicon">
                        <label class="control-label">Catégories :</label>
                        <div class="tg-select form-control">
                            <select name="id_category">
                                <option value="0">Sélectionner la catégorie</option>
                                {$categoryView->selectOptions()}
                            </select>
                        </div>
                    </div>
                    <div class="row my-2 pt-2">
                        <div class="col-6">
                            {$this->chooseDirection()}
                        </div>
                        <div class="col-6">
                            {$this->chooseType()}
                        </div>
                    </div>
                    <div class="form-group mb-3 tg-inputwithicon">
                        <label class="control-label">Ville :</label>
                        <div class="tg-select form-control">
                            {$snippet->townList("location")}
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div id="enter_price_box">
                            <label class="control-label">Prix :</label>
                            <input class="form-control input-md" name="price" placeholder="Ajouter le prix (F CFA)" type="number">
                        </div>
                        <div class="tg-checkbox mt-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="price_on_call" id="tg-priceoncall">
                                <label class="custom-control-label" for="tg-priceoncall">Prix à l'appel</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group md-3">
                        <section id="editor">
                            <textarea name="description" id="summernote" required></textarea>
                        </section>
                    </div>
                    <label class="tg-fileuploadlabel" for="tg-photogallery">
                        <span>Glissez votre fichier pour le charger</span>
                        <span>Ou</span>
                        <span class="btn btn-common">Séléctionner 3 fichiers</span>
                        <span>Taille maximum des fichiers: 2 MB</span>
                        <input id="tg-photogallery" class="tg-fileinput" type="file" name="images[]" multiple>
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
                            <strong>Qui contacter ?</strong>
                            <div class="tg-selectgroup">
                                <span class="tg-radio">
                                    <input id="tg-sameuser" type="radio" name="usertype" value="current_user" checked>
                                    <label for="tg-sameuser">Moi</label>
                                </span>
                                <span class="tg-radio">
                                    <input id="tg-someoneelse" type="radio" name="usertype" value="someone_else">
                                    <label for="tg-someoneelse">Une autre personne</label>
                                </span>
                            </div>
                        </div>
                        <div id="someone_else">
                            <div class="form-group mb-3">
                                <label class="control-label">Adresse email*</label>
                                <input class="form-control input-md" name="user_to_join" type="email">
                            </div>
                            <div class="form-group mb-3">
                                <label class="control-label">Téléphone*</label>
                                <input class="form-control input-md" name="phone_number" type="text" placeholder="+XXX XXXXXXXXXX">
                            </div>
                        </div>
                        <button class="btn btn-common" type="submit">Poster</button>
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Permet d'afficher le lieu de l'annonce.
     * @return string|null
     */
    private function showLocation()
    {
        return '<a><i class="lni-map-marker"></i>'. $this->announce->getLocation() .'</a>';
    }

    /**
     * Permet de choisir le type d'annonce.
     * @return string
     */
    private function chooseType()
    {
        return <<<HTML
        <div class="form-group mb-3">
            <strong>Type :</strong>
            <div class="tg-selectgroup">
                <span class="tg-radio">
                    <input id="tg-particular" type="radio" name="type" value="particulier">
                    <label for="tg-particular">Particulier</label>
                </span>
                <span class="tg-radio">
                    <input id="tg-professionnal" type="radio" name="type" value="professionnel">
                    <label for="tg-professionnal">Professionnel</label>
                </span>
            </div>
        </div>
HTML;
    }

    /**
     * Permet de choisir la direction de l'offre, demande ou offre.
     * @return string
     */
    private function chooseDirection()
    {
        return <<<HTML
        <div class="form-group mb-3">
            <strong>Sens :</strong>
            <div class="tg-selectgroup">
                <span class="tg-radio">
                    <input id="tg-offre" type="radio" name="direction" value="offre">
                    <label for="tg-offre">Offre</label>
                </span>
                <span class="tg-radio">
                    <input id="tg-demande" type="radio" name="direction" value="demande">
                    <label for="tg-demande">Demande</label>
                </span>
            </div>
        </div>
HTML;
    }

    /**
     * Une ligne qui affiche une annonce et quelque détails.
     * 
     * @return string
     */
    public function registeredDashboardRow()
    {
        return <<<HTML
        <tr data-category="active">
            <td>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="adone">
                    <label class="custom-control-label" for="done"></label>
                </div>
            </td>
            <td class="photo"><img class="img-fluid" src="{$this->announce->getProductImgSrc()}" alt="Image de {$this->announce->getSlug()}"></td>
            <td data-title="Title">
                <h3>{$this->announce->getTitle()}</h3>
                <span>ID: {$this->announce->getId()}</span>
            </td>
            <td data-title="Category"><span class="adcategories">{$this->announce->getCategory()->getTitle()}</span></td>
            <td data-title="Ad Status">{$this->dashboardAnnounceStatus()}</td>
            <td data-title="Price">
                <h3>{$this->announce->getPrice()}</h3>
            </td>
            <td data-title="Action">
                <div class="btns-actions">
                    <a class="btn-action btn-view" href='{$this->announce->getLink()}'><i class="lni-eye"></i></a>
                    <a class="btn-action btn-edit" href='{$this->announce->getManageLink("update")}'><i class="lni-pencil"></i></a>
                    <a class="btn-action btn-delete" href='{$this->announce->getManageLink("delete")}'><i class="lni-trash"></i></a>
                </div>
            </td>
        </tr>
HTML;
    }
    
    /**
     * Permet d'afficher le statut de l'annonce dans le tableau
     * du dashboard de l'utilisateur.
     * 
     * @return string
     */
    private function dashboardAnnounceStatus()
    {
        if ($this->announce->getStatus() == "Pending") {
            $statusClass = "adstatusactive bg-warning";
            $statusText = "En attente";
        } elseif ($this->announce->getStatus() == "Validated") {
            $statusClass = "adstatusactive bg-success";
            $statusText = "Validée";
        } elseif ($this->announce->getStatus() == "Featured") {
            $statusClass = "adstatusexpired";
            $statusText = "Vedette";
        } elseif ($this->announce->getStatus() == "Premium") {
            $statusClass = "adstatussold";
            $statusText = "Prémium";
        } else {
            $statusClass = "adstatusexpired";
            $statusText = "Bloquée";
        }

        return <<<HTML
        <span class="adstatus {$statusClass}">{$statusText}</span>
HTML;
    }
        
    /**
     * Un bloc de code HTML qui affiche aucune annonce lorqu'il n'y a pas 
     * d'annonce à afficher dans une partie de la page.
     * 
     * @return string
     */
    public static function noAnnounces()
    {
        return <<<HTML
        <div class="row">
            <div class="col-12">
                <section class="d-flex justify-content-center align-items-center">
                    <p class="h4 text-muted">Aucunes annonces</p>
                </section>
            </div>
        </div>
HTML;
    }

    /**
     * Affiche un tableau contenant les données meta de cette
     * announce.
     * 
     * @return string
     */
    private function metadataTable()
    {
        return <<<HTML
        <h4>Infos</h4>
        <table class="table">
            {$this->metadataTableRow("ID", $this->announce->getId())}
            {$this->metadataTableRow("Titre", $this->announce->getTitle())}
            {$this->metadataTableRow("Slug", $this->announce->getSlug())}
            {$this->metadataTableRow("Vues", $this->announce->getViews())}
            {$this->metadataTableRow("Statut", $this->announce->getStatus())}
        </table>
HTML;
    }

    /**
     * Affiche une ligne dans le tableau des données de l'annonce
     */
    private function metadataTableRow(string $index, string $value)
    {
        return <<<HTML
        <tr><td>{$index}</td><td>{$value}</td></tr>
HTML;
    }

    /**
     * Affiche le bouton pour supprimer ou modifier l'annonce.
     * 
     * @return string
     */
    private function manageButtons()
    {
        if (Session::isActive() || Cookie::userCookieIsset()) {
            $sessionId = Session::get() ?? Cookie::get();
            $registered = new Registered($sessionId);
            if ($this->announce->getOwner()->getEmailAddress() === $registered->getEmailAddress()
                || $registered->isAdministrator()
            ) {
                return <<<HTML
                Des boutons.
HTML;
            }
        }
    }

    /**
     * Permet de laisser des commentaires(suggestions) sur l'annonce.
     * @return string
     */
    private function putComments()
    {
        if (Session::isActive() || Cookie::userCookieIsset()) {
            $sessionId = Session::get() ?? Cookie::get();
            $registered = new Registered($sessionId);
            if ($this->announce->getOwner()->getEmailAddress() === $registered->getEmailAddress()
                || $registered->isAdministrator()
            ) {
                return <<<HTML
                Champs pour mettre des suggestions.
HTML;
            }
        }
    }

    /**
     * Affiche les commentaires de cette annonces. Avant d'afficher
     * les commentaires on verifie si l'utilisateur est propriétaire
     * de l'annonce ou est un administrateur.
     * 
     * @return string
     */
    private function showComments()
    {
        if (Session::isActive() || Cookie::userCookieIsset()) {
            $sessionId = Session::get() ?? Cookie::get();
            $registered = new Registered($sessionId);
            if ($this->announce->getOwner()->getEmailAddress() === $registered->getEmailAddress()
                || $registered->isAdministrator()
            ) {
                return <<<HTML
                Cette partie affichera les suggestions laissées et les reponses.
HTML;
            }
        }
    }

}