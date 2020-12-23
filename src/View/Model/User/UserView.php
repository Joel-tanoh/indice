<?php

namespace App\View\Model\User;

use App\Model\User;
use App\View\Model\ModelView;
use App\View\Snippet;
use phpDocumentor\Reflection\Types\String_;

/**
 * Classe de gestion des vues de User.
 */
class UserView extends ModelView
{
    private $user;

    /**
     * Constructeur de la vue du user.
     * 
     * @param \App\Model\User $user
     */
    public function __construct(\App\Model\User $user = null)
    {
        $this->user = $user;
    }

    /**
     * Vue de la connexion.
     * 
     * @return string
     */
    public static function userConnexion()
    {
        return <<<HTML
        Vue pour la connexion d'un utilisateur
HTML;
    }

    /**
     * Vue pour la création d'un compte.
     * 
     * @return string
     */
    public static function createAccount()
    {
        return <<<HTML
        Vue pour la création d'un compte utilisateur.
HTML;
    }

    /**
     * Affiche le menu des utilisateurs.
     * 
     * @return string
     */
    public function navbarMenu()
    {
        if (User::isConnected()) {
            $content = $this->menuForConnectedUser();
        } else {
            $content = $this->menuForUnconnectedUser();
        }

        return <<<HTML
        <ul class="sign-in">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="lni-user"></i> Mon compte</a>
                <div class="dropdown-menu">
                    {$content}                    
                </div>
            </li>
        </ul>
HTML;
    }

    /**
     * Affiche la sidebar de l'utilisateur afin de lui permettre de naviguer dans 
     * sa session personnelle.
     * 
     * @return string
     */
    public function userSidebar() : string
    {
        $snippet = new Snippet();

        return <<<HTML
        <div class="col-sm-12 col-md-4 col-lg-3 page-sidebar">
            <aside>
                {$this->userSidebarLinks()}
                {$snippet->advertisementSection()}
            </aside>
        </div>
HTML;
    }

    /**
     * La section qui permet à l'utilisateur de s'abonner à la newsletter
     * 
     * @return string
     */
    public function suscribeSection()
    {
        return <<<HTML
        <section class="subscribes section-padding">
            <div class="container">
                <div class="row wrapper-sub">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <p>Rejoignez nos plus de 10000 abonnés et accédez aux derniers modèles, cadeaux, annonces et ressources!</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <form method="" action="">
                            <div class="subscribe">
                                <input class="form-control" name="EMAIL" placeholder="Votre email ici" required="" type="email">
                                <button class="btn btn-common" type="submit">S'inscrire</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
HTML;
    }

    /**
     * Cta Section. Section qui présente un peu la pub du site.
     * 
     * @return string
     */
    public function ctaSection()
    {
        return <<<HTML
        <!-- Cta Section Start -->
        <section class="cta section-padding">
            <div class="container">
                    <div class="row">
                    <div class="col-xs-12 col-md-6 col-lg-4">
                        <div class="single-cta">
                            <div class="cta-icon">
                                <i class="lni-grid"></i>
                            </div>
                            <h4>Refreshing Design</h4>
                            <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie</p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6 col-lg-4">
                        <div class="single-cta">
                            <div class="cta-icon">
                                <i class="lni-brush"></i>
                            </div>
                            <h4>Easy to Customize</h4>
                            <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie</p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6 col-lg-4">
                        <div class="single-cta">
                            <div class="cta-icon">
                                <i class="lni-headphone-alt"></i>
                            </div>
                            <h4>24/7 Support</h4>
                            <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Cta Section End -->
HTML;
    }

    /**
     * Menu qui sera affiché si l'utilsateur s'est authentifié.
     * 
     * @return string
     */
    private function menuForConnectedUser()
    {
        return <<<HTML
        <a class="dropdown-item" href="account-profile-setting.html"><i class="lni-home"></i> Mon profil</a>
        <a class="dropdown-item" href="account-myads.html"><i class="lni-wallet"></i> Mes annonces</a>
        <a class="dropdown-item" href="account-close.html"><i class="lni-close"></i>Se déconnecter</a>
HTML;
    }

    /**
     * Menu qui sera affiché si l'utilisateur n'est pas encore authentifé.
     * 
     * @return string
     */
    private function menuForUnconnectedUser()
    {
        return <<<HTML
        <a class="dropdown-item" href="login.html"><i class="lni-lock"></i> Se connecter</a>
        <a class="dropdown-item" href="signup.html"><i class="lni-user"></i> S'inscire</a>
HTML;
    }

    /**
     * Affiche l'avatar et les liens de la sidebar de l'utilisateur.
     * 
     * @return string
     */
    private function userSidebarLinks() : string
    {
        return <<<HTML
        <div class="sidebar-box">
            <div class="user">
                <figure>
                    <a href="#"><img src="assets/img/author/img1.jpg" alt=""></a>
                </figure>
                <div class="usercontent">
                    <h3>Nom de l'utilisateur</h3>
                    <h4>Type d'utilisateur</h4>
                </div>
            </div>
            {$this->dashboardMenu()}
        </div>
HTML;
    }
    
    /**
     * Affiche le menu du dashboard de l'utilisateur.
     * 
     * @return string
     */
    private function dashboardMenu() : string
    {
        return <<<HTML
        <nav class="navdashboard">
            <ul>
                {$this->defineSidebarLink("Tableau de bord", "me/dashboard", "lni-dashboard")}
                {$this->defineSidebarLink("Mes annonces", "me/posts", "lni-layers")}
                {$this->defineSidebarLink("Se déconnecter", "disconnect", "lni-enter")}
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

}