<?php

namespace App\Model\User;

use App\Action\Create\Create;
use App\Action\Create\InsertInDb;
use App\Auth\Authentication;
use App\Auth\Cookie;
use App\Auth\Session;
use App\File\Image\Avatar;
use App\File\Image\Image;
use App\Utility\Utility;
use App\Model\Model;

/**
 * Classe de gestion des utilisateurs.
 */
abstract class User extends Model
{
    protected $code;
    protected $emailAddress;
    const TABLE_NAME = "ind_users";

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
     * Retourne l'adresse email.
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Retourne un user grace à son code.
     * 
     * @param string $code
     * 
     * @return self
     */
    public static function getByCode($code) : self
    {
        $req = parent::connectToDb()->prepare("SELECT id FROM " . self::TABLE_NAME . " WHERE code = ?");
        $req->execute([$code]);
        $user = $req->fetch();

        if ($user["id"]) {
            return new self($user["id"]);
        }
    }

    /**
     * Permet de vérifier qu'un utilisateur est connecté.
     * 
     * @return bool
     */
    public static function isAuthenticated()
    {
        return Authentication::made();
    }

    /**
     * Permet de retourner l'utilisateur authentifié actuellement.
     * 
     * @return Registered
     */
    public static function getAuthenticated()
    {
        if (self::isAuthenticated()) {
            $user = new Registered(Authentication::getId());
            if ($user->isAdministrator()) {
                return new Administrator(Authentication::getId());
            }
        }
    }

    /**
     * Permet d'enregistrer les données dans la base de données.
     * 
     * @return bool
     */
    public static function save()
    {
        $data = [
            "code" => Utility::generateCode(),
            "name" => htmlspecialchars($_POST["name"]),
            "first_names" => htmlspecialchars($_POST["first_names"]),
            "email_address" => htmlspecialchars($_POST["email_address"]),
            "pseudo" => htmlspecialchars($_POST["pseudo"]),
            "password" => password_hash($_POST["password"], PASSWORD_DEFAULT),
            "phone_number" => htmlspecialchars($_POST["phone_number"]),
        ];

        $insertion = new InsertInDb($data, self::TABLE_NAME, DB_NAME, DB_LOGIN, DB_PASSWORD);
        $insertion->run();
        
        if (Create::fileIsUploaded("avatar")) {
            $imageManager = new Image();
            $imageManager->save($_FILES["avatar"]["tmp_name"], $_POST["pseudo"], Avatar::AVATARS_DIR_PATH, 80, 80);
        }

        return true;
    }

    /**
     * Permet de rédiriger l'utilisateur sur sa
     * page de connexion s'il n'est pas authentifié.
     * 
     * @param string $where Le lien vers lequel on redirige l'utilisateur
     *                      s'il n'est pas authentifié.
     */
    public static function askToAuthenticate(string $where)
    {
        Authentication::askToAuthenticate($where);
    }
}