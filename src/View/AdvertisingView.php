<?php

namespace App\View;

class AdvertisingView extends View
{
    /**
     * Bloc de code pour la publicité. Elle doit prendre en paramètre une
     * image de taille 300x400.
     * 
     * @return string
     */
    public function advertisementSection()
    {
        return <<<HTML
        <div class="widget">
            <h4 class="widget-title">Publicité</h4>
            <div class="add-box">
                <img class="img-fluid" src="assets/img/img1.jpg" alt="">
            </div>
        </div>
HTML;
    }

    /**
     * Pour cette application, cette méthode permet d'afficher une publicité
     * au dessus de la barre de navigation supérieure.
     * 
     * @return string
     */
    public function top()
    {
        return <<<HTML
        <section class=" advertising top d-flex justify-content-center align-items-center d-none d-lg-block">
            Publicité
        </section>
HTML;
    }
    
    /**
     * Permet d'afficher une publicité les cotés de l'application.
     * 
     * @return string
     */
    public function side()
    {
        return <<<HTML
        <div class="advertising side d-flex justify-content-center align-items-center d-none d-lg-block col-lg-2">
            <span>Publicité</span>
        </div>
HTML;
    }


    /**
     * Permet d'afficher une publicité le cotés gauche de l'application.
     * 
     * @return string
     */
    public function left()
    {
        return <<<HTML
        <aside class="advertising left d-flex justify-content-center align-items-center d-none d-lg-block col-lg-2">
            <span>Publicité</span>
        </aside>
HTML;
    }

    /**
     * Permet d'afficher une publicité le coté droit de l'application.
     * 
     * @return string
     */
    public function right()
    {
        return <<<HTML
        <aside class="advertising right d-flex justify-content-center align-items-center d-none d-lg-block col-lg-2">
            <span>Publicité</span>
        </aside>
HTML;
    }

}