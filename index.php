<?php

/**
 *  Fichier de routage de l'application.
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";

use App\Route\Router;
use App\View\Page\Page;
use App\View\View;

try {
    
    $router = new Router();
    $router->get("/", "App\Controller\AppController@index");
    $router->get("/connexion", "App\Controller\UserController@connexion");
    $router->get("/creer-un-compte", "App\Controller\UserController@create");
    $router->get("/creer-une-categorie", "App\Controller\CategoryController@create");
    $router->get("/creer-une-annonce", "App\Controller\AnnounceController@create");
    $router->get("/:category", "App\Controller\CategoryController@read");
    $router->get("/:category/:sub_category", "App\Controller\SubCategoryController@read");
    $router->get("/:category/:sub_category/:slug", "App\Controller\AnnounceController@read");

    $router->run();

} catch(Exception $e) {
    $page = new Page("Le leader des petites annonces en Côte d'Ivoire", View::exception($e));
    $page->show();
}