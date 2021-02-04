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
     * Permet d'afficher tous les commentaires.
     * 
     * @return string
     */
    public static function showAll(array $comments)
    {
        $commentsList = null;

        foreach ($comments as $comment) {
            $commentsList .= (new self($comment))->show();
        }

        return <<<HTML
        <div id="comments">
            <div class="comment-box">
                <h3>Suggestions</h3>
                <ol class="comments-list">
                    {$commentsList}
                </ol>
            </div>
        </div>
HTML;
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
        <li>
            <div class="media">
                <div class="thumb-left">
                    <img class="img-fluid" src="{$this->comment->getPoster()->getAvatarSrc()}" alt="Photo de profil de {$this->comment->getPoster()->getFullName()}">
                </div>
                <div class="info-body">
                    <div class="media-heading">
                        <h4 class="name">{$this->comment->getPoster()->getFullName()}</h4> 
                        <span class="comment-date"><i class="lni-alarm-clock"></i> {$this->comment->getPostedAt()}</span>
                    </div>  
                    <p>{$this->comment->getContent()}</p>                     
                </div>
            </div>
        </li>
HTML;
    }
}
