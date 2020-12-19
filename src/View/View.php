<?php

namespace App\View;

use App\View\Model\AnnounceView;

/**
 * Classe View. Regroupe toutes les vues de l'application.
 */
class View
{
    /**
     * Vue de l'index de l'application.
     * 
     * @return string
     */
    public static function index()
    {
        return <<<HTML
        <!-- Trending Categories Section Start -->
        <section class="categories-icon section-padding bg-drack">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-car"></i>
                                </div>
                                <h4>Vehicle</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-display"></i>
                                </div>
                                <h4>Electronics</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-mobile"></i>
                                </div>
                                <h4>Mobiles</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-leaf"></i>
                                </div>
                                <h4>Furnitures</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-tshirt"></i>
                                </div>
                                <h4>Fashion</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-briefcase"></i>
                                </div>
                                <h4>Jobs</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-home"></i>
                                </div>
                                <h4>Real Estate</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-hand"></i>
                                </div>
                                <h4>Animals</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-graduation"></i>
                                </div>
                                <h4>Education</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-laptop"></i>
                                </div>
                                <h4>Laptops & PCs</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-paint-roller"></i>
                                </div>
                                <h4>Services</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <a href="category.html">
                            <div class="icon-box">
                                <div class="icon">
                                <i class="lni-heart"></i>
                                </div>
                                <h4>Matrimony</h4>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Trending Categories Section End -->
HTML;
    }

    /**
     * La vue à afficher lorsqu'on rencontre une erreur de type exception.
     * 
     * @param \Error|\TypeError|\Exception|\PDOException $e
     */
    public static function exception($e)
    {
        return <<<HTML
        <div class="container">
            <div class="bg-white rounded p-3">
                <h1 class="text-primary">Exception capturée.</h1>
                <div class="h3 text-secondary">{$e->getMessage()}</div>
                <div>Excéption jetée dans {$e->getFile()} à la ligne {$e->getLine()}.</div>
            </div>
        </div>
HTML;
    }

}