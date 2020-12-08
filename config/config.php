<?php

/**
 * Fichier de configuration général de l'application ou du site.
 */

/** Nom de l'application */
define("APP_NAME", "Indice");

/** Nom de la base de données */
define("DB_NAME", "inoveinn_wp806");

/** Adresse du serveur */
define("DB_ADDRESS", "localhost");

/** Login de la base de données */
define("DB_LOGIN", "inoveinn_joStev");

/** Mot de passe de connexion à la base de données */
define("DB_PASSWORD", "JoelSteven@#");

// Chemin du dossier racine de l'application
define("ROOT_PATH", dirname(__DIR__) . DIRECTORY_SEPARATOR);

// Url de l'application
define("APP_URL", $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["SERVER_NAME"]);

/*** Constantes des chemins des dossiers et des fichiers ***/
define("PUBLIC_PATH", ROOT_PATH . "public" . DIRECTORY_SEPARATOR);

/** Chemin vers les assets */
define("ASSETS_DIR_PATH", PUBLIC_PATH . "assets" . DIRECTORY_SEPARATOR);

/*** Constantes des Urls et des liens des dossiers ***/
define("ASSETS_DIR_URL", APP_URL . "/assets");

/*** Constantes des Urls et des liens des dossiers ***/
define("LOGOS_DIR_URL", ASSETS_DIR_URL . "/app/logo");

// Appel de l'autoloader
require_once ROOT_PATH . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

// Appel du fichier contenant les fonctions générales
require_once ROOT_PATH . "src" . DIRECTORY_SEPARATOR . "functions.php";
