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
    
    $router = new Router(trim($_SERVER["REQUEST_URI"], "/"));

    // Route en get sans paramètre
    $router->get("/", "App\Controller\AppController@index");
    // $router->get("/test", "App\Controller\UserController@test");
    $router->get("/register", "App\Controller\UserController@register");
    $router->get("/sign-in", "App\Controller\UserController@signIn");
    $router->get("/sign-out", "App\Controller\UserController@signOut");
    $router->get("/post", "App\Controller\AnnounceController@create");
    $router->get("/in-progress", "App\Controller\AppController@page404");
    $router->get("/:category", "App\Controller\CategoryController@read");
    $router->get("/:1/:2", "App\Controller\AppController@switcher");
    $router->get("/:1/:2/:3", "App\Controller\AppController@switcher");
    $router->get("/:1/:2/:3/:4", "App\Controller\UserController@dashboard");

    // Routes en post
    $router->post("/register", "App\Controller\UserController@register");
    $router->post("/post", "App\Controller\AnnounceController@create");
    $router->post("/sign-in", "App\Controller\UserController@signIn");
    $router->post("/:1/:2/:3", "App\Controller\AppController@switcher");

    $router->run();

} catch(Exception $e) {
    $page = new Page("Le leader des petites annonces en Côte d'Ivoire", View::exception($e));
    $page->show();
}