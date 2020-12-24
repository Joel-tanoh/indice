<?php

/**
 *  Fichier de routage de l'application.
 */

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";

use App\Route\Router;
use App\View\Page\Page;
use App\View\View;

try {
    
    $router = new Router();
    $router->get("/", "App\Controller\AppController@index");
    $router->get("/in-progress", "App\Controller\AppController@page404");
    $router->get("/connexion", "App\Controller\UserController@connexion");
    $router->get("/post", "App\Controller\AnnounceController@create");
    $router->get("/category", "App\Controller\CategoryController@read");
    $router->get("/:category", "App\Controller\CategoryController@read");
    $router->get("/category/annonce", "App\Controller\AnnounceController@read");
    $router->get("/:category/:slug", "App\Controller\AnnounceController@read");

    $router->run();

} catch(Exception $e) {
    $page = new Page("Le leader des petites annonces en Côte d'Ivoire", View::exception($e));
    $page->show();
}