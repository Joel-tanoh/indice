<?php

namespace App\Communication\SocialNetwork;

abstract class SocialNetwork
{
    /**
     * Retourne le script.
     */
    public static function script()
    {
        return <<<HTML
        <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=6019d0cb4ab17d001285f40d&product=inline-share-buttons" async="async"></script>
HTML;
    }

    /**
     * Permet d'afficher les boutons pour partager sur les réseaux sociaux.
     * 
     * @return string
     */
    public static function shareThis()
    {
        return <<<HTML
        <div class="sharethis-inline-share-buttons"></div>
HTML;
    }
}