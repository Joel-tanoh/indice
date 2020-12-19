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
    public function getupdatedAt()
    {
        return Utility::formatDate($this->updatedAt);
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

    /**
     * Permet d'insérer les données dans la base de donnée et ainsi de créer
     * une nouvelle ligne qui constitue un nouvel item.
     * 
     * @param string $table    La table de la base de données dans laquelle
     *                         on doit enregistrer les données.
     * @param bool   $needCode Pour spéciifier si l'item a besoin d'un code
     *                         à l'enregistrement dans la base de données.
     * 
     * @return bool
     */
    public static function create(string $table, bool $needCode = false)
    {
        $needCode ? $data["code"] = Utility::generateCode() : null;
        isset($_POST["name"]) ? $data["name"] = htmlspecialchars($_POST["name"]) : null;
        isset($_POST["first_names"]) ? $data["first_names"] = htmlspecialchars($_POST["first_names"]) : null;
        isset($_POST["email_address"]) ? $data["email_address"] = htmlspecialchars($_POST["email_address"]) : null;
        isset($_POST["pseudo"]) ? $data["pseudo"] = htmlspecialchars($_POST["pseudo"]) : null;
        isset($_POST["password"]) ? $data["password"] = (new Password($_POST["password"]))->getHashed() : null;
        isset($_POST["phone_number"]) ? $data["phone_number"] = $_POST["phone_number"] : null;

        $insert = new InsertData($data, $table);
        $insert->run();
        
        return true;
    }

}