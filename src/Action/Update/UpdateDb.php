<?php

namespace App\Action\Update;

use Exception;

/**
 * Permet de modifier une valeur dans la base de données.
 */
class UpdateDb extends Update
{
    /** @var string Le nom de la base de données sur laquelle la mise à jour
     * va être faite.
     */
    private $dbName;

    /** @var string Le nom de la table qui sera mise à jour */
    private $tableName;



    /** @var array Tableau associatif contenant l'ensemble des clauses 
     * injectées dans la reqûete de mise à jour.
     */
    private $clauses;

    /** @var string La requête finale a envoyer à la base de données */
    private $query;

    /** @var string Format texte des clauses à
     * insérer dans la requête de mise à jour.
     */
    private $clauseString;

    /** @var array Tableau associatif contenant la liste des paramètres
     * à passer dans la la méthode execute de la requête.
     */
    private $params;

    /**
     * Constructeur d'une mise à jour de la base de données.
     * 
     * @param
     */
    public function __construct(array $data, string $dbName, string $tableName, string $dbLogin, string $dbPassword, array $clauses = null)
    {
        $this->data = $data;
        $this->dbName = $dbName;
        $this->tableName = $tableName;
        $this->dbLogin = $dbLogin;
        $this->dbPassword = $dbPassword;
        $this->clauses = $clauses;
    }

    /**
     * Permet d'exécuter la requête finale.
     */
    public function run()
    {
        parent::connectToDb($this->dbLogin, $this->dbPassword);
        $this->formatQuery();
        $rep = $this->pdo->prepare($this->query);
        $this->formatParams();
        
        // Si tout s'est bien passé, retourner true
        if ($rep->execute($this->params)) {
            $this->data = $rep->fetchAll();
        } else {
            // Sinon, lancer une exception
            throw new Exception("Action Update Database failed.");
        }
    }

    /**
     * Constructeur de la requête sql de modification.
     */
    private function formatQuery()
    {
        // Formatage des composantes de la requête
        $arrayKeys = array_keys($this->data);
        $colAndValue = null;

        foreach($arrayKeys as $key) {
            $colAndValue .= "$key = :$key, ";
        }

        // Rétirer les dernières virgules et espaces à la fin de la chaine de caractère
        $colAndValue = rtrim($colAndValue, ", ");

        $this->formatClauses();

        $this->query = "UPDATE $this->tableName SET $colAndValue $this->clauseString";
    }

    /**
     * Permet de formater les clauses pour les insérer dans la requête
     * de mise à jour.
     */
    private function formatClauses()
    {
        if (empty($this->clauses)) {
            return null;
        }

        // Formatage des composantes de la clause
        $arrayKeys = array_keys($this->clauses);
        $clauseString = null;

        foreach($arrayKeys as $key) {
            $clauseString .= "$key = :$key AND ";
        }

        // Rétirer les dernières virgules et espaces à la fin de la chaine de caractère
        $clauseString = rtrim($clauseString, "AND ");

        $this->clauseString = " WHERE $clauseString";
    }

    /**
     * Permet de formater les paramètres à passer dans la requête de mise
     * à jour.
     */
    private function formatParams()
    {
        $this->params = array_merge($this->data, $this->clauses);
    }
}