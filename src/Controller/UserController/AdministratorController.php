<?php

namespace App\Controller\UserController;

use App\Action\Action;
use App\Communication\Comment;
use App\Communication\Notify\NotifyByMail;
use App\Controller\UserController\RegisteredController;
use App\Model\Post\Announce;
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
     * Controller qui permet de gérer les annonces.
     * 
     * @param array $params
     * @return void
     */
    public static function administrateAnnounces(array $params = null)
    {
        if (empty($params)) {
            $announces = Announce::getAll();
        } else {
            $announces = Announce::getAll(null, $params[3]);
        }

        $page = new Page("Administration - Gérer les annonces &#149; L'indice", AdministratorView::readAnnounces($announces));
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
            (new Page("Profil - " . $user->getFullName(). " &#149; L'indice", (new AdministratorView($registered))->readUserProfile($user)))->show();
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
        User::askToAuthenticate("/sign-in");

        if (User::authenticated()->isAdministrator()) {
            $users = Registered::getAll();
            $page = new Page("Administration - Liste des utilisateurs &#149; L'indice");
            $page->setView((new AdministratorView(User::authenticated()))->readUsers($users));
            $page->show();
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
     * @param \App\Model\Post\Announce $announce
     */
    public static function commentAnnounce(\App\Model\Post\Announce $announce)
    {
        $page = new Page();

        if (User::authenticated()->isAdministrator() && Action::dataPosted()) {
            if(User::authenticated()->comment($announce->getId(), htmlspecialchars(trim($_POST["comment"])), Announce::TABLE_NAME)) {
                
                NotifyByMail::user(
                    $announce->getOwner()->getEmailAddress(), 
                    "L'indice, une nouvelle suggestion sur votre annonce.",
                    Comment::emailContent($announce->getTitle(), trim($_POST["comment"]), $announce->getLink("all"))
                );
                
                $page->setMetatitle("Suggestion envoyé avec succès &#149; L'indice");
                $page->setView(
                    View::success(
                        "Suggestion envoyée avec succès",
                        "La suggestion a été postée avec succès, l'utilisateur sera informé. Merci !",
                        "Retour",
                        $announce->getLink(),
                        "Suggestion"
                    )
                );
                $page->show();
            }
        } else {
            Utility::redirect($_SERVER["HTTP_REFERER"]);
        }
    }

}