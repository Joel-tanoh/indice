<?php

namespace App\Controller;

use App\Database\SqlQueryFormaterV2;
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

    public static function test() {
        $sqlFormater = new SqlQueryFormaterV2();

        $toto = 1;

        $query = $sqlFormater->select("id")
            ->from("bala")
            ->orderBy("created_at")
            ->where("id = $toto")
            ->between("age", 13, 45)
            ->between("price", 100, 120)
            ->returnQueryString();

        dump($query);
    }

}