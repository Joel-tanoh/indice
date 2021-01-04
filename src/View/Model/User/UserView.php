<?php

namespace App\View\Model\User;

use App\Model\User\User;
use App\View\AdvertisingView;
use App\View\Form;
use App\View\Model\ModelView;
use App\View\Snippet;

/**
 * Classe de gestion des vues de User.
 */
class UserView extends ModelView
{
    private $user;

    /**
     * Constructeur de la vue du user.
     * 
     * @param \App\Model\User\User $user
     */
    public function __construct(\App\Model\User\User $user = null)
    {
        $this->user = $user;
    }

    /**
     * Vue de la connexion.
     * 
     * @param string $error
     * 
     * @return string
     */
    public function connexion(string $error = null)
    {
        $form = new Form($_SERVER["REQUEST_URI"], "login-form", false, "post", "login-form", "form");
        $snippet = new Snippet();

        return <<<HTML
        {$snippet->pageHeader("Se connecter", "connexion")}
        <!-- Content section Start --> 
        <section class="login section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-12 col-xs-12">
                        {$error}
                        <div class="login-form login-area">
                            <h3>
                                Connectez-vous maintenant !
                            </h3>
                            {$form->open()}
                                <div class="form-group">
                                    <div class="input-icon">
                                        <i class="lni-user"></i>
                                        <input type="text" id="sender-email" class="form-control" name="email_address" placeholder="Adresse email">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <div class="input-icon">
                                        <i class="lni-lock"></i>
                                        <input type="password" class="form-control" placeholder="Mot de passe" name="password">
                                    </div>
                                </div>                  
                                <div class="form-group mb-3">
                                    <div class="checkbox">
                                        <input type="checkbox" name="remember_me" value="yes" id="remember_me">
                                        <label for="remember_me">Me reconnaître</label>
                                    </div>
                                    {$this->forgotPassword()}
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-common log-btn">Se connecter</button>
                                </div>
                            {$form->close()}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Content section End --> 
    
HTML;
    }

    /**
     * Vue pour la création d'un compte.
     * 
     * @param string $message
     * 
     * @return string
     */
    public static function suscribe(string $message = null)
    {
        $snippet = new Snippet();
        $form = new Form($_SERVER["REQUEST_URI"], "login-form", true);

        return <<<HTML
        {$snippet->pageHeader("Je m'inscris", "inscription")}
        {$message}
        
        <!-- Content section Start --> 
        <section class="register section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-12 col-xs-12">
                        <div class="register-form login-area">
                            <h3>
                                Inscription
                            </h3>
                            {$form->open()}
                                <div class="form-group">
                                    <div class="input-icon">
                                        <i class="lni-user"></i>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="Nom">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <div class="input-icon">
                                        <i class="lni-user"></i>
                                        <input type="text" id="first_names" class="form-control" name="first_names" placeholder="Prénoms">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <div class="input-icon">
                                        <i class="lni-user"></i>
                                        <input type="text" id="pseudo" class="form-control" name="pseudo" placeholder="Pseudo">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <div class="input-icon">
                                        <i class="lni-envelope"></i>
                                        <input type="email" id="sender-email" class="form-control" name="email_address" placeholder="Adresse email">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <div class="input-icon">
                                        <i class="lni-lock"></i>
                                        <input type="password" class="form-control" placeholder="Entre votre mot de passe" name="password">
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <div class="input-icon">
                                        <i class="lni-lock"></i>
                                        <input type="password" class="form-control" placeholder="Confirmer le mot de passe" name="confirm_password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon">
                                        <i class="lni-phone"></i>
                                        <input type="text" id="phone_number" class="form-control" name="phone_number" placeholder="Numéro de téléphone">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <div class="input-icon">
                                        <label for="avatar">Charger votre avatar :</label>
                                        <i class="lni-file"></i>
                                        <input type="file" id="avatar" class="form-control" name="avatar">
                                    </div>
                                </div> 
                                <div class="form-group mb-3">
                                    <div class="checkbox">
                                        <input type="checkbox" name="accept_condition" value="yes" id="accept_condition" required>
                                        <label for="accept_condition">J'accepte les conditions d'utilisations</label>
                                    </div>
                                </div>   
                                <div class="text-center">
                                    <button class="btn btn-common log-btn">Envoyer</button>
                                </div>
                            {$form->close()}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Content section End --> 
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
        $advertisingView = new AdvertisingView();

        return <<<HTML
        <div class="col-sm-12 col-md-4 col-lg-3 page-sidebar">
            <aside>
                {$this->userSidebarLinks()}
                {$advertisingView->advertisementSection()}
            </aside>
        </div>
HTML;
    }

    /**
     * La section qui permet à l'utilisateur de s'abonner à la newsletter.
     * 
     * @return string
     */
    public function suscribeNewsletterSection()
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
                                <input class="form-control" name="email_address" placeholder="Votre email ici" required type="email">
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
        <a class="dropdown-item" href="user/dashboard"><i class="lni-home"></i> Tableau de bord</a>
        <a class="dropdown-item" href="in-progress"><i class="lni-wallet"></i> Mes annonces</a>
        <a class="dropdown-item" href="disconnexion"><i class="lni-close"></i>Se déconnecter</a>
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
        <a class="dropdown-item" href="suscribe"><i class="lni-user"></i> S'inscire</a>
        <a class="dropdown-item" href="connexion"><i class="lni-lock"></i> Se connecter</a>
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
                {$this->defineSidebarLink("Tableau de bord", "in-progress", "lni-dashboard")}
                {$this->defineSidebarLink("Mes annonces", "in-progress", "lni-layers")}
                {$this->defineSidebarLink("Se déconnecter", "in-progress", "lni-enter")}
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
     * Affiche un lien pour aider ceux qui ont oublié leur mot de passe.
     * 
     * @return string
     */
    private function forgotPassword()
    {
        $text = '<a class="forgetpassword" href="forgot-password.html">Mot de passe oublié ?</a>';
    }

}