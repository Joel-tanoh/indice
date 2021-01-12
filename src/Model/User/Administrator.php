<?php

namespace App\Model\User;

/**
 * Classe de gestion d'un administrateur.
 */
class Administrator extends Registered
{
    /**
     * Constructeur d'un User inscrit.
     * 
     * @param string $emailAddress
     */
    public function __construct(string $emailAddress)
    {
        parent::__construct($emailAddress);
        $this->type = 1;
    }

    /**
     * Permet à l'administrateur de changer le status d'un compte.
     * 
     * @param int $newStatus
     * @return bool|null
     */
    public function changeStatus(int $newStatus)
    {
        $query = "ALTER TABLE " . self::TABLE_NAME . " SET status = ?";
        $rep = parent::connectToDb()->prepare($query);
        if ($rep->execute([$newStatus])) {
            return true;
        }
    }

    /**
     * Permet à l'administrateur de supprimer un compte.
     * 
     * @param int $userId
     * @return bool|null
     */
    public function deleteUser(int $userId)
    {
        $query = "DELETE FROM " . self::TABLE_NAME . " WHERE id = ?";
        $rep = parent::connectToDb()->prepare($query);
        if ($rep->execute([$userId])) {
            return true;
        }
    }

}