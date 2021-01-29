<?php

namespace App\View\Model;

use App\Model\Announce;
use App\Model\Category;
use App\Utility\Pagination;
use App\View\AdvertisingView;
use App\View\Form;
use App\View\SearchView;
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

    /**
     * Vue de création d'une catégorie.
     */
    static function create()
    {
        return <<<HTML
        <p class="bg-secondary p-3 border rounded">
            Cette vue vous permettra de créer des catégories.
        </p>
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
        $advertising = new AdvertisingView();
        $announceView = new AnnounceView();

        return <<<HTML
        <!-- Hero Area -->
        {$snippet->heroArea2(false)} 
        <!-- Main container Start -->
        <div class="main-container section-padding">
            <div class="container-fluid">
                <!-- La barre de publicité en haut -->
                {$advertising->top()}
                <div class="row">
                    <aside class="d-none d-lg-block col-lg-2">
                        {$advertising->left()}
                    </aside>
                    <aside class="col-12 col-lg-8">
                        <section class="row">
                            <!-- Sidebar -->
                            {$this->sidebar()}
                            <!-- Content -->
                            {$announceView->list($this->category->getAnnounces("validated"))}
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
     * Affiche un bloc des catégories avec leurs icones.
     * Au survol, le bloc change de code.
     * 
     * @return string
     */
    public function trendingCategoriesSection()
    {
        $content = null;
        $colors = [
            "green", "yellow", "red", "app-blue",
            "purple", "gray", "orange", "blue"
        ];

        foreach (Category::getAll(Category::TABLE_NAME) as $category) {
            $content .= $this->trendingCategory(
                $category->getSlug(),
                $category->getIconClass(),
                $category->getTitle(),
                $colors[random_int(0, count($colors) - 1)]
            );
        }

        return <<<HTML
        <section class="categories-icon section-padding bg-drack">
            <aside class="container">
                <div class="row">
                    {$content}
                </div>
            </aside>
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
    private function trendingCategory(string $href = null, string $lniClass = null, string $text = null, string $color = "app-blue")
    {
        return <<<HTML
        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
            <a href="{$href}">
                <div class="icon-box {$color}">
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
     * Retourne la liste des catégories dans le formulaire pour 
     * la sélection lors de la création ou de la recherche d'une annonce.
     * 
     * @return string
     */
    public function selectOptions()
    {
        $options = null;

        foreach (Category::getAll(Category::TABLE_NAME) as $category) {
            $options .= '<option value="'. $category->getId() . '">' . $category->getTitle() . '</option>';
        }

        return $options;
    }

    /**
     * La sidebar de la page qui liste les annonces d'une catégorie.
     * 
     * @return string
     */
    public function sidebar()
    {
        $searchView = new SearchView();

        return <<<HTML
        <div class="col-lg-3 col-md-12 col-xs-12 page-sidebar">
            <aside>
                <!-- Search Widget -->
                {$searchView->categorySearchWidget()}
                <!-- Categories Widget -->
                {$this->categories()}
            </aside>
        </div>
HTML;
    }

    /**
     * La section qui liste les catégories et le nombre d'item à l'intérieur.
     * 
     * @return string
     */
    private function categories()
    {
        return <<<HTML
        <div class="widget categories">
            <h4 class="widget-title">Par catégories</h4>
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
        $content = null;

        foreach (Category::getAll(Category::TABLE_NAME) as $category) {
            $content .= $this->categoriesListRow(
                $category->getTitle(), $category->getSlug(), $category->getIconClass(), $category->getAnnouncesNumber("validated")
            );
        }
        
        return <<<HTML
        <ul class="categories-list">
            {$content}
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

}