<?php

namespace App\View\Model;

use App\Utility\Pagination;
use App\View\Snippet;

/**
 * Classe de gestion des vues de la partie catégorie.
 */
class CategoryView extends ModelView
{
    protected $category;

    /**
     * Constructeur de la vue des catégories.
     * 
     * @param \App\Model\Category $category
     */
    public function __construct(\App\Model\Category $category = null)
    {
        $this->category = $category;
    }

    static function create()
    {
        return <<<HTML
        vue de création d'une catégorie.
HTML;
    }

    /**
     * Affiche un bloc des catégories avec leurs icones.
     * Au survol, le bloc change de code.
     * 
     * @return string
     */
    public function trendingCategoriesSection()
    {
        return <<<HTML
        <section class="categories-icon section-padding bg-drack">
            <div class="container">
                <div class="row">
                    {$this->trendingCategory(null, "lni-car", "Titre de catégorie")}
                    {$this->trendingCategory(null, "lni-display", "Titre de catégorie")}
                    {$this->trendingCategory(null, "lni-mobile", "Titre de catégorie")}
                    {$this->trendingCategory(null, "lni-leaf", "Titre de catégorie")}
                    {$this->trendingCategory(null, "lni-tshirt", "Titre de catégorie")}
                    {$this->trendingCategory(null, "lni-briefcase", "Titre de catégorie")}
                    {$this->trendingCategory(null, "lni-home", "Titre de catégorie")}
                    {$this->trendingCategory(null, "lni-tshirt", "Titre de catégorie")}
                    {$this->trendingCategory(null, "lni-home", "Titre de catégorie")}
                    {$this->trendingCategory(null, "lni-home", "Titre de catégorie")}
                    {$this->trendingCategory(null, "lni-briefcase", "Titre de catégorie")}
                    {$this->trendingCategory(null, "lni-home", "Titre de catégorie")}
                </div>
            </div>
        </section>
HTML;
    }

    /**
     * Un trend.
     * 
     * @param string $href
     * @param string $lniClass
     * @param string $text
     * 
     * @return string
     */
    private function trendingCategory(string $href = null, string $lniClass = null, string $text = null)
    {
        return <<<HTML
        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
            <a href="category">
                <div class="icon-box">
                    <div class="icon">
                        <i class="{$lniClass}"></i>
                    </div>
                    <h4>{$text}</h4>
                </div>
            </a>
        </div>
HTML;
    }

    /**
     * Permet d'afficher toutes les annonces appartenant à la catégorie concernée.
     * 
     * @return string
     */
    public function read()
    {
        $snippet = new Snippet();

        return <<<HTML
        <!-- Hero Area -->
        {$snippet->heroArea2(false)}
        <!-- Hero Area End -->

        <!-- Main container Start -->  
        <div class="main-container section-padding">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    {$this->sidebar()}
                    <!-- Content -->
                    {$this->content()}
                </div>
            </div>
        </div>
        <!-- Main container End -->  
HTML;
    }

    /**
     * La sidebar de la page qui liste les annonces d'une catégorie.
     * 
     * @return string
     */
    private function sidebar()
    {
        $snippet = new Snippet();

        return <<<HTML
        <div class="col-lg-3 col-md-12 col-xs-12 page-sidebar">
            <aside>
                <!-- Search Widget -->
                {$this->searchWidget()}
                <!-- Categories Widget -->
                {$this->categoriesWidget()}
                <!-- Advertisement Section -->
                {$snippet->advertisementSection()}
            </aside>
        </div>
HTML;
    }

    /**
     * Le contenu de la page.
     * 
     * @return string
     */
    private function content()
    {
        $pagination = new Pagination();

        return <<<HTML
        <div class="col-lg-9 col-md-12 col-xs-12 page-content">
            <!-- Product filter Start -->
            {$this->announceFilter()}
            <!-- Product filter End -->

            <!-- Adds wrapper Start -->
            {$this->announcesSection()}
            <!-- Adds wrapper End -->
    
            <!-- Start Pagination -->
            {$pagination->paginationBar()}
            <!-- End Pagination -->
            
        </div>
HTML;
    }

    /**
     * La barre de recherche dans la sidebar.
     * 
     * @return string
     */
    private function searchWidget()
    {
        return <<<HTML
        <div class="widget_search">
            <form role="search" id="search-form">
                <input type="search" class="form-control" autocomplete="off" name="s" placeholder="Search..." id="search-input" value="">
                <button type="submit" id="search-submit" class="search-btn"><i class="lni-search"></i></button>
            </form>
        </div>
HTML;
    }

    /**
     * La section qui liste les catégories et le nombre d'item à l'intérieur.
     * 
     * @return string
     */
    private function categoriesWidget()
    {
        return <<<HTML
        <div class="widget categories">
            <h4 class="widget-title">All Categories</h4>
            {$this->categoriesList()}
        </div>
HTML;
    }

    /**
     * Liste des catégories dans la sidebar de la page des catégories.
     * 
     * @return string
     */
    private function categoriesList()
    {
        return <<<HTML
        <ul class="categories-list">
            {$this->categoriesListRow("Titre de l'annonce", null, "lni-dinner", 5)}
            {$this->categoriesListRow("Titre de l'annonce", null, "lni-control-panel", 8)}
            {$this->categoriesListRow("Titre de l'annonce", null, "lni-github", 2)}
            {$this->categoriesListRow("Titre de l'annonce", null, "lni-coffee-cup", 3)}
            {$this->categoriesListRow("Titre de l'annonce", null, "lni-home", 4)}
            {$this->categoriesListRow("Titre de l'annonce", null, "lni-pencil", 5)}
            {$this->categoriesListRow("Titre de l'annonce", null, "lni-display", 9)}
        </ul>
HTML;
    }

    /**
     * Categories Sidebar Row.
     * 
     * @return string
     */
    private function categoriesListRow(string $title, string $href = null, string $lniClass = null, int $nbr = null)
    {
        return <<<HTML
        <li>
            <a href="{$href}">
                <i class="{$lniClass}"></i>
                {$title} <span class="category-counter">({$nbr})</span>
            </a>
        </li>
HTML;
    }

    /**
     * Product filter.
     * 
     * @return string
     */
    private function announceFilter()
    {
        return <<<HTML
        <div class="product-filter">
            {$this->announceFilterShortName()}
            {$this->changeViewButton()}
        </div>
HTML;
    }

    /**
     * La section qui affiche les annonces de la catégorie.
     * 
     * @return string
     */
    public function announcesSection()
    {
        return <<<HTML
        <div class="adds-wrapper">
            <div class="tab-content">
                {$this->gridView()}
                {$this->listView()}
            </div>
        </div>
HTML;
    }

    /**
     * Affichage sous forme de grille.
     * 
     * @return string
     */
    private function gridView()
    {
        $annonceView = new AnnounceView();

        return <<<HTML
        <div id="grid-view" class="tab-pane fade">
            <div class="row">
                {$annonceView->gridFormat()}
                {$annonceView->gridFormat()}
                {$annonceView->gridFormat()}
            </div>
        </div>
HTML;
    }

    /**
     * Affichage sous forme de liste.
     * 
     * @return string
     */
    private function listView()
    {
        $annonceView = new AnnounceView();

        return <<<HTML
        <div id="list-view" class="tab-pane fade active show">
            <div class="row">
                {$annonceView->listFormat()}
                {$annonceView->listFormat()}
                {$annonceView->listFormat()}
            </div>
        </div>
HTML;
    }

    /**
     * @return string
     */
    private function announceFilterShortName()
    {
        return <<<HTML
        <div class="short-name">
            <span>Showing (1 - 12 products of 7371 products)</span>
        </div>
HTML;
    }

    private function woocommerceOrdering()
    {
        return <<<HTML
        <div class="Show-item">
            <span>Show Items</span>
            <form class="woocommerce-ordering" method="post">
                <label>
                    <select name="order" class="orderby">
                        <option selected="selected" value="menu-order">49 items</option>
                        <option value="popularity">popularity</option>
                        <option value="popularity">Average ration</option>
                        <option value="popularity">newness</option>
                        <option value="popularity">price</option>
                    </select>
                </label>
            </form>
        </div>
HTML;
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