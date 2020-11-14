<?php

namespace App\controllers;

use App\views\models\users\UserView;
use App\views\pages\Page;

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