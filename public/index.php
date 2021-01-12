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

    // Route en get sans paramètre
    $router->get("/", "App\Controller\AppController@index");
    // $router->get("/test", "App\Controller\UserController@test");
    $router->get("/register", "App\Controller\UserController@register");
    $router->get("/sign-in", "App\Controller\UserController@signIn");
    $router->get("/sign-out", "App\Controller\UserController@signOut");
    $router->get("/post", "App\Controller\AnnounceController@create");
    $router->get("/in-progress", "App\Controller\AppController@page404");
    $router->get("/users/my-profile", "App\Controller\UserController@profile");
    $router->get("/users/my-posts", "App\Controller\UserController@dashboard");
    $router->get("/:category", "App\Controller\CategoryController@read");
    $router->get("/:category/:slug", "App\Controller\AnnounceController@read");
    $router->get("/users/my-posts/:status", "App\Controller\UserController@dashboard");
    $router->get("/users/my-posts/manage/:slug", "App\Controller\AnnounceController@manage");

    // Routes en post
    $router->post("/register", "App\Controller\UserController@register");
    $router->post("/post", "App\Controller\AnnounceController@create");
    $router->post("/sign-in", "App\Controller\UserController@signIn");

    $router->run();

} catch(Exception $e) {
    $page = new Page("Le leader des petites annonces en Côte d'Ivoire", View::exception($e));
    $page->show();
}