<?php

namespace App\Controller;

use App\Action\Action;
use App\Action\Update\Update;
use App\Communication\Comment;
use App\Communication\Email;
use App\File\Image\Image;
use App\Model\Announce;
use App\Communication\Notify\NotifyByHTML;
use App\Communication\Notify\NotifyByMail;
use App\Model\Category;
use App\Model\User\User;
use App\Utility\Utility;
use App\Utility\Validator;
use App\View\Model\AnnounceView;
use App\View\Page\Page;
use App\View\View;
use Exception;

abstract class AnnounceController extends AppController
{
    /**
     * Permet de créer une annonce.
     */
    public static function create()
    {
        if (Action::dataPosted()) {
            $htmlNotifier = new NotifyByHTML();

            if (!empty(self::validation(false)->getErrors())) {
                return $htmlNotifier->errors(self::validation(false)->getErrors(), "danger");
            } else {
                if (Announce::create()) {
                    return $htmlNotifier->toast("Enregistrement effectué avec succès", "success");
                }
            }
        }
    }    

    /**
     * Permet de mettre à jour une annonce.
     * @param array $params
     */
    public static function update(array $params)
    {
        $announce = Announce::getBySlug($params[2], Announce::TABLE_NAME, "App\Model\Announce");
        $htmlNotifier = new NotifyByHTML();
        $message = null;
        $page = new Page("Modifier " . $announce->getTitle(), (new AnnounceView($announce))->update());

        if (Update::dataPosted()) {

            if (!empty(self::validation(true)->getErrors())) {
                $message = $htmlNotifier->errors(self::validation(true)->getErrors(), "danger");
                $page->setView(
                    (new AnnounceView($announce))->update($message)
                );

            } else {
                if ($announce->update()) {

                    if ($announce->getLastComment()) {
                        NotifyByMail::administrators(
                            "Nouvelle mise à jour d'annonce",
                            Email::content($announce->updatingEmailNotification())
                        );
                    }

                    $page->setMetatitle("L'indice | Mise à jour effectuée avec succès");
                    $page->setView(
                        View::success(
                            "Mise à jour effectuée avec succès",
                            "La mise à jour a été effectuée avec succès, Merci de nous faire confiance pour vos annonces.",
                            $announce->getLink()
                        )
                    );
                } else {
                    $page->setMetatitle("L'indice | Oup's ! Nous avons rencontré une erreur lors de la modification de votre annonce.");
                    $page->setView(
                        View::success(
                            "Oup's ! Erreur lors de la modification",
                            "Nous avons rencontré une erreur lors de la mise à jour de votre annonce, veuillez réessayer ultérieurement.",
                            $announce->getLink()
                        )
                    );
                }
            }
        }

        $page->show();
    }

    /**
     * Permet de supprimer une annonce.
     * @param \App\Model\Announce $announce
     */
    public static function delete(\App\Model\Announce $announce)
    {
        $page = new Page();

        if ($announce->delete()) {
            NotifyByMail::administrators("Une annonce a été supprimée", "Une annonce a été supprimée.");
            $page->setMetatitle("L'indice | Suppression effectuée avec succès");
            $page->setView(
                View::success(
                    "Suppression effectuée avec succès",
                    "L'annonce a été supprimée avec succès."
                )
            );
            $page->show();

        } else {
            $page->setMetatitle("L'indice | Suppression non effectuée");
            $page->setView(
                View::failed(
                    "La suppression a échoué.",
                    "La suppression de l'annonce n'a pas pû être effectuée. Nous sommes désolé, pouvez vous reprendre l'action svp"
                )
            );
            $page->show();
        }
    }

    /**
     * Permet de valider une annonce.
     * @param array $params
     */
    public static function validate(array $params)
    {
        $announce = Announce::getBySlug($params[2], Announce::TABLE_NAME, "App\Model\Announce");
        $page = new Page();

        if (User::authenticated()->isAdministrator()) {
            if (User::authenticated()->changeStatus($announce->getId(), Announce::convertStatus("validated"), Announce::TABLE_NAME)) {
                $page->setMetatitle("L'indice | Validation effectuée avec succès");
                $page->setView(
                    View::success(
                        "Mise à jour effectuée avec succès",
                        "La mise à jour a été effectuée avec succès, Merci de nous faire confiance pour vos annonces.",
                        $announce->getLink()
                    )
                );
            }
        } else {
            $page->setMetatitle("L'indice | Validation impossible");
            $page->setView(
                View::failed(
                    "Impossible de valider cette annonce",
                    "Vous n'avez pas les droits suffisant pour valider une annonce."
                )
            );
        }

        $page->show();
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
        if ($_POST["id_category"] == 0 || empty($_POST["id_category"])) {
            $validate->addError("category", "Veuillez vérifier que vous avez choisi la catégorie de l'annonce.");
        }

        // Valider la direction
        if (empty($_POST["direction"])) {
            $validate->addError("direction", "Veuillez vérifier que vous avez choisi le sens de l'annonce.");
        } else {
            $validate->name($_POST["direction"], "Le sens ne doit pas comporter de code HTML !");
        }

        // Valider le type
        if (empty($_POST["type"])) {
            $validate->addError("type", "Veuillez vérifier que vous avez choisi le type de l'annonce.");
        } else {
            $validate->name($_POST["type"], "Le type ne doit pas comporter de code HTML.");
        }

        // Validation de la localisation
        if (empty($_POST["location"])) {
            $validate->addError("location", "Veuillez vérifier que vous avez choisi la ville.");
        }
        $validate->name($_POST["location"], "Veuillez vérifier que la localisation ne contient pas de code HTML.");

        // Si l'user a rempli le prix
        if (!empty($_POST["price"])) {
            $validate->price("price", $_POST["price"]);
        }

        $validate->description("description", $_POST["description"]);

        // Si user à coché someone_else
        if ((isset($_POST["usertype"]) && $_POST["usertype"] === "someone_else")
            || (!empty($_POST["user_to_join"]) && !empty($_POST["phone_number"]))
        ) {
            $validate->email("user_to_join", $_POST["user_to_join"]);
            $validate->phoneNumber("phone", $_POST["phone_number"], "Veuillez vérifier que vous avez entré un numéro de téléphone valide !");
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
            } elseif (!empty($_FILES["images"]["name"][0])) {
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

        return $validate;
    }
}