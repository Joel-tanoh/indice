<?php

/**
 * Fichier de classe
 * 
 * PHP verison 7.1.9
 * 
 * @category Category
 * @package  Package
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com license
 * @version  "GIT: <Joel-tanoh>"
 * @link     Link
 */

namespace App\Communication;

/**
 * Gère les envois d'email.
 * 
 * PHP verison 7.1.9
 * 
 * @category Category
 * @package  Package
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com license
 * @version  "Release: <package_version>"
 * @link     Link
 */
class Email
{
    /** Le ou les destinataires du mail */
    private $destinataires;

    /** @var string Le sujet du mail */
    private $subject;

    /** @var string Le message */
    private $message;

    /** @var string Le destinateur du mail */
    private $from;

    /** @var bool Permet de signifier qu'on veut ajouter des fichiers */
    private $joinFile;

    /** @var string Le séparateur */
    private $separator;

    /**
     * Constructeur de EmailManager
     * 
     * @param string|array $destinataire Ceux à qui on envoit le mail.
     * @param string       $subject      Le sujet du mail.
     * @param string       $message      Le message à envoyer.
     * @param string       $from         L'email d'envoie qui apparaitra dans le mail.
     * @param bool         $joinFile     True si le mail contient des fichiers joints.
     * 
     * @return void
     */
    public function __construct($destinataires, string $subject, string $message, string $from = null, string $separator = "\r\n", bool $joinFile = null)
    {
        $this->destinataires = $destinataires;
        $this->subject = $subject;
        $this->message = $message;
        $this->separator = $separator;
        $this->from = $from;
        $this->joinFile = $joinFile;
    }

    /**
     * La méthode qui envoie les mails aux destinataires.
     * 
     * @return bool
     */
    public function send()
    {
        $this->treatTo();
        if (!empty($this->destinataires)) {
            $sendMailcounter = 0;
            foreach ($this->destinataires as $destinataire) {
                mail($destinataire, $this->subject, $this->message, $this->headers());
                $sendMailcounter++;
            }
            if ($sendMailcounter) return true;
        }
    }

    /**
     * Retourne les headers.
     * 
     * @return string
     */
    private function headers()
    {
        $headers = "MIME-Version: 1.0" . $this->separator;
        $headers .= "Content-type:text/html;charset=UTF-8" . $this->separator;
        $headers .= "From: " . $this->from . $this->separator;
        if ($this->joinFile) {}
        return $headers;
    }

    /**
     * Permet de traiter les destinataires.
     */
    private function treatTo()
    {
        if (is_array($this->destinataires)) {
            return implode(", ", $this->destinataires);
        }

        return $this->destinataires;
    }

}