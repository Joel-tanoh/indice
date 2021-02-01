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

use App\Model\Announce;
use App\View\Model\AnnounceView;
use App\View\Snippet;
use App\File\Image\Logo;
use App\View\Communication\NewsletterView;

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
    public function get() : string
    {
        $logo = Logo::LOGOS_DIR_URL ."/logo-white.png";
        $newsletterView = new NewsletterView();
        $snippet = new Snippet;

        return <<<HTML
        <!-- Footer Section Start -->
        <footer>
            <section class="footer-Content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
                            <div class="widget">
                                <h3 class="footer-logo"><img src="{$logo}" alt=""></h3>
                                <div class="textwidget">
                                    <p>Petit texte descrioptif, Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque lobortis tincidunt est, et euismod purus suscipit quis. Etiam euismod ornare elementum. Sed ex est, consectetur eget facilisis sed, auctor ut purus.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
                            <div class="widget">
                                <h3 class="block-title">Dernières posté(e)s</h3>
                                {$this->lastPostedInFooter("Titre de l'annonce", "28 Fev. 2020", "500")}
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
                            <div class="widget">
                                <h3 class="block-title">Liens rapides</h3>
                                <ul class="menu">
                                    <li><a href="#">Privacy Policy</a></li>
                                    <li><a href="#">Purchase Protection</a></li>
                                    <li><a href="#">Support</a></li>
                                    <li><a href="#">Contact us</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
                            <div class="widget">
                                {$newsletterView->inFooter()}
                                {$snippet->socialNetworksInFooter()}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Footer area End -->
            <!-- Copyright Start  -->
            <div id="copyright">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="site-info float-left">
                                <p>Tous droits réservés &copy; 2020.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Copyright End -->
        </footer>
        <!-- Footer Section End -->

        <!-- Go to Top Link -->
        <a href="#" class="back-to-top">
            <i class="lni-chevron-up"></i>
        </a>

        <!-- Preloader -->
        <div id="preloader">
            <div class="loader" id="loader-1"></div>
        </div>
        <!-- End Preloader -->
HTML;
    }

    /**
     * Last posted in footer.
     * 
     * @return string
     */
    public function lastPostedInFooter()
    {
        $announces = Announce::getLastPosted(2);
        $content = null;

        if (empty($announces)) {
            $content = AnnounceView::noAnnounces();
        } else {
            foreach ($announces as $announce) {
                $content .= (new AnnounceView($announce))->lastPostedCardInFooter();
            }
        }
        
        return <<<HTML
        <ul class="media-content-list">
            {$content}
        </ul>
HTML;
    }

}