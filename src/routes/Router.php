<?php

/**
 * Description
 * 
 * PHP version 7.1.9
 * 
 * @category Category
 * @package  Package
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com license_name
 * @version  GIT: Joel_tanoh
 * @link     Link
 */

namespace App\Routes;

use App\routes\Route;

/**
 * Routeur de l'application.
 *  
 * @category Category
 * @package  Package
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com license_name
 * @version  "Release: package_version"
 * @link     Link
 */
class Router
{
    private $url;
    private $routes = [];
    private $urlAsArray = [];

    /**
     * Constructeur du routeur, prend en paramètre l'url.
     * 
     * @param string $url 
     * 
     * @return void
     */
    public function __construct(string $url)
    {
        $this->url = $url;
        $this->urlAsArray = self::explodeUrl($url);
    }

    /**
     * Permet de modifier l'url passé en paramètre.
     * 
     * @param string $url
     * 
     * @return void
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @param string $path
     * @param string $action
     */
    public function get(string $path, string $action)
    {
        $this->routes["GET"][] = new Route($path, $action);
    }


    /**
     * @param string $path
     * @param string $action
     */
    public function post(string $path, string $action)
    {
        $this->routes["POST"][] = new Route($path, $action);
    }

    public function run()
    {
        foreach($this->routes as $route) {
            if ($route->matches($this->url)) {
                return $route->execute();
            }
        }

        return header("HTTP/1.0 404 Not Found");
    }

    /**
     * Vérifie la concordance de l'url et la variable passée en paramètre. Deux formats
     * d'url paramètres sont passables. Le premier format est une chaîne de caractères
     * et le second format est un tableau de variable si l'url doit varier.
     * 
     * @param array|string $path
     * 
     * @return bool
     */
    public function matches($path)
    {
        if (is_string($path)) {
            return self::GETurl() === $path;
        } elseif (is_array($path)) {

            $urlOffsets = count(self::GETUrlAsArray());
            $routeOffsets = count($path);

            if ($urlOffsets === $routeOffsets) {
                $counter = 0;
                for ($i = 0; $i <= $routeOffsets - 1; $i++) {
                    if (is_string($path[$i])) {
                        if (self::GETUrlAsArray()[$i] === $path[$i]) $counter++;
                    } elseif (is_array($path[$i])) {
                        if (in_array(self::GETUrlAsArray()[$i], $path[$i])) $counter++;
                    }
                }

                if ($counter === $routeOffsets) return true;
                else return false;

            } else {
                return false;
            }
        }
    }

    /**
     * Retourne toute l'url se trouvant après le nom de domaine.
     * 
     * @return string
     */
    public static function RequestUri()
    {
        $uri = $_SERVER["REQUEST_URI"];
        return $uri !== "/" ? rtrim($uri, "/") : $uri;
    }

    /**
     * Cette méthode retourne le contenu de la variable $_GET["url"].
     * Pour faire exister cette variable, il faut un fichier .htaccess dans le
     * même dossier que le fichier index qui lui retourne toutes les urls demandées et
     * accessibles par la variable $_GET["url"];
     * Le fichier .htaccess doit être dans le même dossier que le fichier routeur(index dans
     * la plupart des cas) et doit contenir le code suivant au minimum.
     * 
     * RewriteEngine On
     * 
     * RewriteCond %{REQUEST_FILENAME} !-f 
     * RewriteCond %{REQUEST_FILENAME} !-d 
     * RewriteRule ^(.*)$ index.php?url=$1 [QSA,NC] 
     * 
     * @return string
     */
    public static function GETurl()
    {
        $url = isset($_GET["url"]) ? $_GET["url"] : "/";

        return trim($url, "/");
    }

    /**
     * Cette méthode fonctionne avec la variable
     * serveur $_SERVER["REQUEST_URI]. Elle Nous retourne
     * les différentes parties de $_SERVER["REQUEST_URI] en les
     * separant avec le séparateur passé en paramètre. Si on se trouve sur
     * l'index, cette méthode retourne null, vu que $_SERVER["REQUEST_URI"] ne
     * contient rien.
     * 
     * @param string $separator
     * 
     * @return array Un tableau contenant les parties de $_SERVER["REQUEST_URI"]
     *               en fonction du séparateur.
     */
    public static function RequestUriAsArray(string $separator = "/")
    {
        return self::explodeUrl(self::RequestUri(), $separator);
    }

    /**
     * Permet de découper l'url qui se trouve dans la varaible $_GET["url"]
     * en plusieurs parties et les retourne.
     * 
     * @param string $separator
     * 
     * @return array
     */
    public static function GETUrlAsArray(string $separator = "/")
    {
        return self::explodeUrl(self::GETurl(), $separator);
    }

    /**
     * Découpe l'url passée en paramètre avec le séparateur passé en paramètre.
     * 
     * @param string $url
     * @param string $separator
     * 
     * @return array Un tableau contenant les valeurs separées de l'url.
     */
    private static function explodeUrl(string $url, string $separator = "/")
    {
        if ($url === "/") {
            return null;
        }

        $uriParts = explode($separator, $url);

        return $uriParts;
    }

}