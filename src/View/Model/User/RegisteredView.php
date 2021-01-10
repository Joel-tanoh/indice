<?php

namespace App\View\Model\User;

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
        {$snippet->pageHeader("Mon Tableau de Bord", "Tableau de bord")}
        
        <div id="content" class="section-padding">
            <div class="container">
                <div class="row">
                    {$this->sidebar()}
                    <div class="col-sm-12 col-md-8 col-lg-9">
                        <div class="page-content">
                            <div class="inner-box">
                                <div class="dashboard-box">
                                    <h2 class="dashbord-title">Tableau de bord</h2>
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
    public function profile()
    {
        $snippet = new Snippet;

        return <<<HTML
        {$snippet->pageHeader("Mon Tableau de Bord", "Tableau de bord")}

        <div id="content" class="section-padding">
            <div class="container">
                <div class="row">
                    {$this->sidebar()}
                    <div class="col-sm-12 col-md-8 col-lg-9">
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Affiche la sidebar de l'utilisateur afin de lui permettre de naviguer dans 
     * sa session personnelle.
     * 
     * @return string
     */
    public function sidebar() : string
    {
        return <<<HTML
        <div class="col-sm-12 col-md-4 col-lg-3 page-sidebar">
            <aside>
                {$this->sidebarContent()}
            </aside>
        </div>
HTML;
    }

    /**
     * Menu qui sera affiché si l'utilsateur s'est authentifié.
     * 
     * @return string
     */
    public function navbar()
    {
        return <<<HTML
        <a class="dropdown-item" href="users/me/dashboard"><i class="lni-home"></i> Tableau de bord</a>
        <a class="dropdown-item" href="sign-out"><i class="lni-close"></i>Se déconnecter</a>
HTML;
    }

    /**
     * Affiche l'avatar et les liens de la sidebar de l'utilisateur.
     * 
     * @return string
     */
    private function sidebarContent() : string
    {
        return <<<HTML
        <div class="sidebar-box">
            <div class="user">
                <figure>
                    <a href="users/me/profile"><img src="{$this->registered->getAvatarSrc()}" alt="Image de {$this->registered->getPseudo()}" title="Mon profil"></a>
                </figure>
                <div class="usercontent">
                    <h3>{$this->registered->getName()}</h3>
                    <h4>{$this->registered->getType()}</h4>
                </div>
            </div>
            {$this->sidebarLinks()}
        </div>
HTML;
    }
    
    /**
     * Affiche le menu du dashboard de l'utilisateur.
     * 
     * @return string
     */
    private function sidebarLinks() : string
    {
        return <<<HTML
        <nav class="navdashboard">
            <ul>
                {$this->defineSidebarLink("Tableau de bord", "users/me/dashboard", "lni-dashboard")}
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
                <i class="{$iconClass}"></i>
                <span>{$text}</span>
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
                {$this->dashbaordNavStatus("users/me/dashboard", "Tous", $this->registered->countBy("id", Announce::TABLE_NAME))}
                {$this->dashbaordNavStatus("users/me/dashboard/pending", "En attente", $this->registered->countBy("id", Announce::TABLE_NAME, "status", Announce::convertStatus("pending")))}
                {$this->dashbaordNavStatus("users/me/dashboard/validated", "Validées", $this->registered->countBy("id", Announce::TABLE_NAME, "status", Announce::convertStatus("validated")))}
                {$this->dashbaordNavStatus("users/me/dashboard/featured", "Vedette", $this->registered->countBy("id", Announce::TABLE_NAME, "status", Announce::convertStatus("featured")))}
                {$this->dashbaordNavStatus("users/me/dashboard/premium", "Prémium", $this->registered->countBy("id", Announce::TABLE_NAME, "status", Announce::convertStatus("premium")))}
                {$this->dashbaordNavStatus("users/me/dashboard/blocked", "Bloquées", $this->registered->countBy("id", Announce::TABLE_NAME, "status", Announce::convertStatus("blocked")))}
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