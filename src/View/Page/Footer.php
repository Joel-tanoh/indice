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
                                <p>Indice est un site de petites annonces reputée pour être l'une des meilleurs en côte d'Ivoire , Indice vous offre la Possibilité de poster sans contrainte vos annonces sans prise de tête.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
                        <div class="widget">
                            <h3 class="block-title">Derniers articles ajoutés</h3>
                            <ul class="media-content-list">
                                <li>
                                    <div class="media-left">
                                        <img class="img-fluid" src="assets/img/art/img1.jpg" alt="">
                                        <div class="overlay">
                                            <span class="price">$ 79</span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="post-title"><a href="ads-details.html">Brand New Macbook Pro</a></h4>
                                        <span class="date">12 Jan 2018</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="media-left">
                                        <img class="img-fluid" src="assets/img/art/img2.jpg" alt="">
                                        <div class="overlay">
                                            <span class="price">$ 49</span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="post-title"><a href="ads-details.html">Canon Photography Camera</a></h4>
                                        <span class="date">28 Mar 2018</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
                        <div class="widget">
                            <h3 class="block-title">Aide et Support</h3>
                            <ul class="menu">
                                <li><a href="#">FAQ</a></li>
                                <li><a href="#">Nous Contacter</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
                        <div class="widget">
                            <h3 class="block-title">s'Inscrire</h3>
                            <p class="text-sub">Site d'annonce numero 1 en Côte d'Ivoire</p>
                            <form method="post" id="subscribe-form" name="subscribe-form" class="validate">
                                <div class="form-group is-empty">
                                    <input type="email" value="" name="Email" class="form-control" id="EMAIL" placeholder="Email address" required="">
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
                            <p>Tout droit reservé &copy; 2018 - Designé par <a href="https://indice.com" rel="nofollow">Indice</a></p>
                        </div>
                        <div class="float-right">
                            <ul class="bottom-card">
                                <li>
                                    <a href="#"><img src="assets/img/footer/card1.jpg" alt="card"></a>
                                </li>
                                <li>
                                    <a href="#"><img src="assets/img/footer/card2.jpg" alt="card"></a>
                                </li>
                                <li>
                                    <a href="#"><img src="assets/img/footer/card3.jpg" alt="card"></a>
                                </li>
                                <li>
                                    <a href="#"><img src="assets/img/footer/card4.jpg" alt="card"></a>
                                </li>
                            </ul>
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

}