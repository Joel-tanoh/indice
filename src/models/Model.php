<?php

namespace App\Models;

use App\database\Database;
use App\Utilities\Utility;

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
        return new Database(DB_NAME, DB_LOGIN, DB_PASSWORD);
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

}