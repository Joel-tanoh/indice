<?php

namespace App\Action;

class Action
{
    /**
     * Permet de vérifier qu'un ou plusieurs fichiers ont été uploadés.
     * 
     * @param string $key La clé dans le tableau.
     * 
     * @return bool
     */
    public static function fileIsUploaded(string $key)
    {
        return !empty($_FILES[$key]["name"]);
    }

    /**
     * Permet de vérifier si des données ont été postées.
     * 
     * @return bool
     */
    public static function dataPosted()
    {
        return isset($_POST) && !empty($_POST);
    }
}