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
     * @param string $avatar_src
     * @param string $alt_information
     * 
     * @return string
     */
    public function showAvatar(string $avatar_src, string $alt_information = null)
    {
        return <<<HTML
        <div>
            <img src="{$avatar_src}" alt="{$alt_information}" class="user-avatar img-fluid"/>
        </div>
HTML;
    }

    /**
     * Affiche la vidéo de description de l'instance passé en paramètre.
     * 
     * @param string $youtubeVideoLink L'identifiant de la vidéos sur Youtube.
     * 
     * @return string
     */
    public function showVideo(string $youtubeVideoLink = null)
    {
        if (null == $youtubeVideoLink || $youtubeVideoLink == "") {
            $result = $this->noVideoBox();
        } else {
            $result = $this->youtubeIframe($youtubeVideoLink);
        }

        return $result;
    }

    /**
     * Retourne un listItemsContentHeader.
     * 
     * @param string $title
     * @param string $action 
     * @param mixed  $itemsNumber
     * @param bool   $contextMenu True si on veut un petit menu sur la droite
     * 
     * @return string
     */
    public function listItemsContentHeader(string $title = null, string $action = null, $itemsNumber = null, bool $contextMenu = false)
    {
        $title = ucfirst($title);

        if ($action) {
            $action = '<span class="d-inline-block h6 bg-primary text-white px-2 py-1 mr-2">' . $action . '</span>';
        }

        if ($contextMenu) {
            $contextMenu = $this->contextMenu();
        }

        return <<<HTML
        <div class="row mb-2">
            <div class="col-12">
                <div class="d-flex align-items-center bg-white p-2 rounded">
                    {$action}
                    <div class="d-flex align-items-center mr-2">
                        <h3 class="mr-2">{$title}</h3>
                        <div class="badge bg-primary text-white">{$itemsNumber}</div>
                    </div>
                    {$contextMenu}
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Retourne l'entête sur la page de lecture d'un item.
     * 
     * @param \App\Model\Items\ItemParent|\App\Model\Items\ItemChild $item
     * 
     * @return string
     */
    public function readItemContentHeader($item)
    {
//         $itemView = new ItemView($item);

//         return <<<HTML
//         <div class="row mb-3">
//             <div class="col-12">
//                 <div class="d-flex justify-content-between align-items-center bg-white px-3 py-2 rounded">
//                     {$itemView->showTitle()}
//                     {$this->manageButtons($item)}
//                 </div>
//             </div>
//         </div>
// HTML;
    }

    /**
     * Retourne les boutons pour publier, supprimer ou modifier l'instance.
     * 
     * @param \App\Model\Items\ItemParent|\App\Model\Items\ItemChild $item L'objet pour lequel on doit afficher le bouton.
     * 
     * @return string
     */
    public function manageButtons($item)
    {
        return <<<HTML
        <div class="d-flex">
            {$this->editButton($item)}
            {$this->itemVisibilityButton($item)}
            {$this->deleteButton($item)}
        </div>
HTML;
    }

    /**
     * Affiche le résumé des commandes de minis services. Les nouvelles commandes,
     * les commandes en attentes et toutes les commandes.
     * 
     * @return string
     */
    public function miniServicesCommandsResume()
    {
//         $newCommandsNbr = Order::getNumber("news"); // $database->count("code", Order::TABLE_NAME, "state", "news");
//         $newCommandsBoxInfo = Card::boxInfo($newCommandsNbr, "Nouvelles commandes", ADMIN_URL . "/mini-services/commands/new", "success");
        
//         $waitingCommandsNbr = Order::getNumber("wait"); // $database->count("code", Order::TABLE_NAME, "state", "en attente");
//         $waitingCommandsBoxInfo = Card::boxInfo($waitingCommandsNbr, "Commandes en attente", ADMIN_URL . "/mini-services/commands/waiting", "warning");
        
//         $allCommandsNbr = Order::getNumber("*"); // $database->count("code", Order::TABLE_NAME);
//         $allCommandsBoxInfo = Card::boxInfo($allCommandsNbr, "Commandes totales", ADMIN_URL . "/mini-services/commands/all", "primary");

//         return <<<HTML
//         <div class="row px-2">
//             {$newCommandsBoxInfo}
//             {$waitingCommandsBoxInfo}
//             {$allCommandsBoxInfo}
//         </div>
// HTML;
    }

    /**
     * Affiche les données.
     * 
     * @param \App\Model\Items\ItemParent|\App\Model\Items\ItemChild $item L'item dont on affiche les données.
     * 
     * @return string
     */
    public function showData($item)
    {
        return <<<HTML
        <div class="row mb-3">
            <div class="col-12">
                {$this->showVideo($item->getVideoLink("youtube"))}
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                {$this->showBddData($item)}
            </div>
            <div class="col-12 col-md-6">
                {$this->showThumbs($item)}
            </div>
        </div>
HTML;
    }

    /**
     * Retourne l'image de l'item passé en paramètre.
     * 
     * @param $item
     * 
     * @return string
     */
    public function showThumbs($item)
    {
        return null !== $item->getThumbsSrc() ? $this->thumbs($item) : $this->noThumbsBox();
    }

    /**
     * Retourne les boutons pour ajouter un nouvel élément ou supprimer des éléments
     * en fonction de la catégorie.
     * 
     * @return string
     */
    private function contextMenu()
    {
        return <<<HTML
HTML;
    }

    /**
     * Table qui permet de lister les éléménts.
     * 
     * @return string
     */
    public function listingTable($items)
    {
        $itemsList = null;
        foreach($items as $item) {
            $itemsList .= $this->listingItemsRow($item);
        }

        return <<<HTML
        <div class="row">
            <div class="col-12">
                <table class="table bg-white rounded">
                    <thead>
                        <th>
                            <label for="checkAllItems"><input type="checkbox" id="checkAllItems"> Tout cocher</label>
                        </th>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Date de création</th>
                    </thead>
                    <tbody>
                        {$this->listingItemsTableActionsRow()}
                        {$itemsList}
                        {$this->listingItemsTableActionsRow()}
                    </tbody>
                    <tfoot>
                        <th><label for="checkAllItems">Tout cocher</label></th>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Date de création</th>
                    </tfoot>
                </table>
            </div>
        </div>
HTML;
    }

    /**
     * Retourne une vue qui affiche l'ensemble des données principales
     * pour l'item passé en paramètre.
     * 
     * @param \App\Model\Items\ItemParent|\App\Model\Items\ItemChild $item
     * 
     * @return string
     */
    public function showBddData($item)
    {
        return <<<HTML
HTML;
    }

    /**
     * Retourne un tableau sur la page de suppression d'items dans lequel les éléments sont
     * affichés par ligne afin de les supprimer.
     * 
     * @param mixed $items
     * @param string $categorie
     * 
     * @return string
     */
    public function deleteItemsTable($items, string $categorie)
    {
        $form = new Form("post", $_SERVER['REQUEST_URI'], true);
        $tableRows = null;
        $submitButton = $form->submit("suppression", "Supprimer");

        foreach($items as $item) {
            
        }

        return <<<HTML
        {$form->open()}
            <table class="table mb-3">
                <thead>
                    <th><input type="checkbox" id="checkAllItemsForDelete"></th><th>Titre</th>
                </thead>
                {$tableRows}
            </table>
            {$submitButton}
        </form>
HTML;
    }

    /**
     * Retourne une vue pour une barre de recherche.
     * 
     * @return string
     */
    public function searchBar()
    {
        $form = new Form("post", null, false, "search-form", "d-flex justify-content-between");

        return <<<HTML
        <div class="app-search-bar bg-white mx-3 mt-3 mb-2 pl-2">
            {$form->open()}
                {$form->input("search", "recherche", "rechercheInput", null, "Rechercher", "app-search-bar-input p-1")}
                <button type="submit" class="app-search-bar-button">
                    <i class="fas fa-search"></i>
                </button>
            {$form->close()}
        </div>
HTML;
    }

    /**
     * Retourne une checkbox pour activer les variables cookies. Si l'utilisateur
     * coche cette checkbox, les cookies sont activées.
     * 
     * @return string
     */
    public function activateSessionButton()
    {
        return <<<HTML
        <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" name="activate_cookie" id="customCheckbox1" value="oui">
            <label for="customCheckbox1" class="custom-control-label">Se souvenir de moi</label>
        </div>
HTML;
    }

    /**
     * Retourne une vue pour permmetre à l'utilisateur de se connecter
     * par les réseaux sociaux.
     * 
     * @return string
     */
    public function connectBySocialsNetworks()
    {
        return <<<HTML
        <div class="text-center text-muted h5">- OU -</div>
        <div>
            <div>{$this->connexionFormGoogleButton()}</div>
            <div>{$this->connexionFormFacebookButton()}</div>
        </div>
HTML;
    }

    /**
     * Bouton d'édition d'un item.
     * 
     * @param \App\Model\Items\ItemParent|\App\Model\Items\ItemChild $item L'objet pour lequel on doit afficher le bouton.
     * 
     * @return string
     */
    public function editButton($item)
    {
        return $this->button($item->getUrl("edit"), "Editer", "text-success mr-1", null, "fas fa-edit mr-1", "editButton");
    }

    /**
     * Bouton de publish ou de unpublish d'un item.
     * 
     * @param \App\Model\Items\ItemParent|\App\Model\Items\ItemChild $item L'objet pour lequel on doit afficher le bouton.
     * 
     * @return string
     */
    public function itemVisibilityButton($item)
    {
        if ($item->isPosted()) {
            return $this->button($item->getUrl("unpublish"), "Cacher", "text-warning mr-1", null, "fas fa-times mr-1", "unpostButton");
        } else {
            return $this->button($item->getUrl("publish"), "Publier", "text-warning mr-1", null, "fas fa-reply mr-1", "postButton");
        }
    }

    /**
     * Bouton de suppression d'un item.
     * 
     * @param \App\Model\Items\ItemParent|\App\Model\Items\ItemChild $item L'objet pour lequel on doit afficher le bouton.
     * 
     * @return string
     */
    public function deleteButton($item)
    {
        return $this->button($item->getUrl("delete"), "Supprimer", "text-danger", null, "fas fa-trash-alt", "deleteItemButton");
    }

    /**
     * Retourne un lien du contextMenu.
     * 
     * @param string $href 
     * @param string $caption 
     * @param string $btnClass 
     * @param string $captionClass
     * @param string $faIconClass
     *
     * @return string
     */
    public function button(string $href, string $caption = null, string $btnClass = null, string $captionClass = null, string $faIconClass = null, string $id = null)
    {
        if (null !== $faIconClass) {
            $faIconClass = '<i class="' . $faIconClass. '"></i>';
        }

        return <<<HTML
        <a class="d-flex align-items-center {$btnClass}" href="{$href}" id="{$id}">
            {$faIconClass} <span class="{$captionClass}">{$caption}</span>
        </a>
HTML;
    }

    /**
     * Ligne qui permet de faire des actions sur le tableau qiui liste les items.
     * 
     * @return string
     */
    public function listingItemsTableActionsRow()
    {
        return <<<HTML
        <tr>
            <td colspan="4">
                <span class="btn-sm btn-danger deleteItemsButton">
                    <i class="fas fa-trash"></i>
                </span> 
            </td>
        </tr>
HTML;
    }

    /**
     * Le bloc de code HTML qui permet d'afficher le nombre
     * de personnes en ligne.
     * 
     * @return string
     */
    public function showVisitorsOnlineNumber()
    {
        $visitorsOnline = null;

        return <<<HTML
        <div class="small-box text-small text-white bg-success rounded p-2">
            <div class="inner">
                <h3 id="visitorsOnlineNumber">{$visitorsOnline}</h3>
                <p>visiteur(s) en ligne</p>
            </div>
        </div>
HTML;
    }

    /**
     * Slider
     * 
     * @return string
     */
    public function slider()
    {
        $slide = Image::SLIDERS_DIR_URL . "/" . random_int(1, 1) . ".jpg";

        return <<<HTML
        <div id="slideBox" class="d-none d-md-block">
            <img id="slideImg" src="{$slide}" class="img-fluid">
            <div id="slideText">
                <h1 class="mb-4 text-white">Lorem, ipsum dolor.</h1>
                <div>
                    <span class="text-white p-3">Lorem ipsum dolor sit amet</span>
                    <a href="#formations" class="text-black">
                        <span class="bg-white px-4 py-3">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </a>
                </div>
            </div>
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
     * La barre de recherche qui s'affiche au début de la page.
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
     * Counter Area
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
     * Pricing Section.
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
     * Advertisement section.
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


    // METHODE PRIVEES //

    /**
     * Retourne le vue pour lire la vidéo issue de Youtube.
     * 
     * @param string $youtubeVideoLink
     * 
     * @return string
     */
    private function youtubeIframe(string $youtubeVideoLink)
    {
        return <<<HTML
        <iframe src="https://www.youtube.com/embed/{$youtubeVideoLink}" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen class="w-100 video" style="height:25rem"></iframe>
HTML;
    }

    /**
     * Retourne un bouton qui dirige vers la page pour se connecter grâce
     * à Facebook.
     * 
     * @return string Code du bouton.
     */
    private function connexionFormFacebookButton()
    {
        return <<<HTML
        <a href="" class="d-block text-center bg-facebook text-white rounded p-2">
            Se connecter avec Facebook
        </a>
HTML;
    }

    /**
     * Retourne un bouton qui dirige vers la page pour se connecter grâce
     * à Google.
     * 
     * @return string Code du bouton.
     */
    private function connexionFormGoogleButton()
    {
        return <<<HTML
        <a href="" class="d-block text-center bg-danger text-white rounded p-2">
            Se connecter avec Google
        </a>
HTML;
    }

    /**
     * Retourne l'image de couverture de l'item passé en paramètre.
     * 
     * @param $item
     * 
     * @return string
     */
    private function thumbs($item)
    {
        return <<<HTML
        <div>
            <div class="bg-white rounded px-3 py-2">Image de couverture</div>
            <div>
                <img src="{$item->getOriginalThumbsSrc()}" alt="{$item->getTitle()}" class="img-fluid"/>
            </div>
        </div>          
HTML;
    }

    /**
     * Retourne qu'il n'y pas d'image.
     * 
     * @return string
     */
    private function noThumbsBox()
    {
        return <<<HTML
        <div class="bg-white rounded px-3 py-2">
            Aucune image de couverture.
        </div>
HTML;
    }
   
    /**
     * Ce bloc est le bloc qui sera affiché si
     * l'instance concernée n'a pas de vidéo de description
     * 
     * @return string
     */
    private function noVideoBox()
    {
        return <<<HTML
        <div class="bg-white rounded px-3 py-2">
            Aucune vidéo de description.
        </div>
HTML;
    }

    /**
     * Retourne une ligne dans le tableau de suppression des éléments.
     * 
     * @param \App\Model\Items\ItemParent|\App\Model\Items\ItemChild $item
     * 
     * @return string
     */
    private function listingItemsRow($item)
    {
        return <<<HTML
        <tr>
            <td><input type="checkbox" name="codes[]" id="{$item->getSlug()}" value="{$item->getCode()}"></td>
            <td><label for="{$item->getSlug()}"> <a href="{$item->getUrl('administrate')}">{$item->getTitle()}</a></label></td>
            <td>
                <label for="{$item->getSlug()}">{$item->getDescription(50)}</label>
                {$this->manageButtons($item)}
            </td>
            <td><label for="{$item->getSlug()}">{$item->getCreatedAt()}</label></td>
        </tr>
HTML;
    }

    /**
     * Retourne une ligne dans le tableau de suppression des éléments.
     * 
     * @param $item
     * 
     * @return string
     */
    private function deleteItemsTableRow($item)
    {
        return <<<HTML
        <tr>
            <td><input type="checkbox" name="codes[]" id="{$item->getSlug()}" value="{$item->getCode()}"></td>
            <td><label for="{$item->getSlug()}">{$item->getTitle()}</label></td>
        </tr>
HTML;
    }

}