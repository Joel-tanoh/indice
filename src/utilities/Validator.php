<?php

/**
 * Fichier de classe
 * 
 * PHP verison 7.1.9
 * 
 * @category Category
 * @package  Package
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com license
 * @version  "GIT: <Joel-tanoh>"
 * @link     Link
 */

namespace App\Utilities;

use App\Auth\Password;
use App\Files\FileUploaded;
use App\views\Notification;

/**
 * Permet de faire toutes les vérifications sur les données entrées dans les
 * formulaires.
 * 
 * @category Category
 * @package  Package
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com license
 * @link     Link
 */
class Validator
{
    /**
     * RegEx pour les comparaison HTML
     * 
     * @var string
     */
    const HTML_REGEX = "#<.*>#";

    /**
     * RegEx pour comparer aux adresses emails.
     * 
     * @var string
     */
    const EMAIL_REGEX = "#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i";

    /**
     * La longeur minimal des mots de passes.
     * 
     * @var string
     */
    const PASSWORD_LENGTH = 8;

    /**
     * Tableau contenant les erreurs après validation de variables.
     * 
     * @var array
     */
    private $errors = [];

    /**
     * Tableau contenant les variables à valider.
     * 
     * @var array
     */
    private $toValidate = [];

    private $notifier;

    /**
     * Instancie un objet pour la validation.
     * 
     * @param $data Les données qu'on veut valider. Très souvent ces données
     *              proviennent du formulaire donc de la variable superglobale
     *              $_POST. Ils peuvent aussi provenir de GET.
     * 
     * @author Joel 
     */
    public function __construct(array $data = null)
    {
        $this->notifier = new Notification();

        extract($data);

        if (isset($login)) {
            $this->validateLogin($login);
        }

        if (isset($password)) {
            $password = new Password($password);
            $password->isValid();
            $password->validateConfirmation($confirm_password);
            $this->errors[] = $password->getErrors();
        }

        if (!empty($email)) {
            $this->isEmailAddress($email);
        }
        
        if (isset($title)) {
            $this->validateTitle($title);
        }

        if (isset($description)) {
            $this->validateDescription($description);
        }

        if (isset($article_content)) {
            $this->validateArticleContent($article_content);
        }

        if (!empty($price)) {
            $this->validatePrice($price);
        }

        if (!empty($rank)) {
            $this->validateRank($rank);
        }

        if (!empty($youtube_video_link) ) {
            $this->validateVideoLink($youtube_video_link);
        }

        if (!empty($_FILES["image_uploaded"]["name"])) {
            $this->validateImage();
        }

        if (!empty($_FILES["pdf_uploaded"]["name"])) {
            $this->validatePdfFile();
        }
        
    }

    /**
     * Retourne les erreurs à l'issu de la validation des données. Chaque champ
     * du tableau a pour nom le nom issu du POST ou du GET.
     * 
     * @return array Le tableau contenant les erreurs.
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Valide le titre de l'item qu'on veut créer.
     * 
     * @param string $title Le titre de l'item à valider.
     * 
     * @return string
     */
    public function validateTitle(string $title = null)
    {
        $this->toValidate["title"] = $title;

        if (empty($title)) {
            $this->errors["title"] = $this->notifier->titleIsEmpty();
        } elseif ($this->containsHTML($title)) {
            $this->errors["title"] = $this->notifier->titleContainsHTML();
        }
    }

    /**
     * Valide la description, retourne une chaine de caractère si la description
     * est invalide.
     * 
     * @param string $description La description à valider.
     * 
     * @return string
     */
    public function validateDescription(string $description = null)
    {
        $this->toValidate["description"] = $description;

        if (empty($description)) {
            $this->errors["description"] = $this->notifier->descriptionIsEmpty();
        } elseif ($this->containsHTML($description)) {
            $this->errors["description"] = $this->notifier->descriptionContainsHTML();
        }
    }

    /**
     * Permet de vérifier que l'article a un contenu.
     * 
     * @param string $articleContent Le contenu de l'article.
     * 
     * @return string Une notification si l'article est vide.
     */
    public function validateArticleContent(string $articleContent = null)
    {
        $this->toValidate["article_content"] = $articleContent;

        if (empty($articleContent)) {
            $this->errors["article_content"] = $this->notifier->articleContentIsEmpty();
        }
    }

    /**
     * Permet de vérifier que le price saisi l'utilisateur est un entier.
     * 
     * @param string $price Le price saisi par l'utilisateur.
     * 
     * @return string Une notification si le price n'est pas un entier.
     */
    public function validatePrice(string $price = null)
    {
        $this->toValidate["price"] = $price;

        if (!is_int((int)$price)) {
            $this->errors["price"] = $this->notifier->IsNotInt("price");
        }
    }

    /**
     * Permet de vérifier que le rang saisi l'utilisateur est un entier.
     * 
     * @param string $rang Le rang saisi par l'utilisateur.
     * 
     * @return string Une notification si le rang n'est pas un entier.
     */
    public function validateRank(string $rank = null)
    {
        $rank = (int)$rank;
        $this->toValidate["rank"] = $rank;

        if (!is_int($rank)) {
            $this->errors["rank"] = $this->notifier->IsNotInt("rank");
        }
    }

    /**
     * Permet de valider le login saisi par l'utilisateur.
     * 
     * @param string $login Le login saisi par l'utilisateur.
     * 
     * @return string Une notification si le login est invalide.
     */
    public function validateLogin(string $login = null)
    {
        $this->toValidate["login"] = $login;

        if (empty($login)) {
            $this->errors["login"] = $this->notifier->loginIsEmpty();
        } elseif ($this->containsHTML($login)) {
            $this->errors["login"] = $this->notifier->loginContainsHTML();
        }
    }

    /**
     * Permet de valider que le fichier uploadé dans le champ image est une image
     * et qu'elle respecte les conditions de poids, d'extension et d'erreur.
     * 
     * @return string
     */
    public function validateImage()
    {  
        $this->toValidate["image_uploaded"] = $_FILES["image_uploaded"];
        $image_uploaded = new FileUploaded($_FILES["image_uploaded"]);
        if (!$image_uploaded->isAnImageHasValidSizeAndNoError()) {
            $this->errors["image_uploaded"] = $this->notifier->imageIsInvalid();
        }
    }

    /**
     * Permet de vérifier que le fichier pdf uplaodé est exactement un fichier PDF.
     * 
     * @return string
     */
    public function validatePdfFile()
    {
        $this->toValidate["pdf_uploaded"] = $_FILES["pdf_uploaded"];
        $pdf_uploaded = new FileUploaded($_FILES["pdf_uploaded"]);
        if (!$pdf_uploaded->isPdfFile()) {
            $this->errors["pdf_uploaded"] = $this->notifier->isNotPdfFile();
        }
    }

    /**
     * Effectue les validations sur le lien de la vidéo.
     * 
     * @param $youtube_video_link Lien de la vidéo de description.
     * 
     * @return string|null
     */
    public function validateVideoLink(string $youtube_video_link = null)
    {
        $this->toValidate["youtube_video_link"] = $youtube_video_link;
        if ($this->containsHTML($youtube_video_link)) {
            $this->errors["youtube_video_link"] = $this->notifier->videoLinkIsInvalid();
        }
    }
    
    /**
     * Effectue les validations sur un nom. Vérifie que le nom n'excède pas 250
     * caractères ou qu'il ne contient pas de code HTML.
     * 
     * @param string $name     Le nom qu'il faut valider.
     * @param string $postName La valeur de l'attribut name dans le
     *                         le formulaire.
     * 
     * @return string|null
     */
    public function validateName(string $name = null, string $postName = null)
    {
        $this->toValidate[$postName] = $name;
        if (strlen($name) > 250 ) {
            $this->errors[$postName] = "Veuillez vérifier que le nom n'excède pas 250 caractères.";
        } elseif ($this->containsHTML($name)) {
            $this->errors[$postName] = "Veuillez vérifier que le nom ne contient pas de code HTML.";
        }
    }
  
    /**
     * Effectue les validations sur un email.
     * 
     * @param string $email Email à vérifier.
     * 
     * @return bool
     */
    public function isEmailAddress(string $email)
    {
        $this->toValidate["email"] = $email;

        if (!preg_match(self::EMAIL_REGEX, $email)) {
            $this->errors["email"] = $this->notifier->emailIsInvalid();
            return false;
        } else {
            return true;
        }
    }

    /**
     * Retourne true si la chaîne de caractère passée en paramètre contient du code
     * HTML.
     * 
     * @param string $var La chaîne dont il faut faire la vérification.
     * 
     * @return bool
     */
    public function containsHTML(string $var) : bool
    {
        return preg_match(self::HTML_REGEX, $var);
    }

    /**
     * Permet de vérifier que la valeur passée en paramètre est une chaîne
     * de caractère.
     * 
     * @param string $var
     * 
     * @return bool
     */
    public function isString($var)
    {
        return is_string($var);
    }

    /**
     * Permet de vérifier que la variable passée en paramètre est
     * un format valide de numéro de téléphone.
     * 
     * @param $var
     * 
     * @return bool
     */
    public function isPhoneNumber($var)
    {
        return !$this->containsLetter($var);
    }

    /**
     * Permet de vérifier si la variable passée en paramètre
     * contient des lettres.
     * 
     * @param $var
     * 
     * @return bool
     */
    public function containsLetter($var)
    {
        return preg_match("#[A-Z]#i", $var);
    }

}