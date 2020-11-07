<?php

/**
 * Fichier de configuration général de l'application ou du site.
 */


/** Nom de l'application */
define("APP_NAME", "Indice");

/** Nom de la base de données */
define("DB_NAME", "indice");

/** Adresse du serveur */
define("DB_ADDRESS", "localhost");

/** Login de la base de données */
define("DB_LOGIN", "root");

/** Mot de passe de connexion à la base de données */
define("DB_PASSWORD", "Joel1997@admin");

// Chemin du dossier racine de l'application
define("ROOT_PATH", dirname(__DIR__) . DIRECTORY_SEPARATOR);

// Url de l'application
define("APP_URL", $_SERVER["REQUEST_SCHEME"] . "://indice.com");

// Appel du fichier contenant toutes les constantes importantes de l'application.
require_once "constants.php";

// Appel de l'autoloader
require_once ROOT_PATH . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

// Appel du fichier contenant les fonctions générales
require_once ROOT_PATH . "src" . DIRECTORY_SEPARATOR . "functions.php";