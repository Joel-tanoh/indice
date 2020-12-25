<?php

namespace App\Action;

use App\Database\Database;
use App\Model\Model;
use Exception;

/**
 * Classe de gestion des insertions de données.
 */
class InsertData extends Create
{
    /**
     * Constructeur de l'action insert.
     * 
     * @param array  $data     Le tableau contenant les données à inserer.
     * @param string $database Le nom de la base de données dans laquelle
     *                         on insère les données.
     * @param string $table    Le nom de la table qui va recevoir les données.
     */
    public function __construct(array $data,  string $table, string $database = null)
    {
        parent::__construct($data, $table, $database);
    }

    /**
     * Permet d'insérer les données.
     * 
     * @param string $dbLogin     A spécifier si à l'instanciation d'un objet
     *                            Insert, vous passez le nom d'une base de données
     *                            différente de celle utilisée par défaut par l'application.
     * @param string $dbPassword. Pareil au paramètre dbLogin.
     * 
     * @return bool
     */
    public function run(string $dbLogin = null, string $dbPassword = null)
    {
        if ($this->database !== DB_NAME) {
            $this->pdo =  (new Database($this->database, $dbLogin, $dbPassword))->connect();
        } else {
            $this->pdo = Model::connect();
        }

        // Formatage des composantes de la requête
        $arrayKeys = array_keys($this->data);
        $keysString = "";
        $valuesString = "";

        foreach($arrayKeys as $key) {
            $keysString .= "$key, ";
            $valuesString .= ":$key, ";
        }

        // Rétirer les dernières virgules et espaces à la fin de la chaine de caractère
        $keysString = rtrim($keysString, ", ");
        $valuesString = rtrim($valuesString, ", ");

        // Formatage et envoi de la requête
        $query = "INSERT INTO $this->table($keysString) VALUES($valuesString)";
        $rep = $this->pdo->prepare($query);
        
        // Si tout s'est bien passé, retourner true
        if ($rep->execute($this->data)) {
            return true;
        } else { 
            // Sinon, lancer une exception
            throw new Exception("Action Insert in database failed.");
        }
    }

}