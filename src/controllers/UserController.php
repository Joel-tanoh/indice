<?php

namespace App\controllers;

use App\views\models\users\UserView;
use App\views\pages\Page;

class UserController extends AppController
{
    private $view;

    public function __construct()
    {
        $this->view = new UserView();
    }

    /**
     * Le controller pour la connexion d'un utilisateur.
     */
    public static function userConnexion()
    {
        $page = new Page("Connexion", UserView::userConnexion());
        $page->setDescription("");
        $page->show();
    }

    /**
     * Controller pour la création d'un compte user.
     */
    public static function createAccount()
    {
        $page = new Page("Connexion", UserView::createAccount());
        $page->setDescription("");
        $page->show();
    }
}