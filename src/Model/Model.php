<?php

namespace App\Model;

use App\Database\Database;
use App\Utility\Utility;

class Model
{
    protected $id;
    protected $title;
    protected $slug;
    protected $description;
    protected $createdAt;
    protected $modifiedAt;

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
    public function getDescription()
    {
        return $this->description;
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
    public function getModifiedAt()
    {
        return Utility::formatDate($this->modifiedAt);
    }

    /**
     * Retourne la liste des slugs de cette classe.
     * 
     * @param string $tableName
     * 
     * @return array
     */
    static function slugs(string $tableName) : array
    {
        $rep = self::connect()->query("SELECT slug FROM " . $tableName);
        return $rep->fetchAll();
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
    static function getBySlug(string $slug, string $tableName) : self
    {
        $rep = self::connect()->prepare("SELECT id FROM " . $tableName . " WHERE slug = ?");
        $rep->execute([$slug]);
        $item = $rep->fetch();

        if ($item["id"]) {
            return new self($item["id"]);
        }
    }

}