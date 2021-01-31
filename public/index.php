<?php

/**
 *  Fichier de routage de l'application.
 */

session_start();

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";

use App\Route\Router;
use App\Model\User\Visitor;
use App\View\Page\Page;
use App\View\View;

try {
    
    Visitor::manage();

    // dump($_SESSION);
    // dump($_COOKIE);
    // die();

    $router = new Router(trim($_SERVER["REQUEST_URI"], "/"));

    // Route en get sans paramètre
    $router->get("/", "App\Controller\AppController@index");
    $router->get("/register", "App\Controller\UserController@register");
    $router->get("/sign-in", "App\Controller\UserController@signIn");
    $router->get("/sign-out", "App\Controller\UserController@signOut");
    $router->get("/post", "App\Controller\AnnounceController@create");
    $router->get("/users", "App\Controller\UserController@users");
    $router->get("/in-progress", "App\Controller\AppController@page404");
    $router->get("/announces", "App\Controller\AnnounceController@announces");

    // Route en get avec paramètre
    $router->get("/:category", "App\Controller\CategoryController@read");
    $router->get("/:1/:2", "App\Controller\AppController@router");
    $router->get("/:1/:2/:3", "App\Controller\AppController@router");
    $router->get("/:1/:2/:3/:4", "App\Controller\UserController@dashboard");

    // Routes en post
    $router->post("/register", "App\Controller\UserController@register");
    $router->post("/post", "App\Controller\AnnounceController@create");
    $router->post("/sign-in", "App\Controller\UserController@signIn");
    $router->post("/announces/search", "App\Controller\SearchController@searchAnnonce");
    $router->post("/newsletters/register", "App\Controller\NewsletterController@register");
    $router->post("/:1/:2", "App\Controller\SearchController@router");
    $router->post("/:1/:2/:3", "App\Controller\AppController@router");

    $router->run();

} catch(Exception $e) {
    $page = new Page("L'indice | Le leader des petites annonces en Côte d'Ivoire", View::page404($e, "404"));
    $page->show();
}