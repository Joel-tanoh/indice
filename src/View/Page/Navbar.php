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

use App\File\Image;
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
                {$this->navbarBrand(Image::LOGOS_DIR_URL."/1.png", APP_URL, "Logo " . APP_NAME)}
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
            {$this->navbarBrand(Image::LOGOS_DIR_URL."/1.png", APP_URL, APP_NAME)}
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
        // $login = Session::getAdministratorSessionVar() ?? Cookie::getAdministratorCookieVar();
        // $adminUser = Administrator::getByLogin($login);

        // return <<<HTML
        // <li class="btn-administrateur">
        //     <a id="btnUserIcon" class="nav-link d-flex align-items-center">
        //         {$this->navbarUserAvatar($adminUser->getAvatarSrc(), $adminUser->getLogin())}
        //         <span class="fas fa-caret-down"></span>
        //     </a>
        //     <ul id="btnUserContent" class="content border list-unstyled">
        //         {$this->administratorReservedActions()}
        //         <li>
        //             <a class="bg-danger text-white" href="admin/deconnexion">Déconnexion</a>
        //         </li>
        //     </ul>
        // </li>
// HTML;
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

//     /**
//      * Retourne les liens réservés qu'aux administrateurs dans la barre de navigation
//      * supérieure de la partie adminsitration.
//      * 
//      * @return string
//      */
//     private function administratorReservedActions()
//     {
//         $login = Session::getAdministratorSessionVar() ?? Cookie::getAdministratorCookieVar();
//         $adminUser = Administrator::getByLogin($login);

//         $adminUrl = "admin";

//         if ($adminUser->hasAllRights()) {
//             return <<<HTML
//             <li>
//                 <a href="{$adminUrl}/administrateurs" class="text-primary">Lister les comptes</a>
//             </li>
//             <!-- <li>
//                 <a href="{$adminUrl}/administrateurs/create" class="text-primary">Ajouter un nouveau compte</a>
//             </li>
//             <li>
//                 <a href="{$adminUrl}/administrateurs/delete" class="text-primary">Supprimer un compte</a>
//             </li> -->
// HTML;
//         }
//     }

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