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

}