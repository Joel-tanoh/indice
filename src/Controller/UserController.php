<?php

namespace App\Controller;

use App\View\Model\User\UserView;
use App\View\Page\Page;

class UserController extends AppController
{
    /**
     * Le controller pour la connexion d'un utilisateur.
     */
    public static function connexion()
    {
        $page = new Page("Connexion", UserView::userConnexion());
        $page->setDescription("");
        $page->show();
    }

    /**
     * Controller pour la création d'un compte user.
     */
    public static function create()
    {
        $page = new Page("Connexion", UserView::createAccount());
        $page->setDescription("");
        $page->show();
    }
}