<?php

namespace App\Model\User;

use App\Action\Update\Update;
use App\Database\SqlQueryFormater;
use App\File\Image\Image;
use App\File\Image\Avatar;
use App\Model\Announce;
use App\Utility\Utility;
use App\Auth\Session;
use App\Auth\Cookie;
use App\Communication\Comment;
use Exception;

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
    protected static $statutes = ["activé", "prémium", "suspendu"];
    protected $announces = [];

    /** Le nombre de post maximun par mois d'un annonceur simple */
    const POST_PER_MONTH = 15;

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

        $req = parent::connectToDb()->prepare($query);
        $req->execute([$emailAddress]);

        $result = $req->fetch();

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
     * Retourne le nom complet de l'utlisateur.
     * 
     * @return string
     */
    public function getFullName()
    {
        return $this->getName() . " " . $this->getFirstNames();
    }

    /**
     * Retourne le pseudo de l'utilisateur.
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
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
     * Retourne le lien vers le profil de l'utilisateur.
     * @return string
     */
    public function getProfileLink()
    {
        return "/users/$this->pseudo";
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
            return Avatar::DEFAULT;
        }
    }

    /**
     * Retourne la liste des annonces postées par l'utilisateur.
     * 
     * @param $status
     * 
     * @return array
     */
    public function getAnnounces($status = null)
    {
        $query = "SELECT id FROM " . Announce::TABLE_NAME . " WHERE user_email_address = ?";

        if (null !== $status) {
            if (in_array($status, self::$statutes)) {
                $status = self::convertStatus($status);
            }

            $query .= " AND status = ?";
            $req = parent::connectToDb()->prepare($query);
            $req->execute([$this->emailAddress, $status]);
        } else {
            $req = parent::connectToDb()->prepare($query);
            $req->execute([$this->emailAddress]);
        }

        $announces = [];

        foreach($req->fetchAll() as $announce) {
            $announces[] = new Announce((int)$announce["id"]);
        }
        
        return $announces;
    }

    /**
     * Permet de compter les annonces postées par l'utilisateur.
     * @param  $status
     * @return int
     */
    public function getAnnounceNumber($status = null)
    {
        if (in_array($status, self::$statutes)) {
            $status = self::convertStatus($status);
        }
        return count($this->getAnnounces($status));
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
     * 
     * @return bool
     */
    public function update()
    {
        $imageManager = new Image();
        $data = [
            "name" => htmlspecialchars($_POST["name"]),
            "first_names" => htmlspecialchars($_POST["first_names"]),
            "email_address" => htmlspecialchars($_POST["email_address"]),
            "password" => password_hash($_POST["password"], PASSWORD_DEFAULT),
            "phone_number" => htmlspecialchars($_POST["phone_number"]),
        ];

        /** Gestion du pseudo et des images*/
        // Si le pseudo ne change pas mais un nouvel avatar est posté
        if ($_POST["pseudo"] === $this->pseudo && Update::fileIsUploaded("avatar")) {
            $imageManager->save($_FILES["avatar"]["tmp_name"], $_POST["pseudo"], Avatar::AVATARS_DIR_PATH, 80, 80);
        }
        // Sile pseudo change et que l'avatar ne change pas
        elseif ($_POST["pseudo"] !== $this->pseudo && !Update::fileIsUploaded("avatar")) {
            $imageManager->rename($this->avatarPath, Avatar::AVATARS_DIR_PATH . $_POST["pseudo"]);
        }
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
     * Permet de vérifier si l'utilisateur qui a ce compte
     * a les droits.
     */
    public function hasRights()
    {
        return $this->type === 1;
    }

    /**
     * Permet de vérifier si l'utilisateur est administrateur.
     * @return bool
     */
    public function isAdministrator()
    {
        return $this->type === 1;
    }

    /**
     * Permet d'instancier un utilisateur enregistré par son pseudo.
     * @return self
     */
    public static function getByPseudo(string $pseudo)
    {
        $query = "SELECT email_address FROM " . self::TABLE_NAME . " WHERE pseudo = :pseudo";
        $req = parent::connectToDb()->prepare($query);
        $req->execute([
            "pseudo" => $pseudo
        ]);

        $emailAddress = $req->fetch()["email_address"];

        if (null === $emailAddress) {
            throw new Exception("Ressource Introuvable !");
        } else {
            return new self($emailAddress);
        }
    }

    /**
     * Permet à l'utilisateur connecté d'ajouter un commentaire.
     * @param string $content Le contenu du commentaire.
     */
    public function comment($subjectId, string $content, $subjectType = null)
    {
        if (Comment::add($this->emailAddress, $subjectId, $content, $subjectType)) {
            return true;
        }
    }

    /**
     * Permet de supprimer un commentaire que l'utilisateur a posté.
     * 
     * @param int $commentId L'id du commentaire à supprimer.
     * 
     * @return bool
     */
    public function deleteComment(int $commentId)
    {
        $comment = new Comment($commentId);
        if ($comment->getPoster()->getEmailAdress() == $this->emailAddress) {
            if ($comment->delete()) {
                return true;
            }
        }
    }

    /**
     * Permet de modifier le mot de passe.
     * 
     * @param string $newPassword
     */
    public function updatePassword(string $newPassword)
    {
        $this->set("password", password_hash($newPassword, PASSWORD_DEFAULT), "id", $this->id);
    }

    /**
     * Retourne la liste de tous les comptes.
     * 
     * @return array
     */
    public static function getAll()
    {
        $query = "SELECT email_address FROM " . self::TABLE_NAME;
        $req = parent::connectToDb()->query($query);

        $registered = [];
        foreach($req->fetchAll() as $result) {
            $registered[] = new self($result["email_address"]);
        }

        return $registered;
    }

    /**
     * Retourne les comptes par status.
     * 
     * @param $status
     * @return array
     */
    public function getByStatus($status)
    {
        $req = parent::connectToDb()->prepare("SELECT email_address FROM ". self::TABLE_NAME . " WHERE status = :status");

        if (is_string($status)) {
            $status = self::convertStatus(strtolower($status));
        }

        $req->execute([
            "status" => $status
        ]);

        $registered = [];
        foreach($req->fetchAll() as $result) {
            $registered[] = new self($result["email_address"]);
        }

        return $registered;
    }

    /**
     * Retourne les annonces postées selon une date.
     */
    public function getByDate()
    {
        
    }

}