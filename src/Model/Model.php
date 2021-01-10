<?php

namespace App\Model;

use App\Database\Database;
use App\Database\SqlQueryFormaterV2;
use App\Utility\Utility;

abstract class Model
{
    protected $id;
    protected $title;
    protected $slug;
    protected $description;
    protected $createdAt;
    protected $updatedAt;
    protected $tableName;

    /**
     * Retourne une instance Database.
     * 
     * @return Database
     */
    public static function database()
    {
        return new Database(DB_NAME, DB_LOGIN, DB_PASSWORD, DB_ADDRESS);
    }

    /**
     * Permet de se connecter à la base de données et retourne l'instance PDO.
     * 
     * @return PDOInstance
     */
    public static function connectToDb()
    {
        return self::database()->getPDO();
    }

    /**
     * Retourne l'Id d'un model(donnée).
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Retourne le titre.
     * 
     * @return string
     */
    public function getTitle()
    {
        return ucfirst($this->title);
    }

    /**
     * Retourne le slug.
     * 
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Retourne la description.
     * 
     * @return string
     */
    public function getDescription(int $nbrOfChar = null)
    {
        $description = ucfirst(htmlspecialchars_decode($this->description));

        if ($nbrOfChar) {
            return substr($description, 0, $nbrOfChar) . "...";
        } else {
            return $description;
        }
    }

    /**
     * Retourne la date de création de l'annonce.
     * 
     * @return string
     */
    public function getCreatedAt()
    {
        return Utility::formatDate($this->createdAt, "D", true);
    }
    
    /**
     * Retourne la date de modification de l'annonce.
     * 
     * @return string
     */
    public function getUpdatedAt()
    {
        return Utility::formatDate($this->updatedAt, "day", true);
    }

    /**
     * C'est la requête basique pour la mise à jour d'un champ.
     * 
     * @param string $colName
     * @param  $value
     * 
     * @return bool
     */
    protected function set(string $colName, $value, string $selector, $selectorValue)
    {
        $rep = self::connectToDb()->prepare("UPDATE $this->tableName SET $colName = ? WHERE $selector = ?");
        if ($rep->execute([$value, $selectorValue])) {
            return true;
        }
    }

    /**
     * Retourne la liste des slugs de cette classe.
     * 
     * @param string $tableName
     * 
     * @return array
     */
    public static function getSlugs(string $tableName) : array
    {
        $slugs = [];
        $rep = self::connectToDb()->query("SELECT slug FROM " . $tableName);
        foreach ($rep->fetchAll() as $item) {
            $slugs[] = $item["slug"];
        }

        return $slugs;
    }

    /**
     * Retourne une objet de ce type grace au slug passé en
     * paramètre.
     * 
     * @param string $slug
     * @param string $tableName
     * 
     * @return self
     */
    public static function getBySlug(string $slug, string $tableName, string $class)
    {
        $rep = self::connectToDb()->prepare("SELECT id FROM $tableName WHERE slug = ?");
        $rep->execute([$slug]);
        $item = $rep->fetch();

        if ($item["id"]) {
            return new $class($item["id"]);
        }
    }

    /**
     * Retourne tous les valeurs d'une colonne dans la base de données.
     * 
     * @param string $colToSelect La colonne à récupérer.
     * @param string $table
     * @param array $whereCol    A passer si on veut filtrer les résultats.
     * @param  $WhereValue  La valeur à prendre en compte pour le filtrage.
     * 
     * @return array
     */
    public static function get(string $colToSelect, string $table, array $whereCol = null, $WhereValue = null)
    {
        $query = "SELECT $colToSelect FROM $table";

        if (null !== $whereCol && null !== $WhereValue) {
            $query .= " WHERE $whereCol = ?";
            $rep = self::connectToDb()->prepare($query);
            $rep->execute([$WhereValue]);
        } else {
            $rep = self::connectToDb()->query($query);
        }

        $values = [];

        foreach ($rep->fetchAll() as $value) {
            $values[] = $value[$colToSelect];
        }

        return $values;
    }

    /**
     * Permet de vérifier qu'une valeur est déjà utilisée.
     * 
     * @param string $valueIndex Index(nom de la colonne dans la table dans la base de
     *                           données).
     * @param $value
     * 
     * @return bool
     */
    public static function valueIsset(string $valueIndex, $value, string $tableName)
    {
        return in_array($value, self::get($valueIndex, $tableName));
    }

    /**
     * Permet d'instancier un objet.
     * 
     * @param string $selector La colonne qui va permettre d'instancier l'objet.
     * @param string $table    La table dans laquelle se trouve la donnée.
     * @param string $col      La clause Where qui permet spécifier l'occurrence
     *                         à récupérer.
     * @param string $class    La classe de l'objet à instancier.
     */
    public static function instantiate(string $selector, string $table, string $col, $colValue, string $class)
    {
        $rep = self::connectToDb()->prepare("SELECT $selector FROM $table WHERE $col = ?");
        $rep->execute([$colValue]);
        $user = $rep->fetch();

        return new $class($user[$selector]);
    }

    /**
     * Permet d'obtenir un ou plusieurs objets selon 
     * un paramètre.
     * 
     * @param string $col   La colonne pour filter le résultat.
     * 
     * @return array
     */
    public static function getBy(string $colForInstance, string $tableName, string $col = null, $value = null, string $className = null)
    {
        $queryFormater = new SqlQueryFormaterV2();
        $query = $queryFormater->select($colForInstance)->from($tableName);

        if ($col && $value) {
            $query = $queryFormater->where("$col = ?")->returnQueryString();
            $rep = self::connectToDb()->prepare($query);
            $rep->execute([$value]);
        } else {
            $query = $queryFormater->returnQueryString();
            $rep = self::connectToDb()->query($query);
        }

        if ($className) {
            $return = [];    
            foreach($rep->fetchAll() as $item) {
                $return[] = new $className($item[$colForInstance]);
            }
            return $return;

        } else {
            return $rep->fetchAll();
        }
    }

    /**
     * Permet de compter les annonces.
     */
    public static function countBy(string $colForInstance, string $tableName, string $col = null, $value = null)
    {
        return count(self::getBy($colForInstance, $tableName, $col, $value));
    }

}