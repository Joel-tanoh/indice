<?php

namespace App\Model;

use App\Database\Database;
use App\Database\SqlQueryFormaterV2;
use App\Utility\Utility;

/** Gère tout ce qui concerne les données. */
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
     * Permet de se connecter à la base de données et retourne l'instance PDO.
     * 
     * @return PDOInstance
     */
    public static function connectToDb()
    {
        return self::database()->getPDO();
    }

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
     * @param mixed  $value
     * @param string $selector      Le nom de la colonne qui permet
     *                              d'identifier l'élément à mettre à jour.
     * @param mixed  $selectorValue La valeur de la colonne qui permet
     *                              d'identifier l'élément à mettre à jour.
     * 
     * @return bool
     */
    protected function set(string $colName, $value, string $selector, $selectorValue)
    {
        $req = self::connectToDb()->prepare("UPDATE $this->tableName SET $colName = ? WHERE $selector = ?");
        if ($req->execute([$value, $selectorValue])) {
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
        $req = self::connectToDb()->query("SELECT slug FROM " . $tableName);
        foreach ($req->fetchAll() as $item) {
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
     */
    public static function getBySlug(string $slug, string $tableName, string $class)
    {
        $req = self::connectToDb()->prepare("SELECT id FROM $tableName WHERE slug = ?");
        $req->execute([$slug]);
        $item = $req->fetch();

        if ($item["id"]) {
            return new $class($item["id"]);
        }
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
    public static function valueIssetInDB(string $valueIndex, $value, string $tableName)
    {
        return in_array($value, self::get($valueIndex, $tableName));
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
            $req = self::connectToDb()->prepare($query);
            $req->execute([$WhereValue]);
        } else {
            $req = self::connectToDb()->query($query);
        }

        $values = [];

        foreach ($req->fetchAll() as $value) {
            $values[] = $value[$colToSelect];
        }

        return $values;
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
        $req = self::connectToDb()->prepare("SELECT $selector FROM $table WHERE $col = ?");
        $req->execute([$colValue]);
        $user = $req->fetch();

        return new $class($user[$selector]);
    }

    /**
     * Permet d'obtenir un ou plusieurs objets selon 
     * un paramètre.
     * 
     * @param string $col   La colonne pour filter le résultat.
     */
    public static function getBy(string $colForInstance, string $tableName, string $col = null, $value = null, string $className = null)
    {
        $queryFormater = new SqlQueryFormaterV2();
        $query = $queryFormater->select($colForInstance)->from($tableName);

        if ($col && $value) {
            $query = $queryFormater->where("$col = ?")->returnQueryString();
            $req = self::connectToDb()->prepare($query);
            $req->execute([$value]);
        } else {
            $query = $queryFormater->returnQueryString();
            $req = self::connectToDb()->query($query);
        }

        if ($className) {
            $return = [];
            foreach($req->fetchAll() as $item) {
                $return[] = new $className($item[$colForInstance]);
            }
            return $return;
        } else {
            return $req->fetchAll();
        }
    }

    /**
     * Permet de compter les annonces.
     */
    public static function countBy(string $colForInstance, string $tableName, string $col = null, $value = null)
    {
        return count(self::getBy($colForInstance, $tableName, $col, $value));
    }

    /**
     * Permet de supprimer une valeur de la table passée en 
     * paramètre.
     * 
     * @return bool|null
     */
    public function delete()
    {
        $query = "DELETE FROM $this->tableName WHERE id = ?";
        $req = self::connectToDb()->prepare($query);
        if ($req->execute([$this->id])) {
            return true;
        }
    }

    /**
     * Permet d'actualiser un objet.
     * 
     * @param string $class               La classe de l'objet à instantier.
     * @param mixed  $valueForInstantiate La valeur à utiliser pour instantier
     *                                    l'objet.
     */
    public static function actualize(string $class, $valueForInstantiate)
    {
        return new $class($valueForInstantiate);
    }
    
    /**
     * Retourne toutes les valeurs d'une colonne dans une table.
     * 
     * @return array
     */
    public static function all(string $col, string $tableName)
    {
        $req = self::connectToDb()->query("SELECT $col FROM $tableName");
        
        $data = [];
        foreach ($req->fetchAll() as $value) {
            $data[] = $value[$col];
        }

        return $data;
    }

}