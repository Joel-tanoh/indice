<?php

namespace App\Controller;

use App\View\Page\Page;
use App\View\View;

class AppController
{
    public static function index()
    {
        $page = new Page("Le leader des petites annonces de Côte d'Ivoire", View::index());
        $page->show();
    }

}