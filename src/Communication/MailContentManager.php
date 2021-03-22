<?php

namespace App\Communication;

use App\File\Image\Logo;

/**
 * Gestionnaire des contenus de mail.
 */
class MailContentManager
{
    /**
     * Contenu de l'email de notification de changement du mot de passe.
     * 
     * @param \App\Model\User\Registered $user
     * @param string $password 
     * 
     * @return string
     */
    public static function passwordChanged(\App\Model\User\Registered $user, string $password)
    {
        return <<<HTML
        <p>Bonjour {$user->getName()}</p>
        <p>Nous vous informons que votre mot de passe a été modifié. <br>
        Votre nouveau mot de passe est : $password
        </p>
        
HTML;
    }

    /**
     * Permet de formater le contenu de l'email avec des propriétés CSS.
     * 
     * @return string
     */
    public static function contentFormater(string $content)
    {
        $head = self::appMailHeader();
        $foot = self::appEmailFooter();

        return <<<HTML
        <section style="text-align:justify; width:80%; background-color:white">
            {$head}
            <div style="text-align:justify; padding:1.5rem">
                {$content}
            </div>
            {$foot}
        </section>
HTML;
    }

    /**
     * Entête de l'email.
     * 
     * @return string
     */
    public static function appMailHeader()
    {
        $logoSrc =  Logo::LOGOS_DIR_URL . "/logo-colored.png";

        return <<<HTML
        <section style="background-color:#110808; color:white; padding:1.5rem">
            <img src="{$logoSrc}" alt="Logo de L'indice">
            <h2>Bienvenue sur L'indice</h2>
        </section>
HTML;
    }
    
    /**
     * Pieds de l'email envoyé.
     * 
     * @return string
     */
    public static function appEmailFooter()
    {
        $appUrl = APP_URL;

        return <<<HTML
        <section style="background-color:#110808; color:white; padding:1.5rem">
            Merci de nous faire confiance pour vos annonces. <br>
            Aller sur <a href="{$appUrl}">Indice.com</a>
        </section>
HTML;
    }

    /**
     * Contenu du mail envoyé à l'utilisateur lorsqu'une suggestion est laissée sur
     * son annonce.
     * 
     * @param string $annonceTitle
     * @param string $comment
     * @param string $announceLink
     * 
     * @return string
     */
    public static function commentReceived(string $annonceTitle, string $comment, string $announceLink)
    {
        $content = <<<HTML
        <p>Vous avez réçu une nouvelle suggestion concernant votre annonce.</p>
        <p>Titre de l'annonce : $annonceTitle</p>
        <p>{$comment}</p>
        <div style="text-align:center">
            <a href="{$announceLink}" style="background-color:#1c3467; padding:7px 11px; color:white">Voir</a>
        </div>
HTML;
        return self::contentFormater($content);
    }

}