<?php

namespace App\Controller\UserController;

use App\Action\Action;
use App\Action\Create\Create;
use App\Auth\Cookie;
use App\File\Image\Image;
use App\Model\User\User;
use App\Auth\Session;
use App\Communication\Email;
use App\Communication\Newsletter;
use App\Utility\Utility;
use App\Utility\Validator;
use App\View\Model\User\UserView;
use App\View\Model\User\RegisteredView;
use App\Communication\Notify\NotifyByHTML;
use App\Controller\AppController;
use App\Engine\SearchEngine;
use App\Exception\PageNotFoundException;
use App\Model\Announce;
use App\Model\Category;
use App\Model\Model;
use App\Model\User\Registered;
use App\Model\User\Visitor;
use App\View\Model\AnnounceView;
use App\View\Model\CategoryView;
use App\View\Page\Page;
use App\View\SearchView;
use App\View\View;
use Exception;

abstract class UserController extends AppController
{
    /**
     * Permet d'afficher une annonce.
     * @param array $params
     */
    public static function readAnnounce(array $params = null)
    {
        if (Category::valueIssetInDB("slug", $params[1], Category::TABLE_NAME)
            && Announce::valueIssetInDB("slug", $params[2], Announce::TABLE_NAME)
        ) {
            $category = Model::instantiate("id", Category::TABLE_NAME, "slug", $params[1], "App\Model\Category");
            $announce = Model::instantiate("id", Announce::TABLE_NAME, "slug", $params[2], "App\Model\Announce");

            if ($announce->hasCategory($category) && $announce->isValidated() || (($announce->isPending() || $announce->isSuspended()) && User::isAuthenticated())) {
                $announce->incrementView();
                $page = new Page("L'indice | " . $announce->getCategory()->getTitle() . " > " . $announce->getTitle(), (new AnnounceView($announce))->read());
                $page->addJs("https://platform-api.sharethis.com/js/sharethis.js#property=6019d0cb4ab17d001285f40d&product=inline-share-buttons", "async");
                $page->show();

            } else {
                throw new Exception("La ressource demandée n'a pas été trouvée !");
            }

        } else {
            throw new Exception("La ressource demandée n'a pas été trouvée !");
        }
    }

    /**
     * Permet d'afficher toutes les annonces.
     */
    public static function readAnnounces() {
        $page = new Page("L'indice | Toutes les annonces", UserView::readAnnounces(Announce::getAll(null, "validated")));
        $page->setDescription(
            "Toutes les announces, Vente, Offre et demande, Toutes vos recherches, vos besoins, vous pouvez les trouver sur L'indice."
        );
        $page->show();
    }

    /**
     * Permet de créer un compte. Tous les utilisateurs peuvent créer un compte.
     */
    public static function register()
    {
        $message = null;

        // Si des données sont postées
        if (Action::dataPosted()) {
            
            // On fait la validation
            $validate =  new Validator();

            // Validation du nom
            if (empty($_POST["name"])) {
                $validate->addError("name", "Veuillez entrer votre nom !");
            } else {
                $validate->name($_POST["name"], "Veuillez vérifier que le prénoms ne contient pas de code HTML !", "name");
            }
            
            // Validation du prénom
            if (empty($_POST["first_names"])) {
                $validate->addError("first_names", "Veuillez entrer votre prénom !");
            } else {
                $validate->name($_POST["first_names"], "Veuillez vérifier que les prénoms ne contiennent pas de code HTML !", "first_names");
            }
            
            // Validation du pseudo
            if (empty($_POST["pseudo"])) {
                $validate->addError("pseudo", "Veuillez entrer votre pseudo !");
            } elseif (User::valueIssetInDB("pseudo", $_POST["pseudo"], User::TABLE_NAME)) {
                $validate->addError("pseudo", "Ce pseudo est déjà utilisé !");
            } else {
                $validate->name($_POST["pseudo"], "Veuillez vérifier que le pseudo ne contient pas de code HTML !" ,"pseudo");
            }

            // Validation de l'adresse email
            if (empty($_POST["email_address"])) {
                $validate->addError("email_address", "Veuillez entrer votre adresse email !");
            } elseif (User::valueIssetInDB("email_address", $_POST["email_address"], User::TABLE_NAME)) {
                $validate->addError("email_address", "Cette adresse email est déjà utilisée !");
            } else {
                $validate->email("email_address", $_POST["email_address"]);
            }

            // Validation du mot de passe
            if (empty($_POST["password"])) {
                $validate->addError("password", "Veuillez entrer un mot de passe svp !");
            } elseif (empty($_POST["confirm_password"])) {
                $validate->addError("confirm_password", "Veuillez entrer le mot passe de confirmation !");
            } else {
                $validate->password("password", $_POST["password"], $_POST["confirm_password"]);
            }

            // Validation du numéro
            if (empty($_POST["phone_number"])) {
                $validate->addError("phone_number", "Veuillez entrer un numéro svp !");
            } else {
                $validate->phoneNumber("phone_number", $_POST["phone_number"], "Veuillez entrer un numéro valide svp !");
            }

            // Validation de l'avatar
            if (Create::fileIsUploaded("avatar")) {
                $validate->fileExtensions("avatar", $_FILES["avatar"]["type"], ["image/png", "image/jpg"], "Veuillez charger une image svp !");
                $validate->fileSize("avatar", $_FILES["avatar"]["size"], Image::MAX_VALID_SIZE, "Taille maximale des images: 2 Mo !");
            }

            // Si aucune erreur
            if ($validate->noErrors()) {
                if (User::save()) {
                    (new Visitor(Session::getVisitor()))->identify($_POST["email_address"]);
                    Session::activateRegistered($_POST["email_address"]);
                    Cookie::setRegistered($_POST["email_address"]);

                    Newsletter::register($_POST["email_address"]);
                    $email = new Email(
                        $_POST["email_address"],
                        "Bienvenue sur L'indice.com",
                        (new RegisteredView(User::authenticated()))->welcomeMessage()
                    );
                    $email->send();

                    Utility::redirect(User::authenticated()->getProfileLink());
                }
            } else { // Sinon
                $message = (new NotifyByHTML())->errors($validate->getErrors());
            }
        }

        $page = new Page("L'indice | Je crée mon compte", UserView::register($message));
        $page->setDescription("");
        $page->show();
    }

    /**
     * Permet de gérer les recherches.
     */
    public static function searchAnnounce()
    {
        $announces = [];
        $pageTitle = "L'indice | Recherche d'announces";
        $searchEngine = new SearchEngine();

        if (Action::dataPosted()) {
            $searchEngine->searchAnnounces($_POST);
            $announces = $searchEngine->getResult("App\Model\Announce", "id");
            $query = $_POST["query"] ?? $_POST["search_query"] ?? $_POST["request"] ?? $_POST["q"];
            $pageTitle .= " - " . $query;
        }

        $page = new Page($pageTitle);
        $page->setView((new SearchView())->announcesResult($announces));
        $page->show();
    }

    /**
     * Controller pour le read d'une catégorie.
     */
    static function readCategory(array $params = null)
    {
        if (Category::isCategorySlug($params["category"])) {
            $category = Category::getBySlug($params["category"], Category::TABLE_NAME, "App\Model\Category");
            $page = new Page("L'indice | " . $category->getTitle() . " - Les meilleures annonces", (new CategoryView($category))->read());
            $page->setDescription($category->getDescription());
            $page->show();
        } else {
            throw new PageNotFoundException("Oup's ! Nous n'avons pas pu trouver la catégorie que vous recherchiez.");
        }
    }

    /**
     * Permet d'afficher les annouces validées de l'utilisateur
     * qui a un compte.
     */
    public static function readRegisteredAnnounces(array $params)
    {
        $user = Registered::getByPseudo($params[2]);
        $page = new Page("L'indice | Les meilleures annonces de " . $user->getFullName());
        $page->setView(UserView::readRegisteredValidatedAnnounces($user));
        $page->setDescription(
            ""
        );
        $page->show();
    }

    /**
     * Permet de lire la page à propos.
     */
    public static function readAboutUs()
    {
        $page = new Page(
            "L'indice | A propos de nous - Toutes les informations concernant le fondateur de L'indice.ci",
            View::aboutUs(),
            ""
        );
        $page->show();
    }

    /**
     * Permet de lire la page des questions fréquentes.
     */
    public static function readFAQ()
    {
        $page = new Page(
            "L'indice | FAQs Questions fréquentes - Nous repondons à toutes vos questions sur L'indice.ci",
            View::FAQ(),
            ""
        );
        $page->show();
    }

}