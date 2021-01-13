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
}