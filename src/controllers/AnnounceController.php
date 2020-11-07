<?php

namespace App\controllers;

use App\views\models\AnnounceView;
use App\views\pages\Page;

class AnnounceController extends AppController
{
    private $view;

    public function __construct()
    {
        $this->view = new AnnounceView();
    }

    public static function createAnnounce()
    {
        $page = new Page("Créer une annonce", AnnounceView::createAnnounce());
        $page->setDescription("");
        $page->show();
    }

}