<?php

namespace App\Controller\UserController;

use App\Communication\Email;
use App\Communication\Newsletter;
use App\Utility\Utility;
use App\Utility\Validator;
use App\View\Communication\NewsletterView;
use App\View\Page\Page;
use App\View\View;

/**
 * Classe de gestion des controllers du visiteur.
 */
class VisitorController extends UserController
{
    /**
     * Pour enregister un visiteur qui veut s'inscrire à la newsletter.
     */
    public static function registerToNewsletter()
    {
        $validator = new Validator();
        $validator->email("email_address", $_POST["email_address"]);
        $page = new Page();

        if (!$validator->getErrors()) {
            if (Newsletter::register($_POST["email_address"])) {
                $email = new Email(
                    $_POST["email_address"], "Bienvenue sur L'indice.com", (new NewsletterView)->welcomeMessage()
                );
                if ($email->send()) {
                    $page->setMetaTitle("L'indice | Abonnement à la Newsletter Réussie");
                    $page->setView(View::success("Félicitations !", "Vous êtes bien enregistré dans la newsletter ! Vous recevrez un email de confirmation."));
                    $page->show();
                } else {
                    Utility::redirect("/");
                }
            }
        }
    }
      
}