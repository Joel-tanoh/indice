<?php

namespace App\View\Communication;

/** Classe gestionnaire des vues relatives aux commentaires */
class CommentView
{
    private $comment;

    /**
     * Constructeur d'une vue de commentaire.
     */
    public function __construct(\App\Communication\Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Affiche un commentaire avec la photo de profile
     * de l'utilisateur qui l'a postée.
     * 
     * @return string
     */
    public function show()
    {
        return <<<HTML
        <div class="offerermessage">
            <figure>
                <img src="{$this->comment->getPoster()->getAvatarSrc()}" alt="Photo de profil de {$this->comment->getPoster()->getName()}">
            </figure>
            <div class="description">
                <div class="info">
                <h3>{$this->comment->getPoster()->getName()} {$this->comment->getPoster()->getFirstNames()}</h3>
                <p>{$this->comment->getContent()}</p>
                </div>
                <time class="date">{$this->comment->getPostedAt()}</time>
            </div>
        </div>
HTML;
    }
}