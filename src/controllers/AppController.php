<?php

namespace App\controllers;

use App\views\Pages\Page;
use App\views\View;

class AppController
{
    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public static function index()
    {
        $page = new Page("Le leader des petites annonces en Côte d'Ivoire", View::index());
        $page->show("public");
    }

    public static function pageNotFound()
    {
        $page = new Page("Le leader des petites annonces en Côte d'Ivoire", View::pageNotFound());
        $page->show("public");
    }
}