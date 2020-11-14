<?php

namespace App\controllers;

use App\views\Pages\Page;
use App\views\View;

class AppController
{
    public static function index()
    {
        $page = new Page("Le leader des petites annonces en Côte d'Ivoire", View::index());
        $page->show("public");
    }

}