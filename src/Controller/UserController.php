<?php

namespace App\Controller;

use App\Model\Model;
use App\Model\User;
use App\Utility\Validator;
use App\View\Model\User\UserView;
use App\View\Notification;
use App\View\Page\Page;

class UserController extends AppController
{
    /**
     * Le controller pour la connexion d'un utilisateur.
     */
    public static function connexion()
    {
        $page = new Page("Connexion", UserView::userConnexion());
        $page->setDescription("");
        $page->show();
    }

    /**
     * Controller pour la création d'un compte user.
     */
    public static function create()
    {
        $errors = null;

        // Si des données sont postées
        if (isset($_POST["create"])) {
            
            // On fait la validation
            $validate =  new Validator();

            $validate->name($_POST["name"]);
            $validate->name($_POST["first_names"], "first_names");
            $validate->email($_POST["email"]);
            $validate->name($_POST["pseudo"], "pseudo");
            $validate->password($_POST["password"], $_POST["password_confirmation"]);

            // Si aucune erreur
            if ($validate->noErrors()) {
                Model::create(User::TABLE_NAME, true);
            } else { // Sinon
                $errors = (new Notification())->errors($errors);
            }
        }

        $page = new Page("Connexion", UserView::createAccount($errors));
        $page->setDescription("");
        $page->show();
    }
}