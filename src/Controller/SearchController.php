<?php

namespace App\Controller;

use App\Action\Action;
use App\Engine\SearchEngine;
use App\Model\Announce;
use App\View\Model\AnnounceView;
use App\View\Page\Page;

/** Controller de gestion des recherches. */
class SearchController extends AppController
{

    /**
     * Permet de router vers la bonne méthode si on a plusieurs
     * routes du même format.
     * @param array $params
     */
    public static function router(array $params)
    {
        dump($params);
        dump($_POST);
        die("Vous faites des recherches selon des paramètres");
    }

    /**
     * Permet de gérer les recherches.
     * @param array $params
     */
    public static function searchAnnonce(array $params = null)
    {
        $announces = [];
        if(Action::dataPosted()) {
            $searchEngine = new SearchEngine($_POST);
            $searchEngine->searchAnnounces(Announce::TABLE_NAME, $_POST);
            $announces = $searchEngine->getResult();
            dump($announces);
            die();
        } else {
            $announces = Announce::getAll();
        }
        $page = new Page();
        $page->setView(AnnounceView::searchingResult($announces));
        $page->show();
    }

    /**
     * Permet de chercher les utilisateurs.
     * @param array $params
     */
    public static function searchUsers(array $params = null)
    {
        die("Vous cherchez les utilisateurs");
    }

    /** Reçoit les paramètres de la recherches s'il en existe */
    public static function reception()
    {

    }

    /**
     * Permet d'exécuter la requête.
     */
    private function run()
    {

    }

    /**
     * Permet de formater la requête à envoyer à la base de données.
     */
    private static function format()
    {

    }

    /**
     * Permet d'envoyer la requête finale de recherche à la base de données.
     */
    private static function sendQueryToDb()
    {

    }
}