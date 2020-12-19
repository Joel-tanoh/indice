<?php

/**
 * Description
 * 
 * PHP version 7.1.9
 * 
 * @category Category
 * @package  Package
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com License
 * @link     Link
 */

namespace App\View\Page;

use App\File\Image\Logo;
use App\View\Snippet;

/**
 * Perlet de gérer tout ce qui concerne la barre de navigation supérieure.
 * 
 * @category Category
 * @package  App\
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com License
 * @link     Link
 */
class Navbar extends Snippet
{
    private $brandImgSrc;
    private $userAvatarSrc;

    public function __construct(string $brandImgSrc = null, string $userAvatarSrc = null)
    {
        $this->brandImgSrc = Logo::LOGOS_DIR_URL ."/logo1.png";
        $this->userAvatarSrc = $userAvatarSrc;
    }

    /**
     * Barre de navigation supérieure de la partie publique.
     * 
     * @return string
     */
    public function publicNavbar()
    {
        return <<<HTML
        <aside>
            <div class="d-flex justify-content-between align-items-center p-2">
                {$this->navbarBrand($this->brandImgSrc, APP_URL, "Logo " . APP_NAME)}
                {$this->ads()}
                <div>
                    <a href="connexion" class="btn btn-success">Se connecter</a>
                    <a href="creer-une-annonce" class="btn btn-primary">Créer une annonce</a>
                </div>
            </div>
            <header>
                <nav class="navbar">

                </nav>
            </header>
        </aside>
HTML;
    }

    /**
     * Barre de navigation supérieure de la partie publique.
     * 
     * @return string
     */
    public function publicNavbar2()
    {
        return <<<HTML
        <nav class="navbar navbar-expand-md navbar-light">
            {$this->navbarBrand(Logo::LOGOS_DIR_URL."/1.png", APP_URL, APP_NAME)}
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="navbar-toggler-icon"></i>
            </button>
            <div class="collapse navbar-collapse d-md-flex justify-content-between" id="navbarNav">
                {$this->publicNavbarLinks()}
            </div>
        </nav>
HTML;
    }

    /**
     * Affiche la barre de publicité dans le topbar.
     * 
     * @return string
     */
    private function ads()
    {
        return <<<HTML
        <img src="" alt="Une publicité apparaitra ici" class="d-none d-xl-block">
HTML;
    }


    /**
     * Permet d'afficher le logo dans la navbar.
     * 
     * @param string $brandSrc Le lien vers l'image.
     * @param string $href     L'url exécuté lors du click sur le logo.
     * @param string $caption  Le texte à afficher si l'image introuvable.
     * 
     * @return string
     */
    private function navbarBrand(string $brandSrc, string $href = null, string $caption = null)
    {
        return <<<HTML
        <a class="navbar-brand" href="{$href}">
            <img src="{$brandSrc}" alt="{$caption}" class="brand" style="width:15rem">
        </a>
HTML;
    }

    /**
     * Retourne l'image miniature de l'utilisateur connecté dans la navbar.
     * 
     * @param string $avatarSrc
     * @param string $caption
     * 
     * @return string
     */
    private function navbarUserAvatar(string $avatarSrc, string $caption = null)
    {
        return <<<HTML
        <div>
            <img src="{$avatarSrc}" alt="{$caption}" class="navbar-user-avatar img-circle shdw mr-2"/>
        </div>
HTML;
    }

    /**
     * Retourne les liens de la navbar publique.
     * 
     * @return string
     */
    private function publicNavbarLinks()
    {
        return <<<HTML
        <ul class="navbar-nav">
            {$this->navLink(APP_URL, "Accueil")}
        </ul>
HTML;
    }

    private function navLink(string $href, string $caption)
    {
        return <<<HTML
        <li class="nav-item">
            <a class="nav-link" href="{$href}">{$caption}</a>
        </li>
HTML;
    }

}