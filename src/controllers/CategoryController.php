<?php

namespace App\Controllers;

use App\Exceptions\PageNotFoundException;
use App\Models\Category;
use App\Models\Model;
use App\views\models\CategoryView;
use App\views\Pages\Page;

/**
 * Controller des catégories.
 */
class CategoryController extends AppController
{
    static function read(array $url)
    {
        if (Category::isCategorySlug($url[0])) {
            $category = Model::getBySlug($url[0], Category::TABLE_NAME);
            $page = new Page("Titre de la catégorie", (new CategoryView($category))->read());
            $page->setDescription($category->getDescription());
            $page->show();
        } else {
            throw new PageNotFoundException("La catégorie que vous cherchez n'a pas été trouvée.");
        }
    }
}