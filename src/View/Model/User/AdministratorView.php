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
     * Affiche les utilisateurs.
     * @author Joel-tanoh
     * @return string
     */
    public function users(array $users)
    {
        $snippet = new Snippet();
        $usersTable = (new UserView())->usersTable($users);

        return <<<HTML
        {$snippet->pageHeader("Les Utilisateurs", "Les Utilisateurs")}
        
        <div id="content" class="section-padding">
            <div class="container">
                <div class="row">
                    {$this->sidebarNav(User::authenticated())}
                    <section class="col-sm-12 col-md-8 col-lg-9">
                        <div class="page-content">
                            <div class="inner-box">
                                {$usersTable}
                            </div>
                        </div>
                    </section>
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
                {$this->defineSidebarLink("Mes annonces", $administrator->getProfileLink(). "/posts", "lni-dashboard")}
                <!-- {$this->defineSidebarLink("Créer une catégorie", "/category/add", "lni-plus")} -->
                {$this->defineSidebarLink("Gérer les comptes", "/users", "lni-users")}
                {$this->defineSidebarLink("Ajouter un compte", "/register", "lni-user")}
                {$this->defineSidebarLink("Déconnexion", "sign-out", "lni-enter")}
            </ul>
        </nav>
HTML;
    }

}