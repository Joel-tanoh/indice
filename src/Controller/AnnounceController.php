<?php

namespace App\Controller;

use App\Action\Action;
use App\Action\Create\Create;
use App\Action\Update\Update;
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
        Authentication::redirectUserIfNotAuthentified("/sign-in");
        $htmlNotifier = new NotifyByHTML();
        $message = null;

        if (Action::dataPosted()) {
            // Si il y'a des erreurs
            if (!empty(self::validation(false)->getErrors())) {
                $message = $htmlNotifier->errors(self::validation(false)->getErrors(), "danger");
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
            if ($announce->hasCategory($category)) {
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

        if (isset($params[1]) && !empty($params[1])
            && isset($params[2]) && !empty($params[2])
            && Registered::valueIssetInDB("slug", $params[1], Category::TABLE_NAME)
            && Announce::valueIssetInDB("slug", $params[2], Announce::TABLE_NAME)
        ) {
            $announce = Announce::getBySlug($params[2], Announce::TABLE_NAME, "App\Model\Announce");
            $user = $announce->getOwner();
            $registered = new Registered(Session::get() ?? Cookie::get());
            $page = new Page();

            if ($announce->hasOwner($registered)) {
                // on switch sur l'action à exécuter
                switch ($params[3]) {
                    case "update" :
                        $message = null;
                        $htmlNotifier = new NotifyByHTML();

                        if (Update::dataPosted()) {
                            // Si il y'a des erreurs
                            if (!empty(self::validation(true)->getErrors())) {
                                $message = $htmlNotifier->errors(self::validation(true)->getErrors(), "danger");
                            } else { // Sinon On met à jour
                                if ($announce->update()) {
                                    $message = $htmlNotifier->toast("Mise à jour effectuée avec succès", "success");
                                }
                            }
                        }

                        $view = (new AnnounceView($announce))->update($message);
                        break;

                    case "delete" :
                        if ($announce->delete(Announce::TABLE_NAME)) {
                            Utility::redirect($user->getProfileLink()."/posts");
                        }
                        break;

                    default :
                        Utility::redirect($user->getProfileLink()."/posts");
                        break;
                }

                $page->setMetaTitle("L'indice - " . $announce->getTitle());
                $page->setView($view);
                $page->show();
            } else {
                Utility::redirect($registered->getProfileLink()."/posts");
            }

        } else {
            throw new Exception("Ressource non trouvée !");
        }
    }

    public function delete()
    {
        
    }

    /**
     * Permet de faire les validations sur les valeurs postées.
     * à insérer dans la base de données lors de la création ou de la
     * mise à jour d'un compte user.
     * 
     * @param bool $validateImages Permet de dire qu'on veut valider des images.
     * 
     * @return \App\Utilty\Validator
     */
    private static function validation(bool $updating = false, bool $validateImages = true)
    {
        // On fait la validation
        $validate = new Validator();
        $validate->title("title", $_POST["title"]);

        // Validation de la catégorie
        if ($_POST["id_category"] == 0) {
            $validate->addError("category", "Veuillez choisir une catégorie !");
        }

        // Valider la direction
        if (empty($_POST["direction"])) {
            $validate->addError("direction", "Veuillez choisir le sens de l'annonce !");
        } else {
            $validate->name($_POST["direction"], "Le sens ne doit pas comporter de code HTML !");
        }

        // Valider le type
        if (empty($_POST["type"])) {
            $validate->addError("type", "Veuillez choisir le type de l'annonce !");
        } else {
            $validate->name($_POST["type"], "Le type ne doit pas comporter de code HTML !");
        }

        // Validation de la localisation
        if (empty($_POST["location"])) {
            $validate->addError("location", "Veuillez choisir la ville !");
        }
        $validate->name($_POST["location"], "Veuillez vérifier que la localisation ne contient pas de code HTML.");

        // Si l'user a rempli le prix
        if (!empty($_POST["price"])) {
            $validate->price("price", $_POST["price"]);
        }

        $validate->description("description", $_POST["description"]);

        // Si user à coché someone_else
        if (isset($_POST["usertype"]) && $_POST["usertype"] === "someone_else") {
            $validate->email("user_to_join", $_POST["user_to_join"]);
            $validate->phoneNumber("phone", $_POST["phone_number"], "Veuillez entrer un numéro de téléphone valide !");
        }

        if ($validateImages) {
            // Si des images ont été postées
            if (!$updating) {
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
            } else {
                if (!empty($_FILES["images"]["name"][0])) {
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
            }
        }

        return $validate;
    }
}