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

}