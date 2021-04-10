<?php

namespace App\Admin\Dashboard;

/**
 * Classe de gestion des vues Dashboard.
 */
class DashboardView
{

    public static function showvisitorsOnline() : string
    {
        return self::KPIBox(Dashboard::visitorsOnline(), "Visiteur(s) en ligne", "fas fa-users");
    }

    public static function showCurrentDayVisitorsNumber() : string
    {
        return self::KPIBox(Dashboard::getCurrentDayVisitorsNumber(), "Visiteur(s) aujourd'hui", "fas fa-users");
    }

    public static function showAllVisitorsNumber() : string
    {
        return self::KPIBox(Dashboard::getAllVisitorsNumber(), "Visiteur(s) au total", "fas fa-users");
    }

    /**
     * Affiche une box avec un nombre, un petit texte et une icône.
     * 
     * @param int $number            Le nombre (KPI) à afficher
     * @param string $text           Le texte descriptif du KPI
     * @param string|null $iconClass A passer si on veut afficher une icône, cela
     *                               peut être une icône Bootstrap ou autres.
     * 
     * @return string
     */
    public static function KPIBox(int $number, string $text, string $iconClass = null) : string
    {
        $icon = null;
        if ($iconClass) {
            $icon = '<i class="' . $iconClass . '"></i>';
        }

        return <<<HTML
        <div class="col-12 col-md-4">
            <div class="bg-light border p-3 mb-2 rounded">
                <div class="mb-2">
                    $icon<span class="h1">$number</span>
                </div>
                <div class="justify-content-end">$text</div>
            </div>
        </div>
HTML;
    }

}