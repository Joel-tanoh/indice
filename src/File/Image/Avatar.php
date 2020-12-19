<?php

namespace App\File\Image;

class Avatar extends Image
{
    /**
     * Chemin du dossier contenant les avatars des users.
     * 
     * @var string
     */
    const AVATARS_DIR_PATH =  parent::IMG_DIR_PATH . "avatars" . DIRECTORY_SEPARATOR;

    /**
     * Url du dossier contenant les avatars des users.
     * 
     * @var string
     */
    const AVATARS_DIR_URL = parent::IMG_DIR_URL . "/avatars";

}