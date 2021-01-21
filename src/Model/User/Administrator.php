<?php

namespace App\Model\User;

use App\Communication\Comment;
use App\Model\Announce;

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
     * @param mixed $newStatus
     * @return bool|null
     */
    public function changeUserStatus($newStatus)
    {
        if (\is_string($newStatus)) {
            $newStatus = parent::convertStatus($newStatus);
        }

        $req = parent::connectToDb()->prepare("UPDATE TABLE " . self::TABLE_NAME . " SET status = ?");
        if ($req->execute([$newStatus])) {
            return true;
        }
    }

    /**
     * Permet de valider une annonce.
     * 
     * @param string $tableName Le nom de la table.
     * @param int    $status    Le nouveau status à mettre sous forme numérique.
     * @param int    $id        L'id de l'élément dont on veut changer le statut.
     * @return bool
     */
    public function changeStatus(string $tableName, int $status, int $id)
    {
        $req = parent::connectToDb()->prepare("UPDATE $tableName SET status = :status WHERE id = :id");
        $req->execute([
            "status" => $status,
            "id" => $id
        ]);
        return true;
    }

    /**
     * Permet à l'administrateur de supprimer un compte.
     * 
     * @param int $registeredId
     * @return bool|null
     */
    public function deleteRegistered(int $registeredId)
    {
        $query = "DELETE FROM " . self::TABLE_NAME . " WHERE id = ?";
        $req = parent::connectToDb()->prepare($query);
        if ($req->execute([$registeredId])) {
            return true;
        }
    }

    /**
     * Retourne les commentaires laissés par l'administrateur.
     * 
     * @return array
     */
    public function getComments()
    {
        $req = parent::connectToDb()->prepare("SELECT id FROM " . Comment::TABLE_NAME . " WHERE user_email_address = :user_email_address");
        $req->execute([
            "user_email_address" => $this->emailAddress
        ]);

        $comments = [];
        foreach ($req->fetchAll() as $comment) {
            $comments[] = new Comment($comment["id"]);
        }
        return $comments;
    }

}