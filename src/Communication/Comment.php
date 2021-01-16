<?php

namespace App\Communication;

use App\Model\Model;

/**
 * Classe de gestion des commentaires.
 */
class Comment extends Model
{
    const TABLE_NAME = "comments";

    /** @var App\Model\User\Registered La personne qui a laissé le commentaire */
    private $poster;

    /** L'item concerné par le commentaire. */
    private $subject;

    /** @var string Le contenu du commentaire. */
    private $content;

    /**
     * Constructeur d'un commentaire.
     * 
     * @param int $id L'id du commentaire.
     */
    public function __construct(int $id)
    {
        
    }

    /** Retourne l'utilisateur qui a posté l'annonce */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * Retourne le sujet du commentaire.
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Retourne le contenu du commentaire.
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Permet d'ajouter un commentaire.
     * @param string $userEmailAddress L'adresse email de l'utilisateur qui a posté cette annonce.
     * @param string $subject          Le sujet commenté.
     * @param string $content          Le contenu du commentaire.
     * @param string $subjectType      Le type du sujet commenté, optionnel.
     * @return bool
     */
    public static function add(string $userEmailAddress, $subject, string $content, $subjectType = null)
    {
        $query = "INSERT INTO " . Comment::TABLE_NAME . "(user_email_address, subject, subject_type, content)
            VALUES(:user_email_address, :subject, :subject_type, :content)";
        $req = parent::connectToDb()->prepare($query);
        $req->execute([
            "user_email_address" => $userEmailAddress,
            "subject" => $subject,
            "subject_type" => $subjectType,
            "content" => $content,
        ]);
        return true;
    }
}