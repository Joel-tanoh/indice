<?php

namespace App\View\Model\User;

use App\Auth\Cookie;
use App\Auth\Session;
use App\Model\Announce;
use App\Model\User\Registered;
use App\View\Snippet;
use App\View\Form;
use App\View\Model\AnnounceView;

/**
 * Classe qui gère la vue de l'utilisateur inscrit sur le site.
 */
class RegisteredView extends UserView
{
    private $registered;

    /**
     * Constructeur de la vue du registered.
     * 
     * @param \App\Model\User\Registered $registered
     */
    public function __construct(\App\Model\User\Registered $registered = null)
    {
        $this->registered = $registered;
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
                    {$this->sidebarNav(new Registered(Session::get() ?? Cookie::get()))}
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
                    {$this->sidebarNav(new Registered(Session::get() ?? Cookie::get()))}
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
        return <<<HTML
        Le profil d'un autre utilisateur.
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
     * Affiche l'avatar et les liens de la sidebar de l'utilisateur.
     * @param App\Model\User\Registered $registered 
     * @return string
     */
    private function sidebarContent($registered) : string
    {
        return <<<HTML
        <div class="sidebar-box">
            <div class="user">
                <figure>
                    <a href="{$registered->getProfileLink()}"><img src="{$registered->getAvatarSrc()}" alt="Image de {$registered->getPseudo()}" title="Mon profil"></a>
                </figure>
                <div class="usercontent">
                    <h3><a href="{$registered->getProfileLink()}" class="text-white">{$registered->getName()} {$registered->getFirstNames()}</a></h3>
                    <h4>{$registered->getType()}</h4>
                </div>
            </div>
            {$this->sidebarLinks($registered)}
        </div>
HTML;
    }
    
    /**
     * Affiche le menu du dashboard de l'utilisateur.
     * @param App\Model\User\Registered $registered 
     * @return string
     */
    private function sidebarLinks($registered) : string
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
    private function defineSidebarLink(string $text, string $href, string $iconClass = null)
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
    private function dashboardContent(array $announces)
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
    private function dashboardTableNav()
    {
        return <<<HTML
        <nav class="nav-table">
            <ul>
                {$this->dashbaordNavStatus($this->registered->getProfileLink()."/posts", "Tous", $this->registered->countAnnounces())}
                {$this->dashbaordNavStatus($this->registered->getProfileLink()."/posts/pending", "En attente", $this->registered->countAnnounces(Announce::convertStatus("pending")))}
                {$this->dashbaordNavStatus($this->registered->getProfileLink()."/posts/validated", "Validées", $this->registered->countAnnounces(Announce::convertStatus("validated")))}
                {$this->dashbaordNavStatus($this->registered->getProfileLink()."/posts/featured", "Vedette", $this->registered->countAnnounces(Announce::convertStatus("featured")))}
                {$this->dashbaordNavStatus($this->registered->getProfileLink()."/posts/premium", "Prémium", $this->registered->countAnnounces(Announce::convertStatus("premium")))}
                {$this->dashbaordNavStatus($this->registered->getProfileLink()."/posts/blocked", "Bloquées", $this->registered->countAnnounces(Announce::convertStatus("blocked")))}
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
    private function dashboardContentTable(array $announces)
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
    private function dashboardContentTableHead()
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
    private function dashboardContentTableBody(array $announces)
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