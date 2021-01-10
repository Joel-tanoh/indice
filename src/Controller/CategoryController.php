<?php

namespace App\Controller;

use App\Exception\PageNotFoundException;
use App\Model\Category;
use App\View\Model\CategoryView;
use App\View\Page\Page;

/**
 * Controller des catégories.
 */
class CategoryController extends AppController
{
    /**
     * Controlleur de création d'une catégorie.
     */
    static function create()
    {
        $page = new Page("Créer une annonce", CategoryView::create());
        $page->setDescription("");
        $page->show();
    }

    /**
     * Controller pour le read d'une catégorie.
     */
    static function read(array $url = null)
    {
        if (Category::isCategorySlug($url[0])) {
            $category = Category::getBySlug($url[0], Category::TABLE_NAME, "App\Model\Category");
            $page = new Page("L'indice - " . $category->getTitle(), (new CategoryView($category))->read());
            $page->setDescription($category->getDescription());
            $page->show();
        } else {
            throw new PageNotFoundException("La catégorie que vous cherchez n'a pas été trouvée.");
        }
    }

    /**
     * Controller de mise à jour d'une catégorie.
     */
    public function update()
    {

    }

    /**
     * Controlleur de suppression
     */
    public function delete()
    {

    }

}