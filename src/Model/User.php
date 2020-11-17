<?php

namespace App\Model;

use App\Database\SqlQueryFormater;

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
    protected $types = ["annonceur", "administrateur"];
    protected $type;
    const TABLE_NAME = "ind_users";

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
            modified_at, type"
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
        $this->type = $result["type"];
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

    /**
     * Permet d'instancier un objet user par son adresse email qu'on considère unique.
     * 
     * @param string $emailAddress
     * 
     * @return self
     */
    public static function getByEmailAddress($emailAddress)
    {
        $rep = parent::connect()->prepare("SELECT id FROM " . self::TABLE_NAME . " WHERE email_address = ?");
        $rep->execute([$emailAddress]);
        
        $user = $rep->fetch();
        return new self($user["id"]);
    }

    /**
     * Retourne le type d'utilisateur.
     * 
     * @return string
     */
    public function getType()
    {
        return $this->types[$this->type];
    }

    /**
     * Retourne un user grace à son code.
     * 
     * @param string $code
     * 
     * @return self
     */
    static function getByCode($code) : self
    {
        $rep = parent::connect()->prepare("SELECT id FROM " . self::TABLE_NAME . " WHERE code = ?");
        $rep->execute([$code]);
        $user = $rep->fetch();

        if ($user["id"]) {
            return new self($user["id"]);
        }
    }

}