<?php

namespace App\views\models;

/**
 * Classe de gestion des vues de la partie catégorie.
 */
class CategoryView extends ModelView
{
    protected $category;

    /**
     * Constructeur de la vue des catégories.
     * 
     * @param \App\Models\Category $category
     */
    public function __construct(\App\Models\Category $category)
    {
        $this->category = $category;
    }

    /**
     * La vue qui liste les annonces appartenant à cette catégorie.
     * 
     * @return string
     */
    public function read()
    {
        echo "Vue pour lire cette catégorie : " . $this->category->getTitle();
    }
}