<?php

namespace App\controllers;

use App\views\models\AnnounceView;
use App\views\pages\Page;

class AnnounceController extends AppController
{
    public static function create()
    {
        $page = new Page("Publier une annonce", AnnounceView::create());
        $page->setDescription("");
        $page->show();
    }

    static function read(array $url)
    {

    }
}