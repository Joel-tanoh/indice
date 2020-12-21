<?php

namespace App\View\Model\User;

use App\View\Model\ModelView;

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
     * Cta Section
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
}