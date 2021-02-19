<?php

namespace App\Controller\UserController;

use App\Action\Action;
use App\Auth\Connexion;
use App\Auth\Cookie;
use App\Auth\Session;
use App\Communication\Notify\NotifyByHTML;
use App\Controller\UserController\AdministratorController;
use App\Controller\AnnounceController;
use App\Model\Announce;
use App\Model\Category;
use App\Model\Model;
use App\Model\User\Registered;
use App\Model\User\User;
use App\Model\User\Visitor;
use App\Utility\Utility;
use App\View\Model\AnnounceView;
use App\View\Model\User\AdministratorView;
use App\View\Model\User\RegisteredView;
use App\View\Model\User\UserView;
use App\View\Page\Page;
use Exception;

class RegisteredController extends VisitorController
{
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

                if ($registered->isAdministrator()) {
                    Utility::redirect("administration/annonces");
                } else {
                    Utility::redirect($registered->getProfileLink() . "/posts");
                }
                
            }
        }

        $page = new Page("L'indice | Je m'identifie", (new UserView())->signIn($error));
        $page->setDescription("");
        $page->show();
    }

    /**
     * Controlleur de création d'une nouvelle annonce.
     */
    public static function post()
    {
        User::askToAuthenticate("/sign-in");
        
        $message = null;
        if (Action::dataPosted()) {
            $message = AnnounceController::create();
        }

        $page = new Page("L'indice | Poster une annonce", (new AnnounceView())->create($message));
        $page->setDescription("");
        $page->show();
    }

    /**
     * Controller permetant l'utilisateur authentifié de
     * de modifier une annonce.
     */
    public static function manageAnnounce(array $params)
    {
        User::askToAuthenticate("/sign-in");

        if (isset($params[1]) && !empty($params[1])
            && isset($params[2]) && !empty($params[2])
            && Category::valueIssetInDB("slug", $params[1], Category::TABLE_NAME)
            && Announce::valueIssetInDB("slug", $params[2], Announce::TABLE_NAME)
        ) {
            $announce = Announce::getBySlug($params[2], Announce::TABLE_NAME, "App\Model\Announce");
            $user = $announce->getOwner();

            if ($announce->hasOwner(User::authenticated()) || User::authenticated()->isAdministrator()) {

                switch ($params[3]) {

                    case "update" :
                        AnnounceController::update($params);
                        break;

                    case "validate" :
                        AnnounceController::validateAnnounce($params);
                        break;

                    case "suspend" :
                        AnnounceController::suspendAnnounce($params);
                        break;

                    case "comment" :
                        AdministratorController::commentAnnounce($announce);
                        break;

                    case "delete" :
                        AnnounceController::delete($announce);
                        break;

                    default :
                        Utility::redirect($user->getProfileLink()."/posts");
                        break;
                }

            } else {
                Utility::redirect(User::authenticated()->getProfileLink()."/posts");
            }

        } else {
            throw new Exception("Ressource non trouvée !");
        }
    }

    /**
     * Controller de l'index de la partie administration pour le registered.
     */
    public static function administrationIndex()
    {
        User::askToAuthenticate("sign-in");

        if (User::authenticated()->isAdministrator()) {
            $view = (new AdministratorView(User::authenticated()))->administrationIndex();
        } else {
            $view = (new RegisteredView(User::authenticated()))->administrationIndex();
        }
        
        $page = new Page("L'indice | " . User::authenticated()->getFullName() . " - Administration", $view);
        $page->show();
    }

    /**
     * Permet d'afficher le profil de l'utilisateur.
     */
    public static function myProfile(array $params)
    {
        User::askToAuthenticate("/sign-in");

        $page = new Page();
        $user = Registered::getByPseudo($params[3]); // $params[3] = pseudo

        if (User::authenticated()->getPseudo() === $user->getPseudo()) {
            $page->setMetatitle("L'indice | Administration - " . $user->getFullName() . " - Mon profil");
            $view = (new RegisteredView($user))->myProfile();
        } elseif (User::authenticated()->isAdministrator()) {
            $page->setMetatitle("L'indice | Administration - " . $user->getFullName() . " - Profil");
            $view = (new AdministratorView(User::authenticated()))->readUserProfile($user);
        } else {
            Utility::redirect($user->getProfileLink());
        }

        $page->setView($view);
        $page->show();
    }

    /**
     * Controller pour gérer le dashboard d'un utlisateur.
     * @param array $params
     */
    public static function myDashboard(array $params = null)
    {
        User::askToAuthenticate("/sign-in");
        
        $user = Registered::getByPseudo($params[3]);
        $page = new Page();

        if (User::authenticated()->getPseudo() === $user->getPseudo() || User::authenticated()->isAdministrator()) {
           
            if (!empty($params[5])) {
                $status = $params[5];

                if (!in_array($status, Announce::getStatutes())) {
                    $announces = [];
                } else {
                    $announces = $user->getAnnounces($status);
                }
            } else {
                $announces = $user->getAnnounces();
            }

            $title = User::authenticated()->getPseudo() === $user->getPseudo() ? $user->getFullName() . " - Mes annonces" : "Les annonces de " . $user->getFullName();

            $page->setMetatitle("L'indice | Administration - " . $title);
            $page->setView(
                (new RegisteredView($user))->dashboard($announces, $title, $user->getFullName() . " / Annonces")
            );
            
            $page->setDescription("Cette page affiche les annonces postées par " . $user->getFullName());
            $page->show();

        } else {
            Utility::redirect(User::authenticated()->getProfileLink());
        }

    }

    /**
     * Controller de gestion d'un compte utilisateur.
     * 
     * @param array $params
     */
    public static function selfManage(array $params)
    {
        if (Model::valueIssetInDB("pseudo", $params[2], User::TABLE_NAME)) {
            $registered = User::authenticated();
            $user = Registered::getByPseudo($params[2]);

            if ($params[3] === "update") {
                self::update($params);
            } elseif ($params[3] === "delete") {
                AdministratorController::deleteUser($user);
            } else {
                Utility::redirect($registered->getProfileLink());
            }

        } else {
            throw new Exception("La ressource non trouvée !");
        }
    }

    /**
     * Controlleur de mise à jour d'un user.
     */
    public static function update(array $params)
    {
        dump($params);
        die();
    }

    /**
     * Controller de gestion de la déconnexion d'un utilisateur authentifié.
     */
    public static function signOut()
    {
        Registered::signOut();
    }
}