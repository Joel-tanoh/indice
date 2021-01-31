<?php

namespace App\Controller;

use App\Communication\Email;
use App\Communication\Newsletter;
use App\Utility\Utility;
use App\Utility\Validator;
use App\View\NewsletterView;
use App\View\Page\Page;
use App\View\View;

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

    /**
     * Pour enregister un visiteur qui veut s'inscrire à la newsletter.
     */
    public static function register()
    {
        $validator = new Validator();
        $validator->email("email_address", $_POST["email_address"]);
        $page = new Page();

        if (!$validator->getErrors()) {
            if (Newsletter::register($_POST["email_address"])) {
                $email = new Email(
                    $_POST["email_address"], "Bienvenue sur L'indice.com", NewsletterView::welcomeMessage()
                );
                if ($email->send()) {
                    $page->setMetaTitle("L'indice | Abonnement à la Newsletter Réussie");
                    $page->setView((new View)->success("Félicitations !", "Vous êtes bien enregistré dans la newsletter !"));
                    $page->show();
                } else {
                    Utility::redirect("/");
                }
            }
        }
    }
}