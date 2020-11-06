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

    public function index()
    {
        $page = new Page("Le leader des petites annonces en Côte d'Ivoire", $this->view->index());
        $page->show("public");
    }

    public function pageNotFound()
    {
        $page = new Page("Le leader des petites annonces en Côte d'Ivoire", $this->view->pageNotFound());
        $page->show("public");
    }
}