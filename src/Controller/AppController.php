<?php

namespace App\Controller;

use App\View\Page\Page;
use App\View\View;

class AppController
{
    /**
     * Index du site.
     */
    public static function index()
    {
        $page = new Page("Le leader des petites annonces de Côte d'Ivoire", View::index());
        $page->show();
    }

    /**
     * Cette page s'affiche pour les ressources pas encore développées.
     */
    public static function page404()
    {
        $page = new Page("Le leader des petites annonces de Côte d'Ivoire - En cours", View::page404("Page en cours de développement", "En cours"));
        $page->show();
    }

}