<?php

namespace App\Controller;

use App\Model\Announce;
use App\View\Model\User\AdministratorView;
use App\View\Page\Page;

abstract class AdministrationController extends UserController
{
    /**
     * Controller qui permet de gérer les annonces.
     */
    public static function announces(array $params = null)
    {
        if (empty($params)) {
            $announces = Announce::getAll();
        } else {
            $announces = [];
        }

        // dump($announces);
        // die();

        $page = new Page("L'indice | Administration - Gérer les annonces", AdministratorView::announces($announces));
        $page->show();
    }
}