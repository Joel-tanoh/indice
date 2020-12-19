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

namespace App\View\Page;

use App\View\Snippet;

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
class SideBar extends Snippet
{
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
        $links = null;
        return $links;
    }

    /**
     * Retourne une ligne dans la sidebar. Prend en paramètre le lien de la sidebar,
     * la classe pour l'icône fontawesome et le texte qui sera affiché dans la
     * sidebar.
     * 
     * @param string $href                 Le lien vers lequel le bouton va diriger.
     * @param string $iconClass La classe fontawesome pour l'icône.
     * @param string $caption              Le texte qui sera visible dans la sidebar.
     * 
     * @return string
     */
    private function setLink(string $href = null, string $iconClass = null, string $caption = null)
    {
        $badge = null;

        return <<<HTML
        <a class="py-2 px-4" href="{$href}">
            <div class="row">
                <span class="col-2"><i class="{$iconClass} fa-lg"></i></span>
                <span class="col-8">{$caption}</span>
                {$badge}
            </div>
        </a>
HTML;
    }

}