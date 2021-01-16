<?php

namespace App\Controller;

use App\Action\Update\UpdateDb;
use App\Database\SqlQueryFormaterV2;
use App\Model\Announce;
use App\Model\Category;
use App\Model\Model;
use App\Model\User\User;
use App\View\Page\Page;
use App\View\View;
use Exception;

class AppController
{
    /**
     * Index du site.
     */
    public static function index()
    {
        $page = new Page("Le leader des petites annonces de Côte d'Ivoire", View::index());
        $page->show();
    }

    /**
     * Cette page s'affiche pour les ressources pas encore développées.
     */
    public static function page404()
    {
        $page = new Page("Le leader des petites annonces de Côte d'Ivoire - En cours", View::page404("Page en cours de développement", "En cours"));
        $page->show();
    }

    public static function test() {
        echo 'Test';
    }

    /** Permet de faire des vérifications sur les routes qui ont la même
     * longueur mais des controllers différents. */

    public static function switcher1(array $params)
    {

    }

    public static function switcher2(array $params)
    {
        if (Category::isCategorySlug($params[1]) && Announce::valueIssetInDB("slug", $params[2], Announce::TABLE_NAME)) {
            AnnounceController::read($params);
        }
        elseif ($params[1] === "users" && Model::valueIssetInDB("pseudo", $params[2], User::TABLE_NAME)) {
            UserController::userProfile($params);
        }
        else {
            throw new Exception("Ressource non trouvée !");
        }
    }


}