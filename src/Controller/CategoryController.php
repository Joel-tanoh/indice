<?php

namespace App\Controller;

use App\Action\InsertData;
use App\Exception\PageNotFoundException;
use App\Model\Category;
use App\Model\Model;
use App\View\Model\CategoryView;
use App\View\Page\Page;

/**
 * Controller des catégories.
 */
class CategoryController extends AppController
{
    static function read(array $url = null)
    {
        $page = new Page("Titre de la catégorie", (new CategoryView())->read());
        $page->show();

        // if (Category::isCategorySlug($url[0])) {
        //     $category = Model::getBySlug($url[0], Category::TABLE_NAME);
        //     $page = new Page("Titre de la catégorie", (new CategoryView($category))->read());
        //     $page->setDescription($category->getDescription());
        //     $page->show();
        // } else {
        //     throw new PageNotFoundException("La catégorie que vous cherchez n'a pas été trouvée.");
        // }
    }

    /**
     * Controlleur de création d'une catégorie.
     */
    static function create()
    {
        $page = new Page("Créer une annonce", CategoryView::create());
        $page->setDescription("");
        $page->show();
    }
}