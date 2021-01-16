<?php

namespace App\View\Model\User;

use App\Auth\Cookie;
use App\Auth\Session;
use App\Model\User\Registered;
use App\Model\User\User;
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
     * Vue pour la création d'un compte.
     * 
     * @param string $message
     * 
     * @return string
     */
    public static function register(string $message = null)
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
     * Vue de la connexion.
     * 
     * @param string $error
     * 
     * @return string
     */
    public function signIn(string $error = null)
    {
        $form = new Form($_SERVER["REQUEST_URI"], "login-form", false, "post", "login-form", "form");
        $snippet = new Snippet();

        return <<<HTML
        {$snippet->pageHeader("S'identifier", "S'identifier")}
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
                                        <label for="remember_me">Me reconnaître.</label>
                                    </div>
                                    <!-- {$this->forgotPassword()} -->
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
     * Affiche le navbar des utilisateurs.
     * 
     * @return string
     */
    public function navbarMenu()
    {
        if (User::isAuthentified()) {
            $registered = new Registered(Session::get() ?? Cookie::get());
            $content = (new RegisteredView())->navbar($registered);
        } else {
            $content = $this->navbarForUnconnectedUser();
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
     * La section qui permet au visiteur de s'abonner à la newsletter.
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
     * Menu qui sera affiché si l'utilisateur n'est pas encore authentifé.
     * 
     * @return string
     */
    private function navbarForUnconnectedUser()
    {
        return <<<HTML
        <a class="dropdown-item" href="register"><i class="lni-user"></i> S'inscire</a>
        <a class="dropdown-item" href="sign-in"><i class="lni-lock"></i> S'identifier</a>
HTML;
    }

    /**
     * Affiche un lien pour aider ceux qui ont oublié leur mot de passe.
     * 
     * @return string
     */
    private function forgotPassword()
    {
        return '<a class="forgetpassword" href="forgot-password">Mot de passe oublié ?</a>';
    }

    /**
     * Affiche les commenataires laissés par cet utilisateur.
     * 
     * @return string
     */
    public function showComments()
    {
        return <<<HTML

HTML;
    }

}