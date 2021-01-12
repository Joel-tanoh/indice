<?php

namespace App\Controller;

use App\Action\Update\UpdateDb;
use App\Database\SqlQueryFormaterV2;
use App\View\Page\Page;
use App\View\View;

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
        $data = [
            "slug" => "test-1"
        ];

        $clauses = [
            "id"    => 15,
        ];

        $update = new UpdateDb($data, DB_NAME, "ind_announces", DB_LOGIN, DB_PASSWORD, $clauses);
        if ($update->run()) {
            echo "Action effectuée";
            die();
        } else {
            echo "Non fait !";
            die();
        }
    }

}