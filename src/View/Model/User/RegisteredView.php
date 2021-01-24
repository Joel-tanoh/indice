<?php

namespace App\View\Model\User;

use App\Model\Announce;
use App\Model\User\User;
use App\View\Snippet;
use App\View\Form;
use App\View\Model\AnnounceView;

/**
 * Classe qui gère la vue de l'utilisateur inscrit sur le site.
 */
class RegisteredView extends UserView
{
    protected $user;

    /**
     * Constructeur de la vue du registered.
     * 
     * @param \App\Model\User\Registered $user
     */
    public function __construct(\App\Model\User\Registered $user = null)
    {
        $this->user = $user;
    }

    /**
     * Affiche le dashboard de l'utilisateur.
     * 
     * @param array $announces
     * 
     * @return string
     */
    public function dashboard(array $announces)
    {
        $snippet = new Snippet();

        return <<<HTML
        {$snippet->pageHeader("Mes annonces", "Mes annonces")}
        
        <div id="content" class="section-padding">
            <div class="container">
                <div class="row">
                    {$this->sidebarNav(User::getAuthenticated())}
                    <div class="col-sm-12 col-md-8 col-lg-9">
                        <div class="page-content">
                            <div class="inner-box">
                                <div class="dashboard-box">
                                    <h2 class="dashbord-title">Mes annonces</h2>
                                </div>
                                {$this->dashboardContent($announces)}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Affiche le profile de l'utilisateur, ses statistiques.
     * 
     * @return string
     */
    public function myProfile()
    {
        $snippet = new Snippet;

        return <<<HTML
        {$snippet->pageHeader("Mon profil", "Mon profil")}

        <div id="content" class="section-padding">
            <div class="container">
                <div class="row">
                    {$this->sidebarNav(User::getAuthenticated())}
                    <div class="col-sm-12 col-md-8 col-lg-9">
                        C'est mon profil.
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Vue qui affiche le profile d'un autre utilisateur dont on veut
     * voir le profile.
     * @return string
     */
    public function userProfile()
    {
        $snippet = new Snippet;

        return <<<HTML
        {$snippet->pageHeader($this->user->getFullName(), "Utilisateurs / ". $this->user->getFullName())}

        <div id="content" class="section-padding">
            <div class="container">
                <div class="row">
                    {$this->sidebarNav(User::getAuthenticated())}
                    <div class="col-sm-12 col-md-8 col-lg-9">
                        Profil de {$this->user->getFullName()}
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Menu qui sera affiché si l'utilsateur s'est authentifié.
     * @param App\Model\User\Registered
     * @return string
     */
    public function navbar($registered)
    {
        return <<<HTML
        <a class="dropdown-item" href="{$registered->getProfileLink()}"><i class="lni-user"></i> Mon Profil</a>
        <a class="dropdown-item" href="{$registered->getProfileLink()}/posts"><i class="lni-home"></i> Mes annonces</a>
        <a class="dropdown-item" href="sign-out"><i class="lni-close"></i> Se déconnecter</a>
HTML;
    }

    /**
     * Affiche la sidebar de l'utilisateur afin de lui permettre de naviguer dans 
     * sa session personnelle.
     * 
     * @return string
     */
    public function sidebarNav($registered) : string
    {
        return <<<HTML
        <div class="col-sm-12 col-md-4 col-lg-3 page-sidebar">
            <aside>
                {$this->sidebarContent($registered)}
            </aside>
        </div>
HTML;
    }

    /**
     * Affiche l'avatar et les liens de la sidebar de l'utilisateur.
     * 
     * @param App\Model\User\Registered $registered 
     * @return string
     */
    protected function sidebarContent($registered) : string
    {
        if (User::isAuthenticated()) {
            if ($registered->isAdministrator()) {
                $sidebarLinks = (new AdministratorView())->sidebarLinks($registered);
            } else {
                $sidebarLinks = (new self())->sidebarLinks($registered);
            }
            
            return <<<HTML
            <div class="sidebar-box">
                <div class="user">
                    <figure>
                        <a href="{$registered->getProfileLink()}"><img src="{$registered->getAvatarSrc()}" alt="Image de {$registered->getPseudo()}" title="Mon profil"></a>
                    </figure>
                    <div class="usercontent">
                        <h3><a href="{$registered->getProfileLink()}" class="text-white">{$registered->getFullName()}</a></h3>
                        <h4>{$registered->getType()}</h4>
                    </div>
                </div>
                {$sidebarLinks}
            </div>
HTML;
        }
    }
    
    /**
     * Affiche le menu du dashboard de l'utilisateur.
     * @param App\Model\User\Registered $registered 
     * @return string
     */
    public function sidebarLinks($registered) : string
    {
        return <<<HTML
        <nav class="navdashboard">
            <ul>
                {$this->defineSidebarLink("Mes annonces", $registered->getProfileLink(). "/posts", "lni-dashboard")}
                {$this->defineSidebarLink("Se déconnecter", "sign-out", "lni-enter")}
            </ul>
        </nav>
HTML;
    }

    /**
     * Permet de créer une ligne de lien dans la sidebar du user.
     * 
     * @param string $text
     * @param string $href
     * @param string $iconClass
     * 
     * @return string
     */
    protected function defineSidebarLink(string $text, string $href, string $iconClass = null)
    {
        return <<<HTML
        <li>
            <a href="{$href}">
                <i class="{$iconClass}"></i><span>{$text}</span>
            </a>
        </li>
HTML;
    }

    /**
     * Affiche le contenu du tableau.
     * 
     * @param array $announces
     * 
     * @return string
     */
    protected function dashboardContent(array $announces)
    {
        return <<<HTML
        <div class="dashboard-wrapper">
            {$this->dashboardTableNav()}
            {$this->dashboardContentTable($announces)}
        </div>
HTML;
    }

    /**
     * Affiche des boutons pour filtrer les annonces à afficher
     * dans le dashboard.
     * 
     * @return string
     */
    protected function dashboardTableNav()
    {
        return <<<HTML
        <nav class="nav-table">
            <ul>
                {$this->dashbaordNavStatus($this->user->getProfileLink()."/posts", "Tous", $this->user->getAnnounceNumber())}
                {$this->dashbaordNavStatus($this->user->getProfileLink()."/posts/pending", "En attente", $this->user->getAnnounceNumber("pending"))}
                {$this->dashbaordNavStatus($this->user->getProfileLink()."/posts/validated", "Validées", $this->user->getAnnounceNumber("validated"))}
                {$this->dashbaordNavStatus($this->user->getProfileLink()."/posts/premium", "Premium", $this->user->getAnnounceNumber("premium"))}
                {$this->dashbaordNavStatus($this->user->getProfileLink()."/posts/blocked", "Bloquées", $this->user->getAnnounceNumber("blocked"))}
            </ul>
        </nav>
HTML;
    }

    /**
     * Affiche un bouton sur le dahsboard de l'utilisateur pour lui permettre de 
     * filter le résultat.
     * 
     * @return string
     */
    public function dashbaordNavStatus(string $href, string $text, int $nbr)
    {
        return <<<HTML
        <li><a href="{$href}">{$text} ({$nbr})</a></li>
HTML;
    }

    /**
     * Affiche le tableau dans lequel les annonces sont affichées
     * sur le dashboard.
     * 
     * @param array $announces
     * 
     * @return string
     */
    protected function dashboardContentTable(array $announces)
    {
        if (!empty($announces)) {
            $form = new Form($_SERVER["REQUEST_URI"] . "/announces/delete");
            
            return <<<HTML
            {$form->open()}
                <table class="table table-responsive dashboardtable tablemyads">
                    {$this->dashboardContentTableHead()}
                    {$this->dashboardContentTableBody($announces)}
                </table>
            {$form->close()}
HTML;
        } else {
            return AnnounceView::noAnnounces();
        }
    }

    /**
     * Affiche le head du tableau qui donne les annonces 
     * dans le dashboard.
     * 
     * @return string
     */
    protected function dashboardContentTableHead()
    {
        return <<<HTML
        <thead>
            <tr>
                <th>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="checkedall">
                        <label class="custom-control-label" for="checkedall"></label>
                    </div>
                </th>
                <th>Photo</th>
                <th>Titre</th>
                <th>Catégorie</th>
                <th>Statut</th>
                <th>Prix</th>
                <th>Actions</th>
            </tr>
        </thead>
HTML;
    }

    /**
     * Affiche le contenu du tableau qui liste les annonces.
     * 
     * @param array $announces
     * 
     * @return string
     */
    protected function dashboardContentTableBody(array $announces)
    {
        $rows = null;
        foreach ($announces as $announce) {
            $rows .= (new AnnounceView($announce))->registeredDashboardRow();
        }

        return <<<HTML
        <tbody>
            {$rows}
        </tbody>
HTML;
    }

}