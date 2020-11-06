<?php

/**
 *  Fichier de routage de l'application.
 */

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";

use App\routes\Router;
use App\controllers\AppController;

try {

    $cats = ["chips, Buffy, Globs, Cracs"];

    $router = new Router(Router::GETUrl());
    
    if ($router->matches("")) {
        (new AppController())->index();
    }

    else {
        (new AppController())->pageNotFound();
    }

} catch(Error|TypeError|Exception|PDOException $e) {
    $exception = 'Erreur : ' . $e->getMessage() . ', Fichier : ' . $e->getFile() . ', Ligne : ' . $e->getLine();
    echo $exception;
}