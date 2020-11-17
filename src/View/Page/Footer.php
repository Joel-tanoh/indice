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

use App\View\Snippet;

/**
 * Gère tout ce qui concerne le pied de page
 * 
 * @category Category
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com License
 * @link     Link
 */
class Footer extends Snippet
{
    /**
     * Pied de page
     * 
     * @author Joel
     * @return string [[Description]]
     */
    public function publicFooter() : string
    {
        return <<<HTML
        <footer class="footer">
            <div class="container">
                
            </div>
        </footer>
HTML;
    }
}