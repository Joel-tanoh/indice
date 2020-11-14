<?php

/**
 *  Fichier de routage de l'application.
 */

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";

use App\Exceptions\PageNotFoundException;
use App\routes\Router;
use App\views\Pages\Page;
use App\views\View;

try {
    $router = new Router();
    $router->get("/", "App\controllers\AppController@index");
    $router->get("/connexion", "App\controllers\UserController@connexion");
    $router->get("/creer-un-compte", "App\controllers\UserController@create");
    $router->get("/creer-une-annonce", "App\controllers\AnnounceController@create");
    $router->get("/:category", "App\controllers\CategoryController@read");
    $router->get("/:category/:sub_category", "App\controllers\SubCategoryController@read");
    $router->get("/:category/:sub_category/:slug", "App\controllers\AnnounceController@read");

    $router->run();

} catch(Error|TypeError|Exception|PDOException|PageNotFoundException $e) {
    $page = new Page("Le leader des petites annonces en Côte d'Ivoire", View::exception($e));
    $page->show();
}