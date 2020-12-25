<?php

namespace App\Controller;

use App\Action\Create;
use App\File\FileUploaded;
use App\File\Image\Image;
use App\Model\Announce;
use App\Utility\Validator;
use App\View\Model\AnnounceView;
use App\View\Notification;
use App\View\Page\Page;

class AnnounceController extends AppController
{
    public static function create()
    {
        // La notification à afficher selon l'issue de l'action
        $notification = new Notification();
        $message = null;

        if (isset($_POST) && !empty($_POST)) {
        
            // On fait la validation
            $validate = new Validator();

            $validate->title("title", $_POST["title"]);
            $validate->description("description", $_POST["description"]);
            $validate->name($_POST["location"], "Veuillez vérifier que les noms de ville et de pays ne contiennent pas de code HTML.");

            if ($_POST["id_category"] == 0) {
                $validate->addError("category", "Veuillez choisir une catégorie !");
            }

            // Si l'user a rempli le prix
            if (!empty($_POST["price"])) {
                $validate->price("price", $_POST["price"]);
            }

            // Si user à coché someone_else
            if (isset($_POST["usertype"]) && $_POST["usertype"] === "someone_else") {
                $validate->email("user_email_address", $_POST["user_email_address"]);
                $validate->phone("phone", $_POST["phone"], "Veuillez entrer un numéro de téléphone valide !");
            }

            if (Create::fileIsUploaded("images")) {
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

            if (!empty($validate->getErrors())) { // Si il y'a des erreurs
                $message = $notification->errors($validate->getErrors(), "danger");
            } else { // Sinon On save
                if (Announce::create()) {
                    $message = $notification->toast("Enregistrement effectué avec succès", "success");
                }
            }
        }

        $page = new Page("Publier une annonce", (new AnnounceView)->create($message));
        $page->setDescription("");
        $page->show();
    }

    /**
     * Controller pour afficher les détails d'une annonce.
     * 
     * @param array $url C'est le tableau qui contient l'url découpée.
     *                   La partie de ce tableau nous interressant est
     *                   l'index 1
     * 
     * @return void
     */
    static function read(array $url = null)
    {
        $page = new Page("Titre de l'annonce", (new AnnounceView())->read());
        $page->show();
    }
}