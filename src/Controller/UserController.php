<?php

namespace App\Controller;

use App\Action\Action;
use App\Action\Create\Create;
use App\Auth\Authentication;
use App\Auth\Connexion;
use App\Auth\Cookie;
use App\File\Image\Image;
use App\Model\User\User;
use App\Model\User\Registered;
use App\Auth\Session;
use App\Communication\Email;
use App\Communication\Newsletter;
use App\Model\Announce;
use App\Utility\Utility;
use App\Utility\Validator;
use App\View\Model\User\UserView;
use App\View\Model\User\RegisteredView;
use App\Communication\Notify\NotifyByHTML;
use App\Model\Model;
use App\Model\User\Visitor;
use App\View\Model\User\AdministratorView;
use App\View\Page\Page;
use Exception;

class UserController extends AppController
{

    /**
     * Controller pour la création d'un compte user.
     */
    public static function register()
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
            } elseif (User::valueIssetInDB("pseudo", $_POST["pseudo"], User::TABLE_NAME)) {
                $validate->addError("pseudo", "Ce pseudo est déjà utilisé !");
            } else {
                $validate->name($_POST["pseudo"], "Veuillez vérifier que le pseudo ne contient pas de code HTML !" ,"pseudo");
            }

            // Validation de l'adresse email
            if (empty($_POST["email_address"])) {
                $validate->addError("email_address", "Veuillez entrer votre adresse email !");
            } elseif (User::valueIssetInDB("email_address", $_POST["email_address"], User::TABLE_NAME)) {
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

            // Si aucune erreur
            if ($validate->noErrors()) {
                if (User::save()) {
                    (new Visitor(Session::getVisitor()))->identify($_POST["email_address"]);
                    Session::activateRegistered($_POST["email_address"]);
                    Cookie::setRegistered($_POST["email_address"]);

                    Newsletter::register($_POST["email_address"]);
                    $email = new Email(
                        $_POST["email_address"],
                        "Bienvenue sur L'indice.com",
                        (new RegisteredView(User::authenticated()))->welcomeMessage()
                    );
                    $email->send();

                    Utility::redirect(User::authenticated()->getProfileLink());
                }
            } else { // Sinon
                $message = (new NotifyByHTML())->errors($validate->getErrors());
            }
        }

        $page = new Page("L'indice | Je crée mon compte", UserView::register($message));
        $page->setDescription("");
        $page->show();
    }

    /**
     * Le controller pour la sign-in d'un utilisateur.
     */
    public static function signIn()
    {
        if (User::isAuthenticated()) {
            $registered = User::authenticated();
            Utility::redirect($registered->getProfileLink() . "/posts");
        }

        $error = null;

        if (Action::dataPosted()) {
            
            $connexion = new Connexion("email_address", $_POST["password"], DB_NAME, DB_LOGIN, DB_PASSWORD, User::TABLE_NAME);
            $connexion->execute();

            if ($connexion->getError()) {
                $error = (new NotifyByHTML())->error($connexion->getError(), "app-alert-danger mb-3");
            } else {
                (new Visitor(Session::getVisitor()))->identify($_POST["email_address"]);
                Session::activateRegistered($_POST["email_address"]);
                if (!empty($_POST["remember_me"])) {
                    Cookie::setRegistered($_POST["email_address"]);
                }
                $registered = new Registered($_POST["email_address"]);
                Utility::redirect($registered->getProfileLink());
            }
        }

        $page = new Page("L'indice | Je m'identifie", (new UserView())->signIn($error));
        $page->setDescription("");
        $page->show();
    }

    /**
     * Controller du profil de l'utilisateur.
     * 
     * @param array $routeParams
     */
    public static function userProfile(array $routeParams)
    {
        User::askToAuthenticate("/sign-in");

        $registered = User::authenticated();
        $user = Registered::getByPseudo($routeParams[2]);

        // $page = new Page("L'indice | Profil - " . $user->getFullName());
        // if ($registered->getPseudo() === $user->getPseudo()) {
        //     $view = (new RegisteredView($user))->myProfile();
        // } elseif ($registered->isAdministrator()) {
        //     $view = (new RegisteredView($user))->userProfile();
        // } else {
        //     Utility::redirect($registered->getProfileLink());
        // }

        if ($registered->isAdministrator()) {
            (new Page("L'indice | Profil - " . $user->getFullName(), (new RegisteredView($user))->userProfile()))->show();
        } else {
            Utility::redirect($registered->getProfileLink() . "/posts");
        }

    }

    /**
     * Controller pour afficher tous les comptes.
     */
    public static function users()
    {
        if (User::isAuthenticated()) {
            $registered = User::authenticated();

            if ($registered->isAdministrator()) {
                $users = Registered::getAll();
                $page = new Page("L'indice | Administratrion - Liste des utilisateurs");
                $page->setView((new AdministratorView($registered))->users($users));
                $page->show();
            } else {
                throw new Exception("Ressource non trouvée !");
            }

        } else {
            throw new Exception("Ressource non trouvée !");
        }
    }

    /**
     * Controller pour gérer le dashboard d'un utlisateur.
     */
    public static function dashboard(array $routeParams = null)
    {
        User::askToAuthenticate("/sign-in");
        
        $registered = User::authenticated();
        $user = Registered::getByPseudo($routeParams[2]);
        $page = new Page("L'indice | Tableau de bord - " . $user->getFullName());
        $page->setDescription("");

        if ($registered->getPseudo() === $user->getPseudo() || $registered->isAdministrator()) {
            if (!empty($routeParams[4])) {
                $status = $routeParams[4];

                if (!in_array($status, Announce::getStatutes())) {
                    $announces = [];
                } else {
                    $announces = $user->getAnnounces($status);
                }
            } else {
                $announces = $user->getAnnounces();
            }
    
            $page->setView((new RegisteredView($user))->dashboard($announces));
            $page->setDescription("");
            $page->show();

        } else {
            Utility::redirect($registered->getProfileLink());
        }
    }

    /**
     * Controller de gestion d'un compte utilisateur.
     * 
     * @param array $routeParams
     */
    public static function manage(array $routeParams)
    {
        if (Model::valueIssetInDB("pseudo", $routeParams[2], User::TABLE_NAME)) {
            $registered = User::authenticated();
            $user = Registered::getByPseudo($routeParams[2]);

            // Switch sur l'action.
            switch ($routeParams[3]) {

                case "update" :
                    if ($user->getPseudo() === $routeParams[2]) {
                        $page = new Page("L'indice | " . $user->getFullName() . " - Mise à jour du compte", (new UserView($user))->update());
                    } else {
                        Utility::redirect($registered->getProfileLink());
                    }
                    break;

                case "delete" :
                    if ($user->getPseudo() === $routeParams[2] || $registered->isAdministrator()) {
                        
                    } else {
                        Utility::redirect($registered->getProfileLink());
                    }
                    break;

                default :
                    Utility::redirect($registered->getProfileLink());
                    break;
            }
        } else {
            throw new Exception("La ressource non trouvée !");
        }
    }

    /**
     * Controlleur de mise à jour d'un user.
     */
    public static function update()
    {
        User::askToAuthenticate("sign-in");

        $registered = User::authenticated();

    }

    /**
     * Controller de suppression d'un user.
     */
    public static function delete()
    {
        User::askToAuthenticate("/sign-in");
    }

    /**
     * Controller de gestion de la déconnexion.
     */
    public static function signOut()
    {
        Registered::signOut();
    }
}