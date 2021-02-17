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

    $router = new Router(trim($_SERVER["REQUEST_URI"], "/"));

    $router->get("/", "App\Controller\AppController@index");
    $router->get("/in-progress", "App\Controller\AppController@page404");
    $router->get("/annonces", "App\Controller\UserController\UserController@readAnnounces");
    $router->get("/about", "App\Controller\UserController\UserController@readAbout");

    $router->get("/register", "App\Controller\UserController\UserController@register");
    $router->post("/register", "App\Controller\UserController\UserController@register");

    $router->get("/sign-in", "App\Controller\UserController\RegisteredController@signIn");
    $router->post("/sign-in", "App\Controller\UserController\RegisteredController@signIn");
    $router->get("/sign-out", "App\Controller\UserController\RegisteredController@signOut");

    $router->get("/post", "App\Controller\UserController\RegisteredController@post");
    $router->post("/post", "App\Controller\UserController\RegisteredController@post");

    $router->get("/administration/users", "App\Controller\UserController\AdministratorController@readUsers");

    $router->get("/administration/annonces", "App\Controller\UserController\AdministratorController@readAnnounces");
    
    $router->post("/annonces/search", "App\Controller\UserController\UserController@searchAnnounce");
    $router->post("/newsletters/register", "App\Controller\UserController\UserController@registerToNewsletter");
    
    $router->get("/:category", "App\Controller\UserController\UserController@readCategory");
    $router->get("/:1/:2", "App\Controller\AppController@subRouter");
    $router->post("/:1/:2", "App\Controller\SearchController@subRouter");
    $router->get("/:1/:2/:3", "App\Controller\AppController@subRouter");
    $router->post("/:1/:2/:3", "App\Controller\AppController@subRouter");
    $router->get("/:1/:2/:3/:4", "App\Controller\UserController\RegisteredController@myDashboard");

    $router->run();

} catch(Exception $e) {
    $page = new Page("L'indice | Le leader des petites annonces en Côte d'Ivoire", View::page404($e, "404"));
    $page->show();
}