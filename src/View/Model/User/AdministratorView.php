<?php

namespace App\View\Model\User;

use App\Model\User\Registered;
use App\View\Snippet;
use App\Model\User\User;
use App\View\Page\SideBar;

/**
 * Classe de gestion de la vue pour l'administrateur.
 */
class AdministratorView extends RegisteredView
{   
    /**
     * Constructeur de la vue du registered.
     * 
     * @param \App\Model\User\Administrator $user
     */
    public function __construct(\App\Model\User\Administrator $user = null)
    {
        parent::__construct($user);
    }

    /**
     * Vue d'accueil de l'administrateur dans la partie administration.
     * 
     * @return string
     */
    public function administrationIndex()
    {
        return <<<HTML

HTML;
    }

    /**
     * Affiche les utilisateurs.
     * @author Joel-tanoh
     * @return string
     */
    public function readUsers(array $users)
    {
        return parent::administrationTemplate((new RegisteredView())->list($users), "Les utilisateurs", "Administration / Utilisateurs");
    }
    
    /**
     * Vue qui affiche le profile d'un autre utilisateur dont on veut
     * voir le profile.
     * @param \App\Model\User\Registered $user
     * @return string
     */
    public function readUserProfile(\App\Model\User\Registered $user)
    {
        $snippet = new Snippet;
        $sidebar = new Sidebar;

        return <<<HTML
        {$snippet->pageHeader($user->getFullName(), "Utilisateurs / ". $user->getFullName())}

        <div id="content" class="my-3">
            <div class="container-fluid">
                <div class="row">
                    {$sidebar->sidebarNav()}
                    <div class="col-sm-12 col-md-8 col-lg-9">
                        Profil de {$user->getFullName()}
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Affiche la liste des annonces pour que l'administrateur puisse les manager.
     * 
     * @return string
     */
    public static function readAnnounces(array $announces)
    {
        $administratorView = new self();
        return $administratorView->dashboard($announces, "Toutes les annonces", "Gestion des annonces");
    }

    /**
     * Permet à l'administrateur de voir les statistiques du site.
     * 
     * @return string
     */
    public static function readStatistics()
    {

    }

    /**
     * Affiche les commentaires postés par cet utilisateur.
     * 
     * @return string
     */
    public function showComments()
    {
        return <<<HTML
        
HTML;
    }

}