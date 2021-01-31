<?php

namespace App\View;

class NewsletterView extends View
{
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

}