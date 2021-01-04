<?php

namespace App\Controller;

use App\Action\Action;
use App\Action\Create;
use App\Auth\Connexion;
use App\Auth\Cookie;
use App\File\Image\Image;
use App\Model\Model;
use App\Model\User\User;
use App\Session;
use App\Utility\Utility;
use App\Utility\Validator;
use App\View\Model\User\UserView;
use App\View\Notification;
use App\View\Page\Page;

class UserController extends AppController
{
    /**
     * Le controller pour la connexion d'un utilisateur.
     */
    public static function connexion()
    {
        if (Session::isActive() || Cookie::userCookieIsset()) {
            Utility::redirect("user/dashboard");
        }

        $error = null;

        if (Action::dataPosted()) {
            
            $connexion = new Connexion("email_address", $_POST["password"], DB_NAME, DB_LOGIN, DB_PASSWORD, User::TABLE_NAME);
            $connexion->execute();

            if ($connexion->getError()) {
                $error = (new Notification())->error($connexion->getError(), "alert alert-danger");
            } else {
                Session::activate($_POST["email_address"]);

                if (isset($_POST["remember_me"]) && $_POST["remember_me"] === "yes") {
                    Cookie::setCookie(Cookie::KEY, $_POST["email_address"]);
                }

                Utility::redirect("user/dashboard");
            }
        }

        $page = new Page("Connexion", (new UserView())->connexion($error));
        $page->setDescription("");
        $page->show();
    }

    /**
     * Controller pour la création d'un compte user.
     */
    public static function suscribe()
    {
        $message = null;

        // Si des données sont postées
        if (Action::dataPosted()) {
            
            // On fait la validation
            $validate =  new Validator();

            // Validation du nom
            if (empty($_POST["name"])) {
                $validate->addError("name", "Veuillez entrer votre nom !");
            } else {
                $validate->name($_POST["name"], "Veuillez vérifier que le prénoms ne contient pas de code HTML !", "name");
            }
            
            // Validation du prénom
            if (empty($_POST["first_names"])) {
                $validate->addError("first_names", "Veuillez entrer votre prénom !");
            } else {
                $validate->name($_POST["first_names"], "Veuillez vérifier que les prénoms ne contiennent pas de code HTML !", "first_names");
            }
            
            // Validation du pseudo
            if (empty($_POST["pseudo"])) {
                $validate->addError("pseudo", "Veuillez entrer votre pseudo !");
            } elseif (User::valueIsset("pseudo", $_POST["pseudo"], User::TABLE_NAME)) {
                $validate->addError("pseudo", "Ce pseudo est déjà utilisé !");
            } else {
                $validate->name($_POST["pseudo"], "Veuillez vérifier que le pseudo ne contient pas de code HTML !" ,"pseudo");
            }

            // Validation de l'adresse email
            if (empty($_POST["email_address"])) {
                $validate->addError("email_address", "Veuillez entrer votre adresse email !");
            } elseif (User::valueIsset("email_address", $_POST["email_address"], User::TABLE_NAME)) {
                $validate->addError("email_address", "Cette adresse email est déjà utilisée !");
            } else {
                $validate->email("email_address", $_POST["email_address"]);
            }

            // Validation du mot de passe
            if (empty($_POST["password"])) {
                $validate->addError("password", "Veuillez entrer un mot de passe svp !");
            } elseif (empty($_POST["confirm_password"])) {
                $validate->addError("confirm_password", "Veuillez entrer le mot passe de confirmation !");
            } else {
                $validate->password("password", $_POST["password"], $_POST["confirm_password"]);
            }

            // Validation du numéro
            if (empty($_POST["phone_number"])) {
                $validate->addError("phone_number", "Veuillez entrer un numéro svp !");
            } else {
                $validate->phoneNumber("phone_number", $_POST["phone_number"], "Veuillez entrer un numéro valide svp !");
            }

            // Validation de l'avatar
            if (Create::fileIsUploaded("avatar")) {
                $validate->fileExtensions("avatar", $_FILES["avatar"]["type"], ["image/png", "image/jpg"], "Veuillez charger une image svp !");
                $validate->fileSize("avatar", $_FILES["avatar"]["size"], Image::MAX_VALID_SIZE, "Taille maximale des images: 2 Mo !");
            }

            // dump(User::get("email_address", User::TABLE_NAME));
            // dump($validate->getErrors());
            // die();
 
            // Si aucune erreur
            if ($validate->noErrors()) {
                if (User::save()) {
                    $message = (new Notification())->toast("Enregistrement effectué avec succès", "success");
                    Utility::redirect("user/dashboard");
                }
            } else { // Sinon
                $message = (new Notification())->errors($validate->getErrors());
            }
        }

        $page = new Page("Connexion", UserView::suscribe($message));
        $page->setDescription("");
        $page->show();
    }

    /**
     * Controller pour gérer le dashboard d'un utlisateur.
     */
    public static function dashboard()
    {
        dump($_SESSION);
        dump($_COOKIE);
    }

    /**
     * Controller de gestion de la déconnexion.
     */
    public static function disconnexion()
    {
        Session::deactivate();
        Cookie::destroy(Cookie::KEY);
        Utility::redirect("/");
    }
}