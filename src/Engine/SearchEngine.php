<?php

namespace App\Engine;

use App\Action\Action;

/**
 * Moteur de recherche de l'application.
 */
class SearchEngine extends Action
{
    /**
     * Constructeur d'un moteur de recherche.
     *
     */
    public function __construct(array $data, string $colForInstantiate = null, string $database = DB_NAME, string $dbLogin = DB_LOGIN, string $dbPassword = DB_PASSWORD)
    {
        $this->database = $database;
        $this->dbLogin = $dbLogin;
        $this->dbPassword = $dbPassword;
    }

    /**
     * Permet de chercher les annonces.
     */
    public function searchAnnounces(string $tableName, array $data)
    {
        $this->formatQuery($tableName, $data);
        $req = parent::connectToDb($this->dbLogin, $this->dbPassword)->query($this->query);
        $this->data = $req->fetchAll();
    }

    /** 
     * Retourne les résultats de la recherche.
     * 
     * @return array
     */
    public function getResult()
    {
        return $this->data;
    }

    /**
     * Permet de formater la requête.
     */
    public function formatQuery(string $tableName  = null, array $data = null)
    {
        $query = htmlspecialchars($_POST["query"]);
        $idCategory = htmlspecialchars($_POST["id_category"]);
        $location = htmlspecialchars($_POST["location"]);
        $type = htmlspecialchars($_POST["type"]);
        $direction = htmlspecialchars($_POST["direction"]);
        
        $this->query = "SELECT id FROM $tableName
            WHERE title LIKE '%$query%' OR description LIKE '%$query%'
            OR id_category = $idCategory
            OR location = '$location'
            OR type = '$type'
            OR direction = '$direction'
        ";

        if (!empty($_POST["price"])) {
            $price = htmlspecialchars($_POST["price"]);
            $this->query .= " OR price = $price";
        }
    }

}