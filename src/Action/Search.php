<?php

namespace App\Action;

/**
 * Classe de gestion d'une recherche
 */
class Search extends Action
{
    private $query;
    private $result;

    /**
     * Constructeur d'une recherche.
     */
    public function __construct($query)
    {
        $this->query = $query;
    }

    /**
     * Permet de passer la requête à la recherche.
     * 
     * @param $query
     */
    public function setQuery(mixed $query)
    {
        $this->query = $query;
    }

    /**
     * Retourne les résultats de la recherche.
     */
    public function getResult()
    {
        return $this->result;
    }
}