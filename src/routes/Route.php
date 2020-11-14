<?php

namespace App\routes;

/**
 * Classe de gestion d'une route.
 */
class Route
{
    protected $route;
    protected $action;
    protected $params = [];

    public function __construct(string $route, string $action)
    {
        $this->route = trim($route, "/");
        $this->action = $action;
    }

    /**
     * Retourne true si la route coincide avec l'url.
     * 
     * @return bool
     */
    public function matches($url)
    {
        if (!$this->hasParams()) {
            return $this->route == $url;
        } else {
            $this->getParams();
            return $this->length() === Router::urlLength();
        }
    }

    /**
     * Exécute l'action de la route.
     * 
     * @return mixed
     */
    public function execute()
    {
        $actionParams = explode("@", $this->action);
        $method = $actionParams[1];
        
        if (!$this->params) {
            return $actionParams[0]::$method();
        } else {
            return $actionParams[0]::$method(Router::getUrlAsArray());
        }
    }

    /**
     * Rétourne les paramètres qui sont dans la route.
     * 
     * @return array
     */
    function getParams() : array
    {
        preg_match_all("#:([\w]+)#", $this->route, $matches);
        $this->params = $matches[1];
        return $this->params;
    }

    /**
     * Permet de vérifier si la route contient des paramètres.
     * 
     * @return bool
     */
    public function hasParams()
    {
        return count($this->getParams()) !== 0;
    }

    /**
     * Retourne les parties de la route.
     * 
     * @return array
     */
    function parts()
    {
        return explode("/", $this->route);
    }

    /**
     * Retourne la longeur de la route.
     * 
     * @return int
     */
    function length()
    {
        return count($this->parts());
    }

}