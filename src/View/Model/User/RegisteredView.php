<?php

namespace App\View\Model\User;

use App\Communication\Email;
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
     * @param array  $announces
     * @param string $dashboardTitle Le titre du tableau.
     * @param string $current        Pour indiquer à l'utilisateur où il se trouve.
     * 
     * @return string
     */
    public function dashboard(array $announces, string $dashboardTitle, string $current)
    {
        $content = <<<HTML
        <section class="col-12">
            {$this->dashboardTitle($dashboardTitle)}
            {$this->dashboardContent($announces)}
        </section>
HTML;
        return parent::administrationTemplate($content, $current, $current);
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

        <div id="content" class="my-3">
            <div class="container-fluid">
                <div class="row">
                    {$this->sidebarNav(User::authenticated())}
                    <div class="col-sm-12 col-md-8 col-lg-9">
                        C'est mon profil.
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Menu qui sera affiché si l'utilsateur s'est authentifié.
     * 
     * @param App\Model\User\Registered
     * @return string
     */
    public function navbar($registered)
    {
        if (User::isAuthenticated()) {

            $administrationLink = User::authenticated()->isAdministrator()
                ? '<a class="dropdown-item" href="administration/annonces"><i class="lni-dashboard"></i> Administration</a>'
                : null;

            return <<<HTML
            {$administrationLink}
            <a class="dropdown-item" href="{$registered->getProfileLink()}/posts"><i class="lni-dashboard"></i> Mes annonces</a>
            <a class="dropdown-item" href="sign-out"><i class="lni-close"></i> Déconnexion</a>
HTML;
        }
    }

    /**
     * Affiche le menu dans la version mobile pour un utilisateur connecté.
     * 
     * @param App\Model\User\Registered
     * @return string
     */
    public function mobileNavbarForConnectedUser($registered)
    {
        return <<<HTML
        <li><a href="/">Accueil</a></li>
        <li>
            <a>Mon compte</a>
            <ul class="dropdown">
                <li><a href="{$registered->getProfileLink()}"><i class="lni-home"></i> Mon profil</a></li>
                <li><a href="{$registered->getProfileLink()}/posts"><i class="lni-wallet"></i> Mes annonces</a></li>
                <li><a href="sign-out"><i class="lni-close"></i> Déconnexion</a></li>
            </ul>
        </li>
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
                {$this->defineSidebarLink("Déconnexion", "sign-out", "lni-enter")}
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
     * Affiche le titre du tableau qui affiche les announces.
     * 
     * @param string $dashboardTitle Le titre du tableau.
     * 
     * @return string
     */
    private function dashboardTitle(string $dashboardTitle)
    {
        return <<<HTML
        <div class="dashboard-box">
            <h2 class="dashbord-title">{$dashboardTitle}</h2>
        </div>
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
    protected function dashboardTableNav()
    {
        if ($this->user !== null) {
            return <<<HTML
            <nav class="nav-table">
                <ul>
                    {$this->dashbaordNavStatus($this->user->getProfileLink()."/posts", "Tous", $this->user->getAnnounceNumber())}
                    {$this->dashbaordNavStatus($this->user->getProfileLink()."/posts/pending", "En attente", $this->user->getAnnounceNumber("pending"))}
                    {$this->dashbaordNavStatus($this->user->getProfileLink()."/posts/validated", "Validées", $this->user->getAnnounceNumber("validated"))}
                    {$this->dashbaordNavStatus($this->user->getProfileLink()."/posts/blocked", "Bloquées", $this->user->getAnnounceNumber("blocked"))}
                </ul>
            </nav>
HTML;
        } else {
            return <<<HTML
            <nav class="nav-table">
                <ul>
                    {$this->dashbaordNavStatus("/administration/annonces", "Tous", count(Announce::getAll()))}
                    {$this->dashbaordNavStatus("/administration/annonces/pending", "En attente", count(Announce::getPending()))}
                    {$this->dashbaordNavStatus("/administration/annonces/validated", "Validées", count(Announce::getValidated()))}
                    {$this->dashbaordNavStatus("/administration/annonces/blocked", "Bloquées", count(Announce::getSuspended()))}
                </ul>
            </nav>
HTML;
        }
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
            $form = new Form($_SERVER["REQUEST_URI"] . "/delete");
            
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

    /**
     * Message d'accueil qui est envoyé par mail lorsque quelqu'un vient de s'inscrire sur
     * le site.
     * 
     * @return string
     */
    public function welcomeMessage()
    {
        $content = <<<HTML
        <p>Salut {$this->user->getName()}</p>
        <p>
            Nous sommes heureux de vous compter parmi nos abonnés. Nous ferons le nécessaire pour vous
            accompagner et vous fournir dans la mésure du possible ce que vous cherchez par du contenu
            de qualités, des annonces pertinentes en relation avec vos besoins.
        </p>
        <p>
            Vous recevrez régulièrement les nouvelles informations, les tendances, les annonces les plus
            recherchées tout en espérant vous fournir du contenu en relation avec ce que vous recherchez.
        </p>
HTML;
        return Email::content($content);
    }

    /**
     * Affiche l'avatar de l'utilisateur.
     * 
     * @return string
     */
    public function avatar()
    {
        return <<<HTML
        <img src="{$this->user->getAvatarSrc()}" alt="" class="img-fluid"/>
HTML;
    }

    /**
     * Affiche les commnataires laissés par cet utilisateur.
     * 
     * @return string
     */
    public function showComments()
    {
        return <<<HTML
        
HTML;
    }

    /**
     * Affiche le formulaire pour changer le mot de passe.
     * 
     * @return string
     */
    public function changePassword()
    {
        
    }

}