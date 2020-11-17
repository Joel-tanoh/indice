<?php

namespace App\Controller;

use App\View\Model\AnnounceView;
use App\View\Page\Page;

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