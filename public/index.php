<?php

/**
 *  Fichier de routage de l'application.
 */

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";
require_once ROOT_PATH . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

use App\routes\Router;

try {

    $router = new Router(Router::RequestUri());

    echo "<pre>";
    var_dump($router);

} catch(Error|TypeError|Exception|PDOException $e) {
    $exception = 'Erreur : ' . $e->getMessage() . ', Fichier : ' . $e->getFile() . ', Ligne : ' . $e->getLine();
    echo $exception;
}