<?php

namespace App\Model;

use App\Action\InsertData;
use App\Auth\Password;
use App\Database\Database;
use App\Utility\Utility;

class Model
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
    public static function connect()
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
        return $this->title;
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
        return substr($this->description, 0, $nbrOfChar) . "...";
    }

    /**
     * Retourne la date de création de l'annonce.
     * 
     * @return string
     */
    public function getCreatedAt()
    {
        return Utility::formatDate($this->createdAt);
    }
    
    /**
     * Retourne la date de modification de l'annonce.
     * 
     * @return string
     */
    public function getUpdatedAt()
    {
        return Utility::formatDate($this->updatedAt);
    }

    /**
     * C'est la requête basique pour la mise à jour d'un champ.
     * 
     * @param string $colName
     * @param mixed  $value
     * 
     * @return bool
     */
    protected function set(string $colName, $value)
    {
        $rep = self::connect()->prepare("UPDATE $this->tableName SET $colName = ? WHERE id = ?");
        if ($rep->execute([$value, $this->id])) {
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
        $rep = self::connect()->query("SELECT slug FROM " . $tableName);
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
        $rep = self::connect()->prepare("SELECT id FROM " . $tableName . " WHERE slug = ?");
        $rep->execute([$slug]);
        $item = $rep->fetch();

        if ($item["id"]) {
            return new $class($item["id"]);
        }
    }

}