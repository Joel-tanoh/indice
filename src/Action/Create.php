<?php

namespace App\Action;

/**
 * Classe pour gérer toutes les actions de création de données.
 */
class Create
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $database;

    /**
     * @var string
     */
    protected $table;

    /**
     * Instance PDO
     */
    protected $pdo;

    /**
     * Constructeur de l'action insert.
     * 
     * @param array  $data     Le tableau contenant les données à inserer.
     * @param string $database Le nom de la base de données dans laquelle
     *                         on insère les données.
     * @param string $table    Le nom de la table qui va recevoir les données.
     */
    public function __construct(array $data, string $table = null, string $database = null)
    {
        $this->data = $data;
        $this->table = $table;
        $this->database = $database === null ? DB_NAME : $database;
    }

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

}