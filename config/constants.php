<?php

/**
 * Fichier de configuration général de l'application ou du site.
 * 
 * PHP version 7.1.9
 * 
 * @category Category
 * @package  Package
 * @author   Joel <tanohbassapatrick@gmail.com>
 * @license  url.com license_name
 * @version  GIT: Joel_tanoh
 * @link     Link
 */

/*** Constantes des chemins des dossiers et des fichiers ***/
define("PUBLIC_PATH",           ROOT_PATH . "public" . DIRECTORY_SEPARATOR);

define("ASSETS_PATH",           PUBLIC_PATH . "assets" . DIRECTORY_SEPARATOR);

/*** Constantes des Urls et des liens des dossiers ***/

define("ASSETS_DIR_URL",        APP_URL . "/assets");

define("FILES_DIR_URL",         APP_URL . "/files");

define("PDF_DIR_URL",           FILES_DIR_URL . "/pdf");

define("IMAGES_DIR_URL",        FILES_DIR_URL . "/images");

define("ORIGINALS_THUMBS_DIR",  IMAGES_DIR_URL . "/originals");

define("THUMBS_DIR_URL",        IMAGES_DIR_URL . "/thumbs");

define("AVATARS_DIR_URL",       IMAGES_DIR_URL . "/avatars");

define("LOGOS_DIR_URL",         IMAGES_DIR_URL . "/logos");

define("SLIDERS_DIR_URL",       IMAGES_DIR_URL . "/slider");