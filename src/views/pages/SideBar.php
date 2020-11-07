<?php

/**
 * Description
 * 
 * PHP version 7.1.9
 * 
 * @category Category
 * @package  Package
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com license_name
 * @version  "CVS: cvs_id"
 * @link     Link
 */

namespace App\views\Pages;

use App\Models\Items\Item;
use App\Utilities\Utility;
use App\views\Snippet;
use App\views\View;

/**
 * Permet de gérer les barres de menu sur le coté.
 * 
 * @category Category
 * @package  Package
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com license_name
 * @version  "Release: package_version"
 * @link     Link
 */
class SideBar extends View
{
    /**
     * Barre de gauche sur la partie Administration.
     * 
     * @return string
     */
    public function adminSidebar()
    {
        return $this->sidebar();
    }

    /**
     * SideBar qui est visible sur les grands écrans.
     * 
     * @return string 
     **/
    public function sidebar()
    {
        $snippet = new Snippet();
        $brand = $this->brand(LOGOS_DIR_URL. "/3.png", ADMIN_URL);
        $searchBar = $snippet->searchBar();
        $links = $this->links();

        return <<<HTML
        <input type="checkbox" id="check" checked>
        <label for="check">
            <i class="fas fa-bars" id="commandSidebar"></i>
        </label>
        <div id="sidebar" class="sidebar">
            {$brand}
            {$searchBar}
            {$links}
        </div>
HTML;
    }

    /**
     * Affiche le logo dans la sidebar.
     *
     * @param string $brandSrc Le lien vers l'image.
     * @param string $href     L'url exécuté lors du click sur le logo.
     * 
     * @return string
     */
    public function brand(string $brandSrc, string $href = "admin") : string
    {
        return <<<HTML
        <a class="brand text-center" href="{$href}">
            <img src="{$brandSrc}" alt="Attitude efficace" class="brand sidebar-brand mb-2">
        </a>
HTML;
    }

    /**
     * Peremet d'afficher l'avatar de l'utilisateur dans la sidebar.
     * 
     * @param string $avatarSrc
     * @param string $altText
     * 
     * @return string
     */
    public function userAvatar(string $avatarSrc, string $altText = null)
    {
        return <<<HTML
        <div class="text-center my-2">
            <img src="{$avatarSrc}" alt="{$altText}" class="sidebar-user-avatar img-circle img-fluid"/>
        </div>
HTML;
    }

    /**
     * Retourne les liens.
     * 
     * @return string
     */
    private function links()
    {
        $links = $this->setLink(null, "fas fa-home", "Aller vers le site");
        $links .= $this->setLink("admin", "fas fa-desktop", "Tableau de bord");
        $links .= $this->setLink("admin/formations", "fas fa-box", "Formations");
        $links .= $this->setLink("admin/themes", "fas fa-box", "Thèmes");
        $links .= $this->setLink("admin/etapes", "fas fa-box", "Etapes");
        $links .= $this->setLink("admin/motivation-plus", "fas fa-tv", "Motivation plus");
        $links .= $this->setLink("admin/articles", "fas fa-pen-square", "Articles");
        $links .= $this->setLink("admin/videos", "fas fa-video", "Vidéos");
        $links .= $this->setLink("admin/livres", "fas fa-book", "Livres");
        $links .= $this->setLink("admin/ebooks", "fas fa-book", "Ebooks");
        $links .= $this->setLink("admin/mini-services", "fas fa-shopping-basket", "Mini services");
        $links .= $this->setLink("admin/orders", "fas fa-shopping-basket", "Commandes");

        return $links;
    }

    /**
     * Retourne une ligne dans la sidebar. Prend en paramètre le lien de la sidebar,
     * la classe pour l'icône fontawesome et le texte qui sera affiché dans la
     * sidebar.
     * 
     * @param string $href                 Le lien vers lequel le bouton va diriger.
     * @param string $fontawesomeIconClass La classe fontawesome pour l'icône.
     * @param string $caption              Le texte qui sera visible dans la sidebar.
     * 
     * @return string
     */
    private function setLink(string $href = null, string $fontawesomeIconClass = null, string $caption = null)
    {
        $badge = null;

        if ($caption !== "Aller vers le site" && $caption !== "Tableau de bord") {
            $badge = '<span class="badge badge-success">' . Item::countAllItems(Utility::slugify($caption)) . '</span>';
        }

        return <<<HTML
        <a class="py-2 px-4" href="{$href}">
            <div class="row">
                <span class="col-2"><i class="{$fontawesomeIconClass} fa-lg"></i></span>
                <span class="col-8">{$caption}</span>
                {$badge}
            </div>
        </a>
HTML;
    }

}