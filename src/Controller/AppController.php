<?php

namespace App\Controller;

use App\Model\Announce;
use App\Model\Category;
use App\Model\Model;
use App\Model\User\User;
use App\View\Page\Page;
use App\View\View;
use Exception;

class AppController
{
    protected static $actions = [
        "create"
        , "read"
        , "update"
        , "delete"
        , "show"
        , "view"
        , "validate"
        , "set-premium"
        , "suspend"
        , "block"
        , "comment"
    ];


    /** Index du site. */
    public static function index()
    {
        $page = new Page("L'indice | Le leader des petites annonces de Côte d'Ivoire", View::index());
        $page->show();
    }

    /**
     * Cette page s'affiche pour les ressources pas encore développées.
     */
    public static function page404()
    {
        $page = new Page("L'indice | Le leader des petites annonces de Côte d'Ivoire", View::page404("Page en cours de développement", "En cours"));
        $page->show();
    }

    /**
     * Pour gérer les tests.
     */
    public static function test() {
        echo 'Test';
    }

    /**
     * Une couche qui permet de gérer le routage vers le bon controller
     * lorsqu'il le faut.
     * 
     * @param array $params La liste des paramètres de la route.
     * @return void
     */
    public static function router(array $params)
    {
        if (Category::isCategorySlug($params[1])
            && Announce::valueIssetInDB("slug", $params[2], Announce::TABLE_NAME)
        ) {
            if (isset($params[3]) && self::isAction($params[3])) {
                AnnounceController::manage($params);
            } else {
                AnnounceController::read($params);
            }
        }
        elseif ($params[1] === "users" && Model::valueIssetInDB("pseudo", $params[2], User::TABLE_NAME)) {
            if (isset($params[3])) {
                if ($params[3] === "posts") {
                    UserController::dashboard($params);
                } elseif (self::isAction($params[3])) {
                    UserController::manage($params);
                }
            }
            else {
                UserController::userProfile($params);
            }
        }
        else {
            throw new Exception("Ressource non trouvée !");
        }
    }

    /**
     * Gère les actions qu'on veut faire dans l'application.
     * 
     * @return bool
     */
    public static function isAction(string $action)
    {
        return in_array($action, self::$actions);
    }

}