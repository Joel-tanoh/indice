<?php

namespace App\Action;

use App\Database\Database;
use App\Model\Model;
use Exception;

class Action
{
    /** @var PDO Instance PDO pour exécuter les requêtes sur la base de 
     * doonées.
     */
    protected $pdo;

    /** @var string Le nom de la base de données. */
    protected $database;

    /** @var string Le nom de la table de laquelle on récupère les données. */
    protected $tableName;
    
    /** @var string Le nom d'utilisateur pour se connecter à la base de données. */
    protected $dbLogin;

    /** @var string Le mot de passe à utiliser pour se connecter à la 
     *  base de données.
     */
    protected $dbPassword;

    /** @var array Un tableau associatif qui contient les données à
     * insérer ou à retourner
     */
    protected $data;

    /**
     * Retourne l'instance PDO.
     * 
     * @return PDO
     */
    public function getPDO()
    {
        return $this->pdo;
    }

    /**
     * Permet de vérifier qu'un ou plusieurs fichiers ont été uploadés.
     * 
     * @param string $key La clé dans le tableau.
     * 
     * @return bool
     */
    public static function fileIsUploaded(string $key)
    {
        return !empty($_FILES[$key]["name"]);
    }

    /**
     * Permet de vérifier si des données ont été postées.
     * 
     * @return bool
     */
    public static function dataPosted()
    {
        return isset($_POST) && !empty($_POST);
    }

   
    /**
     * Permet de se connecter à une base de données dans le cas où
     * l'action porte sur une donnée dans cette base de données.
     * 
     * @return PDO
     */
    protected function connectToDb($dbLogin, $dbPassword)
    {
        $this->pdo = (new Database($this->database, $dbLogin, $dbPassword))->connect();
        return $this->pdo;
    }
}