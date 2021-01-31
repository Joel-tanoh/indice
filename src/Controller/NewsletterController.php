<?php

namespace App\Controller;

use App\Communication\Email;

/**
 * Controller de la newsletter.
 */
class NewsletterController extends AppController
{
    public static function test()
    {
        echo "Nous allons tester l'envoi de mail";

        $to = [
            "tanohbassapatrick@gmail.com",
            "joel.developpeur@gmail.com",
            "tata@hh"
        ];

        $email = new Email($to, "Test de mail", "Le mail est bien reçu !");
        // $email = new Email("tanohbassapatrick@gmail.com, joel.developpeur@gmail.com", "Test de mail", "Le mail est bien reçu !");

        if ($email->send()) {
            echo "<br>Mail envoyé !";
        } else {
            echo "<br>Mail non envoyé !";
        }
    }
}