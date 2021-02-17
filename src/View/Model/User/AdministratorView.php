<?php

namespace App\View\Model\User;

use App\View\Snippet;
use App\Model\User\User;

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
    public static function index()
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
        $usersTable = (new UserView())->usersTable($users);

        $content = <<<HTML
        <section class="col-12">
            {$usersTable}
        </section>
HTML;
        return parent::administrationTemplate($content, "Les utilisateurs", "Administration / Utilisateurs");
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

        return <<<HTML
        {$snippet->pageHeader($user->getFullName(), "Utilisateurs / ". $user->getFullName())}

        <div id="content" class="my-3">
            <div class="container-fluid">
                <div class="row">
                    {$this->sidebarNav(User::authenticated())}
                    <div class="col-sm-12 col-md-8 col-lg-9">
                        Profil de {$user->getFullName()}
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Affiche le menu du dashboard de l'utilisateur.
     * 
     * @param App\Model\User\Administrator $administrator 
     * @return string
     */
    public function sidebarLinks($administrator) : string
    {
        return <<<HTML
        <nav class="navdashboard">
            <ul>
                {$this->defineSidebarLink("Voir toutes les annonces", "/administration/annonces", "lni-pencil-alt")}
                {$this->defineSidebarLink("Gérer les utilisateurs", "/administration/users", "lni-users")}
                {$this->defineSidebarLink("Ajouter un compte", "/register", "lni-user")}
                {$this->defineSidebarLink("Mes annonces", $administrator->getProfileLink(). "/posts", "lni-dashboard")}
                {$this->defineSidebarLink("Déconnexion", "sign-out", "lni-enter")}
            </ul>
        </nav>
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

}