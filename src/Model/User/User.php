<?php

namespace App\Model\User;

use App\Action\Create\Create;
use App\Action\Create\InsertInDb;
use App\Auth\Cookie;
use App\Auth\Session;
use App\File\Image\Avatar;
use App\File\Image\Image;
use App\Utility\Utility;
use App\Model\Model;

/**
 * Classe de gestion des utilisateurs.
 */
class User extends Model
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
    public static function isAuthentified()
    {
        return Session::isActive() || Cookie::userCookieIsset();
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

        $insertion = new InsertInDb($data, DB_NAME, self::TABLE_NAME, DB_LOGIN, DB_PASSWORD);
        $insertion->run();
        
        if (Create::fileIsUploaded("avatar")) {
            $imageManager = new Image();
            $imageManager->save($_FILES["avatar"]["tmp_name"], $_POST["pseudo"], Avatar::AVATARS_DIR_PATH, 80, 80);
        }

        return true;
    }

}