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

namespace App\views\Pages;

use App\backend\Cookie;
use App\backend\Models\Users\Administrator;
use App\backend\Session;
use App\views\View;

/**
 * Perlet de gérer tout ce qui concerne la barre de navigation supérieure.
 * 
 * @category Category
 * @package  App\
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com License
 * @link     Link
 */
class Navbar extends View
{
    /**
     * Barre de navigation supérieure de la partie publique.
     * 
     * @return string
     */
    public function publicNavbar()
    {
        return <<<HTML
        <nav class="navbar navbar-expand-md navbar-dark bg-marron">
            <div class="container">
                {$this->navbarBrand(LOGOS_DIR_URL."/logo_3.png", PUBLIC_URL, APP_NAME)}
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="navbar-toggler-icon"></i>
                </button>
                <div class="collapse navbar-collapse d-md-flex justify-content-between" id="navbarNav">
                    {$this->publicNavbarLinks()}
                </div>
            </div>
        </nav>
HTML;
    }

    /**
     * Barre de navigation supérieure de la partie administration.
     *
     * @author Joel
     * @return string
     */
    public function AdministrationNavbar()
    {
        return <<<HTML
        <nav class="navbar fixed-top navbar-content bg-white border-bottom w-100 d-flex justify-content-end">
            <ul class="navbar-nav d-flex align-items-center flex-row">
                {$this->utilsBar()}
            </ul>
        </nav>
HTML;
    }

    /**
     * Permet d'afficher le logo dans la navbar.
     * 
     * @param string $brandSrc        Le lien vers l'image.
     * @param string $href  L'url exécuté lors du click sur le logo.
     * @param string $caption  Le texte à afficher si l'image introuvable.
     * 
     * @return string
     */
    private function navbarBrand(string $brandSrc, string $href = null, string $caption = null)
    {
        return <<<HTML
        <a class="navbar-brand" href="{$href}">
            <img src="{$brandSrc}" alt="{$caption}" class="brand">
        </a>
HTML;
    }

    /**
     * Barre d'outils de la barre de navigation de la partie admin
     * 
     * @return string
     */
    private function utilsBar()
    {
        return $this->addItemsLinksView()
            . $this->manageAdministratorsButtons();
    }

    /**
     * Affiche les liens pour créer des catégories et des éléments.
     * 
     * @return string code HTML
     */
    private function addItemsLinksView()
    {
        $adminUrl = "admin";

        return <<<HTML
        <li id="addButton" class="mr-3">
            <a class="add-button-icon border">
                <i class="fas fa-plus"></i>
            </a>
            <ul class="add-button-content list-unstyled border">
                <li>
                    <a href="{$adminUrl}/articles/create" class="text-primary">Ecrire un article</a>
                </li>
                <li>
                    <a href="{$adminUrl}/videos/create" class="text-primary">Ajouter une vidéo</a>
                </li>
                <li>
                    <a href="{$adminUrl}/livres/create" class="text-primary">Publier un livre</a>
                </li>
                <li>
                    <a href="{$adminUrl}/ebooks/create" class="text-primary">Ajouter un ebook</a>
                </li>
            </ul>
        <li>
HTML;
    }

    /**
     * Bouton administrateur se trouvant dans la navbar pour gérer les liens.
     * 
     * @author Joel
     * @return string
     */
    private function manageAdministratorsButtons()
    {
        $login = Session::getAdministratorSessionVar() ?? Cookie::getAdministratorCookieVar();
        $adminUser = Administrator::getByLogin($login);

        return <<<HTML
        <li class="btn-administrateur">
            <a id="btnUserIcon" class="nav-link d-flex align-items-center">
                {$this->navbarUserAvatar($adminUser->getAvatarSrc(), $adminUser->getLogin())}
                <span class="fas fa-caret-down"></span>
            </a>
            <ul id="btnUserContent" class="content border list-unstyled">
                {$this->administratorReservedActions()}
                <li>
                    <a class="bg-danger text-white" href="admin/deconnexion">Déconnexion</a>
                </li>
            </ul>
        </li>
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
     * Retourne les liens réservés qu'aux administrateurs dans la barre de navigation
     * supérieure de la partie adminsitration.
     * 
     * @return string
     */
    private function administratorReservedActions()
    {
        $login = Session::getAdministratorSessionVar() ?? Cookie::getAdministratorCookieVar();
        $adminUser = Administrator::getByLogin($login);

        $adminUrl = "admin";

        if ($adminUser->hasAllRights()) {
            return <<<HTML
            <li>
                <a href="{$adminUrl}/administrateurs" class="text-primary">Lister les comptes</a>
            </li>
            <!-- <li>
                <a href="{$adminUrl}/administrateurs/create" class="text-primary">Ajouter un nouveau compte</a>
            </li>
            <li>
                <a href="{$adminUrl}/administrateurs/delete" class="text-primary">Supprimer un compte</a>
            </li> -->
HTML;
        }
    }

    /**
     * Retourne les liens de la navbar publique.
     * 
     * @return string
     */
    private function publicNavbarLinks()
    {
        $public_url = PUBLIC_URL;

        return <<<HTML
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{$public_url}/a_propos">A propos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{$public_url}/communaute">Rejoindre la communauté</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{$public_url}">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{$public_url}/articles">Articles</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{$public_url}/videos">Vidéos</a>
            </li>
        </ul>
HTML;
    }

}