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

    /**
     * Controller pour afficher les détails d'une annonce.
     * 
     * @param array $url C'est le tableau qui contient l'url découpée.
     *                   La partie de ce tableau nous interressant est
     *                   l'index 1
     * 
     * @return void
     */
    static function read(array $url = null)
    {
        $page = new Page("Titre de l'annonce", (new AnnounceView())->read());
        $page->show();
    }
}