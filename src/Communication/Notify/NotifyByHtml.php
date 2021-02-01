<?php

namespace App\Communication\Notify;

/** Permet de faire des notification par HTML */
class NotifyByHTML extends Notify
{
    /**
     * Permet d'afficher un message d'exception.
     * 
     * @param string $message Message d'erreur à afficher pour les alert-danger
     * 
     * @return string
     */
    public static function exception(string $message): string
    {
        return <<<HTML
        <div class="container">
            <div class="alert alert-danger">
                {$message}
            </div>
        </div>
HTML;
    }

    /**
     * Affiche un message d'erreur.
     * 
     * @return string
     */
    public function error(string $message, string $class = null)
    {
        return <<<HTML
        <p class="{$class}">
            {$message}
        </p>
HTML;
    }

    /**
     * Retourne la liste des erreurs lors de l'exécution de la validation des
     * données issues d'un formulaire.
     * 
     * @param array $errors Liste des erreurs, dans un tableau ou chaque erreur
     *                      est indexé par une chaîne de caractère.
     * 
     * @return string Liste des erreurs bien formatée en balise ul.
     */
    public function errors(array $errors)
    {
        $text = "<ul>";
        foreach ($errors as $error) {
            $text .= "<li>$error<li/>";
        }
        $text .= "</ul>";

        return $this->toast($text, "danger");
    }

    /**
     * Permet d'afficher un message de type information.
     * 
     * @param string $message Information à afficher.
     * @param string $type    Type de classe bootstrap pour le message.
     * 
     * @return string
     */
    public function toast(string $message, string $type): string
    {
        if ($type === "success") {
            $icon = "check-circle";
        } elseif ($type === "warning") {
            $icon = "exclamation-triangle";
        } elseif ($type === "danger") {
            $icon = "exclamation-circle";
        }

        return <<<HTML
        <div id="toast" class="app-alert-{$type}" style="position: fixed; top: 1rem; right: 1rem; min-width:13rem; max-width:30rem; z-index:999999;">
            <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                alert-dismissible fade show
            </button> -->
            <div class="d-flex align-items-center">
                <div class="text-{$type} mr-3">
                    <i class="fas fa-$icon fa-2x"></i>
                </div>
                <div class="text-{$type}">{$message}</div>
            </div>
        </div>
HTML;
    }

}