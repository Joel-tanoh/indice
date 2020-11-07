<?php

namespace App\Views\Models;

use App\Models\Announce;
use App\views\Card;
use App\views\View;

/**
 * Classe de gestion des vues des annonces.
 */
class AnnounceView extends View
{
    protected $announce;

    /**
     * Constructeur de la vue des annonces.
     * 
     * @param \App\Models\Announce $announce
     */
    public function __construct(\App\Models\Announce $announce = null)
    {
        $this->announce = $announce;
    }

    /**
     * Affiche les 5 dernières annonces postées.
     * 
     * @param int $nbr Pour spécifier si on veut un nombre d'annonces précis.
     * 
     * @return string
     */
    public function showLastPosted(int $nbr = null)
    {
        $announces = Announce::getLastPosted($nbr);

        if (empty($announces)) {
            $toShow = $this->noAnnounces();
        } else {
            $toShow = "";
            foreach($announces as $announce) {
                $toShow .= Card::card(null, $announce->getTitle(), null, $announce->getCreatedAt());
            }
        }

        return $this->section("Les dernières annonces", $toShow);
    }

    /**
     * Affiche les annonces les plus vues.
     * 
     * @param int $nbr Pour spécifier si on veut un nombre d'annonces précis.
     * 
     * @return string
     */
    public function showMoreViewed(int $nbr = null)
    {
        $announces = Announce::getMoreViewed($nbr);

        if (empty($announces)) {
            $toShow = $this->noAnnounces();
        } else {
            $toShow = "";
            foreach($announces as $announce) {
                $toShow .= Card::card(null, $announce->getTitle(), null, $announce->getCreatedAt());
            }
        }

        return $this->section("Les plus vues", $toShow);
    }

    /**
     * Vue de la création d'une annonce.
     * 
     * @return string
     */
    public static function createAnnounce()
    {
        return <<<HTML
        Vue de la création d'une annonce
HTML;
    }

    /**
     * Retourne une section de page.
     * 
     * @param string $sectionTitle
     * @param string $sectionContent
     * 
     * @return string
     */
    private function section(string $sectionTitle = null, string $sectionContent = null)
    {
        return <<<HTML
        <section class="">
            <h3 class="section-title">{$sectionTitle}</h3>
            <div class="row">
                <div class="col-12 section-content">
                    {$sectionContent}
                </div>
            </div>
        </section>
HTML;
    }

    /**
     * Un bloc de code HTML qui affiche aucune annonce lorqu'il n'y a pas 
     * d'annonce à afficher dans une partie de la page.
     * 
     * @return string
     */
    private function noAnnounces()
    {
        return <<<HTML
        <div class="col-12">
            <section class="d-flex justify-content-center align-items-center">
                <p class="h5 text-muted">Aucunes annonces</p>
            </section>
        </div>
HTML;
    }
}