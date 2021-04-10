<?php

namespace App\Admin\Dashboard;

use App\Model\User\Visitor;

/**
 * Classe de gestion du dashboard.
 */
class Dashboard
{
    public static function visitorsOnline() : int
    {
        return Visitor::onlineNumber();
    }

    public static function getCurrentDayVisitorsNumber() : int
    {
        return Visitor::getCurrentDayVisitorsNumber();
    }

    public static function getAllVisitorsNumber() : int
    {
        return Visitor::getAllNumber();
    }

}