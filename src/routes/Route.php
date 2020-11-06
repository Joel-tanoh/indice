<?php

namespace App\routes;

/**
 * Classe de gestion d'une route.
 */
class Route
{
    protected $route;
    protected $action;
    protected $matches;
    protected $paramsValues = [];

    public function __construct(string $route, string $action)
    {
        $this->route = trim($route, "/");
        $this->action = $action;
    }

    public function matches(string $url)
    {
        $path = preg_replace("#:([\w]+)#", "([^/]+)", $this->route);
        $pathToMatch = "#^$path$^#";

        if (preg_match_all($pathToMatch, $url, $matches)) {
            $this->matches = $matches;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Exécute la classe avec la méthode passée en paramètre.
     */
    public function execute()
    {
        $actionParams = explode("@", $this->action);
        $controller = new $actionParams[0]();
        $method = $actionParams[1];

        if (!empty($this->matches)) {
            return $controller->$method($this->matches);
        } else {
            return $controller->$method();
        }
    }
    
    /**
     * Retourne un tableau contenant les noms des paramètres passés
     * dans la path s'il en existe.
     * 
     * @return array|null
     */
    public function getParams()
    {
        $pattern = "#:([\w]+)#";
        $matches = preg_match_all($pattern, $this->path, $matches);
        // array_shift($matches);

        return $matches;
    }

    /**
     * @return array
     */
    public function getParamsValue()
    {
        $params = $this->getParams();

        if ($params && $this->urlAsArray) {
            $paramsNumber = count($this->getParams());
            for ($i = 0; $i < $paramsNumber - 1; $i++) {
                $paramsValues[$params[$i]] = $this->urlAsArray[$i];
            }
        }

        $this->paramsValue = $paramsValues;

        return $this->paramsValue;
    }

}