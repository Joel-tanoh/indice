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
        $usersTable = (new UserView())->usersTable($users);

        $content = <<<HTML
        <section class="col-12">
            {$usersTable}
        </section>
HTML;
        return parent::administration($content, "Les utilisateurs", "Administration / Utilisateurs");
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
    public static function announces(array $announces)
    {
        $administratorView = new self();

        return $administratorView->dashboard($announces, "Toutes les annonces", "Gérer les annonces");
    }

}