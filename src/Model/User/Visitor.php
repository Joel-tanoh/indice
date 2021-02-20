<?php

namespace App\Model\User;

use App\Auth\Authentication;
use App\Auth\Cookie;
use App\Utility\Utility;
use App\Auth\Session;
use DateTime;

/**
 * Fichier de classe gestionnaire des visites sur l'app.
 * 
 * @author Joel <joel.developpeur@gmail.com>
 */
class Visitor extends User
{
    /** @var string Valeur de session */
    protected $sessionValue;

    /** @var string Date de la visite. */
    protected $date;

    /** @var string La date de la dernière action. */
    protected $lastActionDate;

    /**
     * @var string Nom de la table.
     */
    const TABLE_NAME = "visitors";

    /**
     * Constructeur.
     * 
     * @param string $sessionValue
     * 
     * @return void
     */
    public function __construct(string $sessionValue)
    {
        $query = "SELECT id, session_value, date, last_action_date"
            . " FROM " . self::TABLE_NAME
            . " WHERE session_value = :session_value";
        
        $req = parent::connectToDb()->prepare($query);
        $req->execute([
            "session_value" => $sessionValue
        ]);

        $result = $req->fetch();

        $this->id = $result["id"];
        $this->sessionId = $result["id"];
        $this->sessionValue = $result["session_value"];
        $this->date = $result["date"];
        $this->lastActionDate = $result["last_action_date"];
        $this->tableName = self::TABLE_NAME;
    }

    /**
     * Retourne la valeur de la session.
     * 
     * @return string
     */
    public function getSessionValue()
    {
        return $this->sessionValue;
    }

    /**
     * Retourne la date de la visite.
     * 
     * @return string
     */
    public function getDate(string $part = null, bool $shortLy = null)
    {
        return Utility::formatDate($this->date, $part, $shortLy);
    }

    /**
     * Permet de mettre à jour le compteur de visite de l'app.
     * 
     * @return void 
     */
    public static function manage()
    {
        if (self::isset()) {
            $visitor = new self(Session::getVisitor());
            $visitor->updateLastActionDate();
        } else {
            self::register();
        }
    }

    /**
     * Permet de mettre à jour la date de la dernière action pour savoir
     * si l'utilisateur est toujours en ligne.
     * 
     * @return bool
     */
    public function updateLastActionDate()
    {
        $req = parent::connectToDb()->prepare("UPDATE " . self::TABLE_NAME . " set last_action_date = :last_action_date WHERE id = :id");
        $req->execute([
            "last_action_date" => date("Y-m-d H:i:s"),
            "id" => $this->sessionId
        ]);
        return true;
    }

    /**
     * Retourne la liste de tous les visiteurs.
     * 
     * @return array
     */
    public static function getAll()
    {
        $req = parent::connectToDb()->query("SELECT session_value FROM " . self::TABLE_NAME);
        $result = $req->fetcAll();

        $visitors = [];
        foreach ($result as $visitor) {
            $visitors[] = new self($visitor["session_value"]);
        }

        return $visitors;
    }

    /**
     * Permet de retourner le nombre total de visiteur sur l'appli.
     * @return int
     */
    public static function getAllNumber()
    {
        return count(self::getAll());
    }

    /**
     * Permet de récupérer les visiteurs en ligne.
     * 
     * @return array
     */
    public static function online()
    {
        $query = "SELECT session_value FROM " . self::TABLE_NAME . " WHERE last_action_date >= ?";

        $rep = parent::connectToDb()->prepare($query);
        $rep->execute([
            time() - (3*60)
        ]);
        $result = $rep->fetchAll();

        $online = [];
        foreach($result as $v) {
            $online[] = new self($v["session_value"]);
        }

        return $online;
    }

    /**
     * Permet de retourner le nombre de personne en ligne.
     * @return int
     */
    public static function onlineNumber()
    {
        return count(self::online());
    }

    /**
     * Permet de mettre à jour la valeur de la l'id de session.
     * 
     * @param string $sessionValue
     * @return bool
     */
    public function identify(string $sessionValue)
    {
        $req = parent::connectToDb()->prepare("UPDATE $this->tableName SET session_value = :session_value WHERE id = :id");
        $req->execute([
            "session_value" => $sessionValue,
            "id" => $this->sessionId
        ]);
        
        return true;
    }

    /**
     * Permet d'enregister un nouveau visiteur.
     * 
     * @return bool
     */
    private static function register()
    {
        do {
            $sessionValue = Utility::generateCode();
        } while (self::isSaved($sessionValue));

        if (self::saveInDb($sessionValue)) {
            Session::activateVisitor($sessionValue);
        }

        return true;
    }

    /**
     * Permet de vérifier si une instance de visite existe.
     * 
     * @return bool
     */
    private static function isset()
    {
        return (Session::visitorActivated() || Session::registeredActivated())
            && (self::isSaved(Session::getVisitor()) || self::isSaved(Session::getRegistered()));
    }

    /**
     * Enregistre l'id de session et la date dans la base de données.
     * 
     * @param string $sessionValue La valeur de la session.
     * 
     * @return bool
     */
    private static function saveInDb(string $sessionValue)
    {
        $query = "INSERT INTO " . self::TABLE_NAME . "(session_value) VALUES(:session_value)";
        $req = parent::connectToDb()->prepare($query);
        $req->execute([
            "session_value" => $sessionValue
        ]);

        return true;
    }

    /**
     * Permet de vérifier que la variable de session est enregistrée.
     * 
     * @param string $sessionValue
     * @return bool
     */
    public static function isSaved($sessionValue)
    {
        $req = parent::connectToDb()->prepare("SELECT COUNT(id) as counter FROM " . self::TABLE_NAME . " WHERE session_value = :session_value");
        $req->execute([
            "session_value" => $sessionValue
        ]);

        return (int)$req->fetch()["counter"] !== 0;
    }

    /**
     * Retourne le nombre de fois que ce visiteur est venu sur le site.
     * 
     * @param string $beginDate
     * @param string $endDate
     * 
     * @return int
     */
    public function getVisitNumberPerInterval(string $beginDate, string $endDate)
    {

    }

    /**
     * Retourne le nombre de visite totale par jour.
     * 
     * @param string $date 
     * @return int
     */
    public static function perDay(string $date)
    {

    }

    /**
     * Retourne le nombre de visite totale par mois.
     * 
     * @param string $month 
     * @return int
     */
    public static function perMonth(string $month)
    {

    }

    /**
     * Retourne le nombre de visite par ans.
     * 
     * @param string $year
     * @return int
     */
    public static function perYear(string $year)
    {

    }

}