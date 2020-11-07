<?php

/**
 *  Fichier de routage de l'application.
 */

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";

use App\routes\Router;
use App\controllers\AppController;
use App\views\Pages\Page;
use App\views\View;

try {

    $router = new Router(Router::GETUrl());
    
    if ($router->matches("")) {
        AppController::index();
    }

    elseif ($router->matches("connexion")) {
        App\controllers\UserController::userConnexion();
    }

    elseif ($router->matches("creer-un-compte")) {
        App\controllers\UserController::createAccount();
    }

    elseif ($router->matches("creer-une-annonce")) {
        App\controllers\AnnounceController::createAnnounce();
    }

    else {
        (new AppController())->pageNotFound();
    }

} catch(Error|TypeError|Exception|PDOException $e) {
    $page = new Page("Le leader des petites annonces en Côte d'Ivoire", View::exception($e));
    $page->show();
}