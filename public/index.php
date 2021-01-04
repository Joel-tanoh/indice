<?php

/**
 *  Fichier de routage de l'application.
 */

session_start();

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";

use App\Route\Router;
use App\View\Page\Page;
use App\View\View;

try {
    
    $router = new Router();
    $router->get("/", "App\Controller\AppController@index");
    $router->get("/suscribe", "App\Controller\UserController@suscribe");
    $router->get("/connexion", "App\Controller\UserController@connexion");
    $router->get("/disconnexion", "App\Controller\UserController@disconnexion");
    $router->get("/post", "App\Controller\AnnounceController@create");
    $router->get("/user/dashboard", "App\Controller\UserController@dashboard");
    $router->get("/in-progress", "App\Controller\AppController@page404");
    
    $router->get("/:category", "App\Controller\CategoryController@read");
    $router->get("/:category/:slug", "App\Controller\AnnounceController@read");

    $router->post("/suscribe", "App\Controller\UserController@suscribe");
    $router->post("/post", "App\Controller\AnnounceController@create");
    $router->post("/connexion", "App\Controller\UserController@connexion");

    $router->run();

} catch(Exception $e) {
    $page = new Page("Le leader des petites annonces en Côte d'Ivoire", View::exception($e));
    $page->show();
}