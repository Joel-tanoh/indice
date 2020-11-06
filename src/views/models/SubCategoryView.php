<?php

namespace App\Views\Models;

use App\views\models\CategoryView;

/**
 * Classe de gestion des vues des sous-catégories.
 */
class SubCategory extends CategoryView
{
    protected $subCategory;

    public function __construct(\App\Models\SubCategory $subCategory)
    {
        $this->subCategory = $subCategory;
    }
}