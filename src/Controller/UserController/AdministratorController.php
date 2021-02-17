<?php

namespace App\Controller\UserController;

use App\Action\Action;
use App\Communication\Comment;
use App\Communication\Notify\NotifyByMail;
use App\Controller\UserController\RegisteredController;
use App\Model\Announce;
use App\Model\User\Registered;
use App\Model\User\User;
use App\Utility\Utility;
use App\View\Model\User\AdministratorView;
use App\View\Page\Page;
use App\View\View;
use Exception;

abstract class AdministratorController extends RegisteredController
{
    /**
     * Controller de l'index de la partie administration pour l'administrateur.
     */
    public static function index()
    {

    }

    /**
     * Controller qui permet de gérer les annonces.
     * 
     * @param array $params
     * @return void
     */
    public static function readAnnnounces(array $params = null)
    {
        if (empty($params)) {
            $announces = Announce::getAll();
        } else {
            $announces = [];
        }

        $page = new Page("L'indice | Administration - Gérer les annonces", AdministratorView::readAnnounces($announces));
        $page->show();
    }

    /**
     * Controller du profil de l'utilisateur.
     * 
     * @param \App\Model\User\Registered $user
     * @return void
     */
    public static function readUser(\App\Model\User\Registered $user)
    {
        User::askToAuthenticate("/sign-in");

        $registered = User::authenticated();

        if ($registered->isAdministrator()) {
            (new Page("L'indice | Profil - " . $user->getFullName(), (new AdministratorView($registered))->readUserProfile($user)))->show();
        } else {
            Utility::redirect($registered->getProfileLink() . "/posts");
        }
    }
    
    /**
     * Controller pour afficher tous les comptes.
     * @return void
     */
    public static function readUsers(array $params = null)
    {
        if (User::isAuthenticated()) {
            $registered = User::authenticated();

            if ($registered->isAdministrator()) {
                $users = Registered::getAll();
                $page = new Page("L'indice | Administratrion - Liste des utilisateurs");
                $page->setView((new AdministratorView($registered))->readUsers($users));
                $page->show();
            } else {
                throw new Exception("Ressource non trouvée !");
            }

        } else {
            throw new Exception("Ressource non trouvée !");
        }
    }
    
    /**
     * Controller de suppression d'un user.
     * @param \App\Model\User\Registered $user
     * @return void
     */
    public static function deleteUser(\App\Model\User\Registered $user)
    {
        echo "Nous voulons supprimer un utilisateur";
        dump($user);
    }

    /**
     * Controller de suppression de plusieurs utilisateurs.
     * @param array $params
     * @return void
     */
    public static function deleteUsers(?array $params = null)
    {
        
    }

    /**
     * Permet à un administrateur de commenter une annonce.
     * @param \App\Model\Announce $announce
     */
    public static function commentAnnounce(\App\Model\Announce $announce)
    {
        $page = new Page();

        if (User::authenticated()->isAdministrator() && Action::dataPosted()) {
            if(User::authenticated()->comment($announce->getId(), htmlspecialchars(trim($_POST["comment"])), Announce::TABLE_NAME)) {
                
                NotifyByMail::user(
                    $announce->getOwner()->getEmailAddress(), 
                    "L'indice, une nouvelle suggestion sur votre annonce.",
                    Comment::emailContent($announce->getTitle(), trim($_POST["comment"]), $announce->getLink("all"))
                );
                
                $page->setMetatitle("L'indice | Commentaire envoyé avec succès");
                $page->setView(
                    View::success(
                        "Commentaire envoyé avec succès",
                        "Le commentaire a été posté avec succès, l'utilisateur sera informé. Merci !",
                        $announce->getLink()
                    )
                );
                $page->show();
            }
        } else {
            Utility::redirect($_SERVER["HTTP_REFERER"]);
        }
    }

}