<?php

namespace App\Model\User;

use App\Database\SqlQueryFormater;
use App\File\Image\Image;
use App\File\Image\Avatar;
use App\Model\Announce;
use App\Utility\Utility;
use App\Auth\Session;
use App\Auth\Cookie;

/**
 * Classe de gestion d'un utilisateur inscrit.
 */
class Registered extends User
{
    protected $name;
    protected $firstNames;
    protected $pseudo;
    protected $password;
    protected $phoneNumber;
    protected $registeredAt;
    protected $updatedAt;
    protected $type;
    protected static $types = ["annonceur", "administrateur"];
    protected $status;
    protected static $statutes = ["activé", "prémium", "bloqué"];
    protected $announces = [];

    /**
     * Constructeur d'un User inscrit.
     * 
     * @param string $emailAddress
     */
    public function __construct(string $emailAddress)
    {
        $queryFormatter = new SqlQueryFormater();

        $query = $queryFormatter->select(
            "id, code, name, first_names, email_address, pseudo, password,
            phone_number, registered_at, updated_at, type, status"
            )->from(self::TABLE_NAME)->where("email_address = ?")->returnQueryString();

        $rep = parent::connectToDb()->prepare($query);
        $rep->execute([$emailAddress]);

        $result = $rep->fetch();

        $this->code = $result["code"];
        $this->name = $result["name"];
        $this->firstNames = $result["first_names"];
        $this->emailAddress = $result["email_address"];
        $this->pseudo = $result["pseudo"];
        $this->password = $result["password"];
        $this->phoneNumber = $result["phone_number"];
        $this->registeredAt = $result["registered_at"];
        $this->updatedAt = $result["updated_at"];
        $this->type = (int)$result["type"];
        $this->status = (int)$result["status"];
        $this->tableName = self::TABLE_NAME;
        $this->avatarPath = Avatar::AVATARS_DIR_PATH . $this->pseudo . Image::EXTENSION;
        $this->avatarSrc = Avatar::AVATARS_DIR_URL . "/". $this->pseudo .Image::EXTENSION;
    }

    /**
     * Retourne le code de l'utilisateur.
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Retourne le nom de l'utilisateur.
     * @return string
     */
    public function getName()
    {
        return ucfirst($this->name);
    }

    /**
     * Retourne le prénom de l'utilisateur.
     * @return string
     */
    public function getFirstNames()
    {
        return ucfirst($this->firstNames);
    }

    /**
     * Retourne le pseudo de l'utilisateur.
     * @return string
     */
    public function getPseudo()
    {
        return ucfirst($this->pseudo);
    }

    /**
     * Retourne le password de l'utilisateur.
     * @return string
     */
    public function getPassword()
    {
        return ucfirst($this->password);
    }

    /**
     * Retourne le contact de l'utilisateur.
     * @return string
     */
    public function getPhoneNumber()
    {
        return ucfirst($this->phoneNumber);
    }

    /**
     * Retourne la date d'inscription.
     * 
     * @return string
     */
    public function getRegisteredAt()
    {
        return Utility::formatDate($this->registeredAt, "D", true);
    }
    
    /**
     * Retourne la date de mise à jour du compte.
     * 
     * @return string
     */
    public function getUpdatedAt()
    {
        return Utility::formatDate($this->updatedAt, "D", true);
    }
    
    /**
     * Retourne le type d'utilisateur.
     * 
     * @return string
     */
    public function getType()
    {
        return ucfirst(self::$types[$this->type]);
    }

    /**
     * Retourne le statut d'utilisateur.
     * 
     * @return string
     */
    public function getStatus()
    {
        return ucfirst(self::$statutes[$this->status]);
    }

    /**
     * Retourne la source de l'avatar de l'utilisateur.
     * 
     * @return string
     */
    public function getAvatarSrc()
    {
        if (\file_exists($this->avatarPath)) {
            return $this->avatarSrc;
        } else {
            return Avatar::DEFAULT_THUMBS;
        }
    }

    /**
     * Retourne la liste des annonces postées par l'utilisateur.
     * 
     * @param int $status
     * 
     * @return array
     */
    public function getAnnounces(int $status = null)
    {
        $query = "SELECT id FROM " . Announce::TABLE_NAME . " WHERE user_email_address = ?";

        if ($status) {
            $query .= " AND status = ?";
            $rep = parent::connectToDb()->prepare($query);
            $rep->execute([$this->emailAddress, $status]);
        } else {
            $rep = parent::connectToDb()->prepare($query);
            $rep->execute([$this->emailAddress]);
        }

        $result = $rep->fetchAll();

        foreach($result as $announce) {
            $this->announces[] = new Announce((int)$announce["id"]);
        }

        return $this->announces;
    }

    /**
     * Permet de vérifier si l'utilisateur est prémium.
     * @return bool
     */
    public function isPremium()
    {
        return $this->status === 2;
    }

    /**
     * Permet de mettre à jour les infos d'un utilisateur.
     */
    public function update()
    {
        // Si l'utilisateur change son pseudo
        // Alors on renomme l'image
    }

    /**
     * Permet a l'utilisateur de se déconnecter.
     */
    public static function signOut()
    {
        Session::deactivate();
        Cookie::destroy(Cookie::KEY);
        Utility::redirect("/");
    }

    /**
     * Retourne les statuts.
     * 
     * @return array
     */
    public static function getStatutes()
    {
        return self::$statutes;
    }

    /**
     * Convertit le statut passé en chaîne de caractère
     * en chiffre.
     * 
     * @param string $status
     * 
     * @return int
     */
    public static function convertStatus(string $status)
    {
        $key = array_keys(self::$statutes, strtolower($status));
        if (count($key) === 1) {
            return $key[0];
        }
        return $key;
    }

    /**
     * Permet de compter les annonces postées par l'utilisateur.
     * 
     * @return int
     */
    public function countAnnouncesBy(string $col, $value, string $tableName)
    {
        return self::countBy($col, $value, self::TABLE_NAME);
    }

}