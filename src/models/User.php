<?php

namespace App\Models;

use App\database\SqlQueryFormater;

/**
 * Classe de gestion des utilisateurs.
 */
class User extends Model
{
    protected $code;
    protected $name;
    protected $firstNames;
    protected $emailAddress;
    protected $pseudo;
    protected $password;
    protected $phoneNumber;
    protected $createdAt;
    protected $modifiedAt;
    const TABLE_NAME = "users";

    /**
     * Constructeur d'un User.
     * 
     * @param int $id
     */
    public function __construct(int $id)
    {
        $queryFormatter = new SqlQueryFormater();

        $query = $queryFormatter->select(
            "id, code, name, first_names, email_address, pseudo, password, phone_number, created_at,
            modified_at"
            )->from(self::TABLE_NAME)->where("id = ?");

        $rep = parent::connect()->prepare($query);
        $rep->execute([$id]);

        $result = $rep->fetch();

        $this->code = $result["code"];
        $this->name = $result["name"];
        $this->firstNames = $result["first_names"];
        $this->emailAddress = $result["email_address"];
        $this->pseudo = $result["pseudo"];
        $this->password = $result["password"];
        $this->phoneNumber = $result["phone_number"];
        $this->createdAt = $result["created_at"];
        $this->modifiedAt = $result["modified_at"];
    }

    /**
     * Retourne le code identifiant d'un user.
     * 
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Retourne le nom de l'utilisateur.
     * 
     * @return string
     */
    public function getName()
    {
        return ucfirst($this->name);
    }

    /**
     * Retourne les prénoms de l'utilisateur.
     * 
     * @return string
     */
    public function getFirstNames()
    {
        return $this->firstNames;
    }

    /**
     * Retourne l'addresse email de l'utilisateur.
     * 
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Retourne le pseudo de l'utilisateur.
     * 
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Retourne le mot de passe de l'utilisateur.
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * Retourne le numéro de téléphone enregistré lors de la création de l'annonce.
     * 
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

}