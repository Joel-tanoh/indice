<?php

namespace App\Controller;

use App\Action\Action;
use App\Action\Create\Create;
use App\Auth\Authentication;
use App\Auth\Cookie;
use App\File\Image\Image;
use App\Model\Announce;
use App\Auth\Session;
use App\Communication\Notify\NotifyByHTML;
use App\Model\Category;
use App\Model\Model;
use App\Model\User\Registered;
use App\Utility\Utility;
use App\Utility\Validator;
use App\View\Model\AnnounceView;
use App\View\Page\Page;
use Exception;

class AnnounceController extends AppController
{
    /**
     * Controlleur de création d'une nouvelle annonce.
     */
    public static function create()
    {
        // Si la session n'est pas active
        if (!Session::isActive()) {
            Utility::redirect("/sign-in");
        }

        // La notification à afficher selon l'issue de l'action
        $htmlNotifier = new NotifyByHTML();
        $message = null;

        if (Action::dataPosted()) {
        
            // On fait la validation
            $validate = new Validator();
            $validate->title("title", $_POST["title"]);
            $validate->description("description", $_POST["description"]);

            // Validation de la localisation
            if (empty($_POST["location"])) {
                $validate->addError("location", "Veuillez entrer une localisation !");
            }
            $validate->name($_POST["location"], "Veuillez vérifier que la localisation ne contient pas de code HTML.");

            // Validation de la catégorie
            if ($_POST["id_category"] == 0) {
                $validate->addError("category", "Veuillez choisir une catégorie !");
            }

            // Si l'user a rempli le prix
            if (!empty($_POST["price"])) {
                $validate->price("price", $_POST["price"]);
            }

            // Si user à coché someone_else
            if (isset($_POST["usertype"]) && $_POST["usertype"] === "someone_else") {
                $validate->email("user_to_join", $_POST["user_to_join"]);
                $validate->phoneNumber("phone", $_POST["phone_number"], "Veuillez entrer un numéro de téléphone valide !");
            }

            // Valider le type
            if (empty($_POST["type"])) {
                $validate->addError("type", "Veuillez choisir le type de l'annonce !");
            } else {
                $validate->name($_POST["type"], "Le type ne doit pas comporter de code HTML !");
            }

            // Valider la direction
            if (empty($_POST["direction"])) {
                $validate->addError("direction", "Veuillez choisir le sens de l'annonce !");
            } else {
                $validate->name($_POST["direction"], "Le sens ne doit pas comporter de code HTML !");
            }

            // Si des images ont été postées
            if (Create::fileIsUploaded("images")) {
                // Validation du nombre d'images uploadées
                $validate->fileNumber("images", "equal", 3, "Veuillez charger 3 images svp !");

                // Validation des extensions
                foreach ($_FILES["images"]["type"] as $extension) {
                    $validate->fileExtensions("images", $extension, ["image/jpeg", "image/png"], "Veuillez vérifier que vous avez chargé des images svp !");
                }

                // Validation des tailles des fichiers
                foreach ($_FILES["images"]["size"] as $size) {
                    $validate->fileSize("images", $size, Image::MAX_VALID_SIZE, "Veuillez charger des fichiers de taille inférieur à 2 Mb svp !");
                }

            }

            // Si il y'a des erreurs
            if (!empty($validate->getErrors())) {
                $message = $htmlNotifier->errors($validate->getErrors(), "danger");
            } else { // Sinon On save
                if (Announce::create()) {
                    $message = $htmlNotifier->toast("Enregistrement effectué avec succès", "success");
                }
            }
        }

        $page = new Page("L'indice - Poster une annonce", (new AnnounceView())->create($message));
        $page->setDescription("");
        $page->show();
    }

    /**
     * Controller pour afficher les détails d'une annonce.
     * 
     * @param array $params C'est le tableau qui contient l'params découpée.
     *                   La partie de ce tableau nous interressant est
     *                   l'index 1
     * 
     * @return void
     */
    static function read(array $params = null)
    {
        if (Category::valueIssetInDB("slug", $params[1], Category::TABLE_NAME)
            && Announce::valueIssetInDB("slug", $params[2], Announce::TABLE_NAME)
        ) {
            $category = Model::instantiate("id", Category::TABLE_NAME, "slug", $params[1], "App\Model\Category");
            $announce = Model::instantiate("id", Announce::TABLE_NAME, "slug", $params[2], "App\Model\Announce");
            if ($announce->hasParent($category)) {
                $page = new Page("L'indice - " . $announce->getTitle(), (new AnnounceView($announce))->read());
                $page->show();
            } else {
                throw new Exception("La ressource demandée n'a pas été trouvée !");
            }
        } else {
            throw new Exception("La ressource demandée n'a pas été trouvée !");
        }
    }

    /**
     * Controller permetant l'utilisateur authentifié de
     * de modifier une annonce.
     */
    public static function manage(array $params)
    {
        Authentication::redirectUserIfNotAuthentified("/sign-in");

        // Vérifier que le slug bon
        dump($params["slug"]);
        die();

        if (Announce::valueIssetInDB("slug", $params["slug"], Announce::TABLE_NAME)) {
            $registered = new Registered(Session::get() ?? Cookie::get()); 
            $announce = Announce::getBySlug($params["slug"], Announce::TABLE_NAME, "App\Model\Announce");
            $page = new Page();

            switch ($params["action"]) {
                case "manage" :
                    $view = (new AnnounceView($announce))->manage($registered);
                    break;
                
                case "update" :
                    $message = null;
                    $view = (new AnnounceView($announce))->update($message);
                    break;

                case "delete" :
                    if ($announce->delete(Announce::TABLE_NAME)) {
                        Utility::redirect($registered->getProfileLink() . "/posts");
                    }
                    break;

                default :
                    Utility::redirect($registered->getProfileLink() . "/posts");
                    break;
            }

            $page->setMetaTitle("L'indice - " . $announce->getTitle());
            $page->setView($view);
            $page->show();

        } else {
            throw new Exception("Ressource non trouvée !");
        }
    }

    public function delete()
    {
        
    }
}