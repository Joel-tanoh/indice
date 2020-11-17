<?php

namespace App\View\Model;

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
    public function __construct(\App\Model\Category $category)
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