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
    public function get() : string
    {
        return <<<HTML
        <!-- Footer Section Start -->
        <footer>
            <!-- Footer Area Start -->
            <section class="footer-Content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
                            <div class="widget">
                                <h3 class="footer-logo"><img src="assets/img/logo/logo1.png" alt=""></h3>
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
                                <h3 class="block-title">Inscrivez-vous</h3>
                                <p class="text-sub">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptate illo ipsa quod.</p>
                                <form method="post" id="subscribe-form" name="subscribe-form" class="validate">
                                    <div class="form-group is-empty">
                                        <input type="email" value="" name="Email" class="form-control" id="EMAIL" placeholder="Adresse" required="">
                                        <button type="submit" name="subscribe" id="subscribes" class="btn btn-common sub-btn"><i class="lni-check-box"></i></button>
                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                                <ul class="footer-social">
                                    <li><a class="facebook" href="#"><i class="lni-facebook-filled"></i></a></li>
                                    <li><a class="twitter" href="#"><i class="lni-twitter-filled"></i></a></li>
                                    <li><a class="linkedin" href="#"><i class="lni-linkedin-fill"></i></a></li>
                                    <li><a class="google-plus" href="#"><i class="lni-google-plus"></i></a></li>
                                </ul>
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
        return <<<HTML
        <ul class="media-content-list">
            {$this->lastPostedCode("Titre de l'annonce", 50, "20 Fev. 2020")}
            {$this->lastPostedCode("Titre de l'annonce", 200, "31 Dec. 2020")}
        </ul>
HTML;
    }

    /**
     * Last posted in footer code.
     * 
     * @param string $title
     * @param int $price
     * @param string $date
     * 
     * @return string
     */
    public function lastPostedCode(string $title, int $price = null, string $date = null)
    {
        return <<<HTML
        <li>
            <div class="media-left">
                <img class="img-fluid" src="assets/img/art/img2.jpg" alt="">
                <div class="overlay">
                    <span class="price">{$price} XOF</span>
                </div>
            </div>
            <div class="media-body">
                <h4 class="post-title"><a href="ads-details.html">{$title}</a></h4>
                <span class="date">{$date}</span>
            </div>
        </li>
HTML;
    }

}