<?php

namespace App\View\Model;

use App\Communication\SocialNetwork\SocialNetwork;
use App\Model\Announce;
use App\View\Snippet;
use App\View\View;
use App\View\Form;
use App\Model\User\User;
use App\View\AdvertisingView;
use App\View\Model\User\UserView;
use App\View\Model\User\RegisteredView;
use App\View\Communication\CommentView;

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
     * Affiche toutes les announces.
     * 
     * @param array $announces
     * @return string
     */
    public function announces(array $announces)
    {
        $snippet = new Snippet;
        $advertising = new AdvertisingView;
        $categoryView = new CategoryView();

        return <<<HTML
        <!-- Hero Area -->
        {$snippet->pageHeader("Toutes les Annonces", "Annonces")}
        <!-- Main container Start -->
        <div class="main-container pb-3">
            <div class="container-fluid">
                {$advertising->top()}
                <div class="row">
                    <aside class="d-none d-lg-block col-lg-2">
                        {$advertising->left()}
                    </aside>
                    <aside class="col-12 col-lg-8">
                        <section class="row">
                            <!-- Sidebar -->
                            {$categoryView->sidebar()}
                            <!-- Content -->
                            {$this->list($announces)}
                        </section>
                    </aside>
                    <aside class="d-none d-lg-block col-lg-2">
                        {$advertising->right()}
                    </aside>
                </div>
            </div>
        </div> 
HTML;
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
        $registeredView = new RegisteredView(User::authenticated());
        $snippet = new Snippet();

        return <<<HTML
        {$snippet->pageHeader("Poster mon Annonce", "Poster mon annonce")}
        {$message}
        <div id="content" class="section-padding">
            <div class="container">
                <div class="row">
                    <!-- Sidebar de la page de post -->
                    {$registeredView->sidebarNav(User::authenticated())}

                    <!-- Contenu de la page -->
                    {$this->createPageContent()}
                </div>
            </div>      
        </div>
HTML;
    }

    /**
     * Permet  d'afficher la vue des détails de l'annonce.
     * @return string Le code HTML de la vue.
     */
    public function read()
    {
        $snippet = new Snippet();

        return <<<HTML
        <!-- Header de la page -->
        {$snippet->pageHeader($this->announce->getTitle(), $this->announce->getTitle())}
        <!-- Contenu de la page -->
        {$this->details()}
HTML;
    }

    /**
     * La vue qui permet de modifier une announce.
     * 
     * @return string
     */
    public function update(string $message = null)
    {
        $snippet = new Snippet;
        $registeredView = new RegisteredView();

        return <<<HTML
        {$snippet->pageHeader($this->announce->getTitle(), "Gestion de mon announce")}
        <!-- Message affiché en fonction de l'issue de l'action -->
        {$message}

        <div id="content" class="section-padding">
            <div class="container">
                <div class="row">
                    {$registeredView->sidebarNav(User::authenticated())}
                    <!-- Contenu de la page -->
                    {$this->createPageContent()}
                </div>
            </div>
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
        $content = null;
        $announces = Announce::getLastPosted(6);

        if (empty($announces)) {
            $content = self::noAnnounces();
        } else {
            foreach ($announces as $announce) {
                $content .= (new self($announce))->latestAnnouncesSectionCard();
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
     * Affiches les annonces premium.
     * 
     * @return string
     */
    public function premiumSection()
    {
//         $content = null;
//         $announces = Announce::getPremium(6);

//         if (empty($content)) {
//             $content = self::noAnnounces();
//         } else {
//             foreach ($announces as $item) {
//                 $announce = new Announce($item["id"]);
//                 $announceView = new self($announce);
//                 $content .= $announceView->premiumCard();
//             }
//         }

//         return <<<HTML
//         <section class="featured-lis section-padding" >
//             <div class="container">
//                 <div class="row">
//                     <div class="col-md-12 wow fadeIn" data-wow-delay="0.5s">
//                         <h3 class="section-title">Les Annonces Premium</h3>
//                         <div id="new-products" class="owl-carousel">
//                             {$content}
//                         </div>
//                     </div> 
//                 </div>
//             </div>
//         </section>
// HTML;
    }

    /**
     * La vue qui affiche la liste des annonces.
     * 
     * @param array $announces
     * 
     * @return string
     */
    public function list(array $announces)
    {
        return <<<HTML
        <div class="col-lg-9 col-md-12 col-xs-12 page-content">
            {$this->announcesSection($announces)}
        </div>
HTML;
    }

    /**
     * La section qui affiche les annonces en format de grille ou en
     * en format de liste.
     * 
     * @param array $announces
     * 
     * @return string
     */
    public function announcesSection(array $announces)
    {
        return <<<HTML
        {$this->announceFilter()}
        <div class="adds-wrapper">
            <div class="tab-content">
                {$this->gridView($announces)}
                {$this->listView($announces)}
            </div>
        </div>
HTML;
    }

    /**
     * Permet de filtrer les announces.
     * 
     * @return string
     * 
     * @return string
     */
    private function announceFilter()
    {
        return <<<HTML
        <div class="product-filter">
            {$this->changeViewButton()}
        </div>
HTML;
    }

    /**
     * Affichage sous forme de grille.
     * 
     * @return string
     */
    private function gridView(array $announces)
    { 
        $content = null;

        if (empty($announces)) {
            $content = self::noAnnounces();
        } else {
            foreach ($announces as $announce) {
                $content .= (new self($announce))->gridFormat();
            }
        }

        return <<<HTML
        <div id="grid-view" class="tab-pane fade">
            <div class="row">
                {$content}
            </div>
        </div>
HTML;
    }

    /**
     * Affichage sous forme de liste.
     * 
     * @return string
     */
    private function listView(array $announces)
    {
        $content = null;

        if (empty($announces)) {
            $content = self::noAnnounces();
        } else {
            foreach ($announces as $announce) {
                $content .= (new self($announce))->listFormat();
            }
        }

        return <<<HTML
        <div id="list-view" class="tab-pane fade active show">
            <div class="row">
                {$content}
            </div>
        </div>
HTML;
    }

    /**
     * Permet d'afficher les informations sur le nombre d'annonce affichée
     * appartenant à cette catégorie.
     * 
     * @param \App\Model\Category $category
     * 
     * @return string
     */
    private function announceFilterShortName($category)
    {
        return <<<HTML
        <div class="short-name">
            <span>Annonces (1 - 12 sur {$category->getAnnouncesNumber()})</span>
        </div>
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
     * La carte qui s'affiche dans la section premium.
     * 
     * @return string
     */
    public function premiumCard()
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
            </div>
        </div>
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
                <img class="img-fluid" src="{$this->announce->getArtInFooterImgSrc()}" alt="Photo de {$this->announce->getTitle()}">
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
        <div class="product-info row pb-4">
            <!-- Images Section -->
            {$this->productInfosImgSection()}
            <!-- Title and others informations section -->
            {$this->detailsBox()}
        </div>
HTML;
    }

    /**
     * Permet d'afficher l'image de couverture de l'annonce dans les cartes.
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
     * Affiche le contenu sur les cartes premium.
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
                    <a href="users/{$this->announce->getOwner()->getPseudo()}/posts"><i class="lni-user"></i> {$this->announce->getOwner()->getFullName()}</a>
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
        <section class="mb-4">
            <h5 class="mb-2">Specifications :</h4>
            <ul class="list-specification">
                <li><i class="lni-check-mark-circle"></i> Statut : {$this->announce->getStatus("fr")}</li>
                <li><i class="lni-check-mark-circle"></i> Sens : {$this->announce->getDirection()}</li>
                <li><i class="lni-check-mark-circle"></i> Type : {$this->announce->getType()}</li>
            </ul>
        </section>
        
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
                        <p><strong><i class="lni-folder"></i></strong> <a href="{$this->announce->getCategory()->getSlug()}">{$this->announce->getCategory()->getTitle()}</a></p>
                    </li>
                    <li>
                        <p><a href="/users/{$this->announce->getOwner()->getPseudo()}/posts"><i class="lni-users"></i> Plus d'annonces de <span>{$this->announce->getOwner()->getName()}</span></a></p>
                    </li>
                </ul>
                {$this->specifications()}
                {$this->infosForJoinUser()}
                {$this->shareMe()}
                {$this->showComments()}
                {$this->putComments()}
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
        return SocialNetwork::shareThis();
    }

    /**
     * Les champs pour entrer les détails de l'annonce lors de sa création.
     * 
     * @return string
     */
    private function enterAnnounceDetails()
    {
        $categoryView = new CategoryView();
        $userView = new UserView();

        $title = null;
        if(isset($_POST["title"]) && !empty($_POST["title"])) {
            $title = $_POST["title"];
        } elseif (null !== $this->announce) {
            $title = $this->announce->getTitle();
        }

        $description = null;
        if(isset($_POST["description"]) && !empty($_POST["description"])) {
            $description = $_POST["description"];
        } elseif (null !== $this->announce) {
            $description = $this->announce->getDescription();
        }

        $price = null;
        if(isset($_POST["price"]) && !empty($_POST["price"])) {
            $price = $_POST["price"];
        } elseif (null !== $this->announce) {
            $price = $this->announce->getPrice(false);
        }

        $checkedPriceOnCall = (isset($_POST["price_on_call"]) || (isset($this->announce) && $this->announce->getPrice() === "Prix à l'appel"))
            ? "checked" : null;

        return <<<HTML
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
            <div class="inner-box">
                <div class="dashboard-box">
                    <h2 class="dashbord-title">Détails de l'annonce</h2>
                </div>
                <div class="dashboard-wrapper">
                    <div class="form-group mb-3">
                        <label class="control-label">Titre</label>
                        <input class="form-control input-md" name="title" placeholder="Entrer le titre" type="text" value="{$title}" required>
                    </div>
                    <div class="form-group mb-3 tg-inputwithicon">
                        <label class="control-label">Catégories</label>
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
                        <label class="control-label">Ville</label>
                        <div class="tg-select form-control">
                            {$userView->townsSelectList("location")}
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div id="enter_price_box">
                            <label class="control-label">Prix</label>
                            <input class="form-control input-md" name="price" placeholder="Ajouter le prix (F CFA)" value="{$price}" type="number">
                        </div>
                        <div class="tg-checkbox mt-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="price_on_call" id="tg-priceoncall" {$checkedPriceOnCall}>
                                <label class="custom-control-label" for="tg-priceoncall">Me contacter pour avoir le prix</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <section id="editor">
                            <textarea name="description" id="summernote">{$description}</textarea>
                        </section>
                    </div>
                    <label class="tg-fileuploadlabel" for="tg-photogallery">
                        <span>Glissez votre fichier pour le charger</span>
                        <span>Ou</span>
                        <span class="btn btn-common">Cliquez et séléctionner 3 images</span>
                        <span>Taille maximum d'une image : 2 MB</span>
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
        $userToJoin = null;
        $phoneNumber = null;

        if(isset($_POST["user_to_join"]) && !empty($_POST["user_to_join"])) {
            $userToJoin = $_POST["user_to_join"];
        } elseif (null !== $this->announce) {
            $userToJoin = $this->announce->getUserToJoin();
        }

        if(isset($_POST["phone_number"]) && !empty($_POST["phone_number"])) {
            $phoneNumber = $_POST["phone_number"];
        } elseif (null !== $this->announce) {
            $phoneNumber = $this->announce->getPhoneNumber();
        }

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
                                    <input id="tg-sameuser" type="radio" name="usertype" value="current_user">
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
                                <label class="control-label">Adresse email</label>
                                <input class="form-control input-md" name="user_to_join" type="email" value={$userToJoin}>
                            </div>
                            <div class="form-group mb-3">
                                <label class="control-label">Téléphone</label>
                                <input class="form-control input-md" name="phone_number" type="text" placeholder="+XXX XXXXXXXXXX" value="{$phoneNumber}">
                            </div>
                        </div>
                        <button class="btn btn-common" type="submit">Envoyer</button>
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
     * Permet de choisir la direction de l'offre, demande ou offre.
     * @return string
     */
    private function chooseDirection()
    {
        $checkOffer = null;
        $checkAsking = null;

        if (isset($_POST["direction"])
        ) {
            if ($_POST["direction"] == "offre") {
                $checkOffer = "checked";
            } elseif ($_POST["direction"] == "demande") {
                $checkAsking = "checked";
            }
        } elseif ($this->announce) {
            $checkOffer = strtolower($this->announce->getDirection()) === "offre" ? "checked" : null;
            $checkAsking = strtolower($this->announce->getDirection()) === "demande" ? "checked" : null;
        }

        return <<<HTML
        <div class="form-group mb-3">
            <strong>Sens :</strong>
            <div class="tg-selectgroup">
                <span class="tg-radio">
                    <input id="tg-offre" type="radio" name="direction" value="offre" $checkOffer>
                    <label for="tg-offre">Offre</label>
                </span>
                <span class="tg-radio">
                    <input id="tg-demande" type="radio" name="direction" value="demande" $checkAsking>
                    <label for="tg-demande">Demande</label>
                </span>
            </div>
        </div>
HTML;
    }

    /**
     * Permet de choisir le type d'annonce.
     * @return string
     */
    private function chooseType()
    {
        $checkParticular = null;
        $checkPro = null;

        if (isset($_POST["type"])) {
            if ($_POST["type"] == "particulier") {
                $checkParticular = "checked";
            } elseif ($_POST["type"] == "professionnel") {
                $checkPro = "checked";
            }
        } elseif ($this->announce) {
            $checkParticular = strtolower($this->announce->getType()) === "particulier" ? "checked" : null;
            $checkPro = strtolower($this->announce->getType()) === "professionnel" ? "checked" : null;
        }

        return <<<HTML
        <div class="form-group mb-3">
            <strong>Type :</strong>
            <div class="tg-selectgroup">
                <span class="tg-radio">
                    <input id="tg-particular" type="radio" name="type" value="particulier" $checkParticular>
                    <label for="tg-particular">Particulier</label>
                </span>
                <span class="tg-radio">
                    <input id="tg-professionnal" type="radio" name="type" value="professionnel" $checkPro>
                    <label for="tg-professionnal">Professionnel</label>
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
        }
        
        // elseif ($this->announce->getStatus() == "Premium") {
        //     $statusClass = "adstatusexpired";
        //     $statusText = "Premium";
        // }
        
        else {
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
                <section class="d-flex justify-content-center">
                    <p class="h5 text-muted text-center">Aucunes annonces</p>
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
        if (User::isAuthenticated() && ($this->announce->getOwner()->getEmailAddress() === User::authenticated()->getEmailAddress() || User::authenticated()->isAdministrator())) {
            
            return <<<HTML
            <nav class="mb-3">
                {$this->editButton()}
                {$this->validateButton()}
                <!-- {$this->setPremiumButton()} -->
                {$this->suspendButton()}
                {$this->deleteButton()}
            </nav>
HTML;
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
        if (User::isAuthenticated()) {

            if ($this->announce->getOwner()->getEmailAddress() === User::authenticated()->getEmailAddress()
                || User::authenticated()->isAdministrator()
            ) {
                return CommentView::showAll($this->announce->getComments());
            }
        }
    }

    /**
     * Permet de laisser des commentaires(suggestions) sur l'annonce.
     * @return string
     */
    private function putComments()
    {
        if (User::isAuthenticated() && User::authenticated()->isAdministrator()) {
            $form = new Form($_SERVER["REQUEST_URI"] . "/comment", "mt-3");

            return <<<HTML
            {$form->open()}
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                    <div class="form-group">
                        <textarea id="comment" class="form-control" name="comment" cols="45" rows="5" placeholder="Laisser une suggestion..." required></textarea>
                    </div>
                    <button type="submit" id="submit" class="btn btn-common">Envoyer</button>
                    </div>
                </div>
            {$form->close()}
HTML;
        }
    }

    /**
     * Affiche un bouton pour editer l'annonce.
     * @return string
     */
    private function editButton()
    {
        if (User::isAuthenticated() && $this->announce->getOwner()->getEmailAddress() === User::authenticated()->getEmailAddress()) {
            return <<<HTML
            <a href="{$this->announce->getManageLink('update')}" class="btn-sm btn-primary">Editer</a>
HTML;
        }
    }

    /**
     * Affiche le bouton pour valider l'annonce.
     * @return string
     */
    private function validateButton()
    {
        if (User::isAuthenticated() && User::authenticated()->isAdministrator() && !$this->announce->isValidated()) {
            return <<<HTML
            <a href="{$this->announce->getManageLink('validate')}" class="btn-sm btn-success">Valider</a>
HTML;
        }
    }

    /**
     * Affiche le bouton pour passer l'annonce en premium.
     * @return string
     */
    private function setPremiumButton()
    {
//         if (User::isAuthenticated() && User::authenticated()->isAdministrator()) {
//             return <<<HTML
//             <a href="{$this->announce->getManageLink('set-premium')}" class="btn-sm btn-success">Passer en Prémium</a>
// HTML;
//         }
    }

    /**
     * Affiche le bouton qui permet de suspendre l'annonce.
     * @return string
     */
    private function suspendButton()
    {
        if (User::isAuthenticated() && User::authenticated()->isAdministrator()) {
            return <<<HTML
            <a href="{$this->announce->getManageLink('suspend')}" class="btn-sm btn-warning">Suspendre</a>
HTML;
        }
    }
    
    /**
     * Affiche le bouton pour supprimer l'annonce sur la page qui affiche
     * l'annonce.
     * @return string
     */
    private function deleteButton()
    {
        if (User::isAuthenticated()
            && ($this->announce->getOwner()->getEmailAddress() === User::authenticated()->getEmailAddress() || User::authenticated()->isAdministrator())
        ) {
            return <<<HTML
            <a class="btn-sm btn-danger" href="{$this->announce->getManageLink('delete')}">Supprimer</a>
HTML;
        }
    }

    /**
     * Bouton qui permet de changer l'affichage des annonces.
     * 
     * @return string
     */
    private function changeViewButton()
    {
        return <<<HTML
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#grid-view"><i class="lni-grid"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#list-view"><i class="lni-list"></i></a>
            </li>
        </ul>
HTML;
    }

}