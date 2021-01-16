<?php

namespace App\Auth;

use App\Database\Database;

class Connexion extends Authentication
{
    private $credentialIndex;
    private $password;
    private $tableName;
    private $error;

    /**
     * Constructeur d'une connexion.
     * 
     * @param string $credentialIndex La clé de la valeur à utiliser pour faire
     *                                l'authentification. Cette clé(index) doit
     *                                être identique à celle à utiliser dans la base    
     *                                données. E.g = email_address, login, pseudo, etc.
     * @param string $password
     * @param string $tableName       Le npm de la table qui contient les occurences des
     *                                utilisateurs.
     */
    public function __construct(
        string $credentialIndex,
        string $password,
        string $dbName,
        string $dbLogin,
        string $dbPassword,
        string $tableName)
    {
        $this->credentialIndex = $credentialIndex;
        $this->credential = $_POST[$credentialIndex];
        $this->password = $password;
        $this->tableName = $tableName;
        $this->pdo = (new Database($dbName, $dbLogin, $dbPassword))->getPdo();
    }

    /**
     * Permet de faire les vérifications sur les credentials et permettre
     * l'authentification de l'utilisateur.
     * 
     * @return void
     */
    public function execute()
    {
        // Vérifier que le credential passé est dans la base de données.
        $query = "SELECT COUNT(id) AS user, password FROM $this->tableName WHERE $this->credentialIndex = ?";
        $req = $this->pdo->prepare($query);
        $req->execute([$this->credential]);
        $result = $req->fetch();

        // Vérifier qu'on a au moins un résultat
        if ($result["user"] == 0) {
            $this->error = "Les valeurs que vous avez saisies sont incorrectes. Veuillez réessayer !";
        } else {
            // Vérifier le mot de passe
            if (!password_verify($this->password, $result["password"])) {
                $this->error = "Les valeurs que vous avez saisies sont incorrectes. Veuillez réessayer !";
            }
        }
    }

    /**
     * Retourne l'erreur rencontré lors de la tentative de connexion.
     * 
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Permet d'enregistrer la connexion de l'utilisateur.
     */
    public function save()
    {
        
    }

}