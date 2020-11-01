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

namespace App\backend;

use App\backend\Database\Database;
use App\backend\Models\Users\Registered;

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
    private $destinataires;
    private $subject;
    private $message;
    private $from;
    private $joinFile;

    /**
     * Constructeur de EmailManager
     * 
     * @param mixed  $destinataire Ceux à qui on envoit le mail.
     * @param mixed  $subject      Le sujet du mail.
     * @param string $message      Le message à envoyer.
     * @param string $from         L'email d'envoie qui apparaitra dans le mail.
     * @param bool   $joinFile  True si le mail contient des fichiers joints.
     * 
     * @return void
     */
    public function __construct($destinataires, string $subject, string $message, string $from = null, bool $joinFile = null)
    {
        $this->destinataires = $destinataires;
        $this->subject = $subject;
        $this->message = $message;
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
        if (!empty($this->destinataires)) {
            $send_mail_counter = 0;
            foreach ($this->destinataires as $destinataire) {
                mail($destinataire, $this->subject, $this->message, $this->headers());
                $send_mail_counter++;
            }
            if ($send_mail_counter) return true;
        }
    }

    /**
     * Retourne les headers.
     * 
     * @return string
     */
    private function headers()
    {
        $separator = "\r\n";
        $headers = "MIME-Version: 1.0" . $separator;
        $headers .= "Content-type:text/html;charset=UTF-8" . $separator;
        $headers .= "From: " . $this->from . $separator;
        if ($this->joinFile) {}
        return $headers;
    }

}