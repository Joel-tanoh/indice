<?php
/**
 * Description
 * 
 * PHP version 7.1.9
 * 
 * @category Category
 * @package  Package
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com license_name
 * @version  "CVS: cvs_id"
 * @link     Link
 */

namespace App\View;

use App\Model\Items\ItemParent;
use App\Model\Items\ItemChild;
use App\Model\Entity;
use App\Utilities\Utility;

/**
 * Classe qui gère les formulaires.
 * 
 * @category Category
 * @package  Package
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com license_name
 * @version  "Release: package_version"
 * @link     Link
 */
class Form extends View
{
    /**
     * Retourne un formulaire en fonction de la catégorie passée en paramètre.
     * 
     * @param string $categorie La catégorie.
     * @param mixed  $item 
     * 
     * @return string Le contenu du formulaire.
     */
    public function getFor($categorie, $item = null)
    {
        if ($categorie === "administrateurs") return $this->addAdministratorForm($item);

        elseif (ItemParent::isParentCategorie($categorie)) $formContent = $this->addParentForm($item, $categorie);

        elseif ($categorie === "articles") $formContent = $this->addArticleForm($item);

        elseif ($categorie === "videos"|| $categorie === "motivation-plus") $formContent = $this->addVideoForm($item);

        elseif ($categorie === "mini-services") $formContent = $this->addMiniserviceForm($item, $categorie);

        elseif (ItemChild::isChildCategorie($categorie)) $formContent = $this->addChildForm($item, $categorie);

        else Utility::header(ADMIN_URL);

        return $this->returnForm($formContent);
    }

    /**
     * Retourne le formulaire pour administrateur.
     * 
     * @param $admin 
     * 
     * @return string
     */
    public function addAdministratorForm($admin = null)
    {
        return <<<HTML
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form id="myForm" method="post" enctype="multipart/form-data" action="{$_SERVER['REQUEST_URI']}">
                            {$this->loginInput($admin, "col-12 form-control")}
                            {$this->passwordInput("col-12 form-control")}
                            {$this->confirmPasswordInput("col-12 form-control")}
                            {$this->emailInput($admin, "col-12 form-control")}
                            {$this->chooseAdministratorRole()}
                            {$this->avatarInput()}
                            {$this->submitButton('enregistrement', 'Enregistrer')}
                        </form>
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Formulaire d'un item parent.
     * 
     * @param mixed $item 
     * @param string $categorie
     * 
     * @return string Le formulaire.
     */
    public function addParentForm($item = null, string $categorie)
    {
        $priceLabel = <<<HTML
        Prix :
        <p class="notice">Ce sera la somme que les utilisateurs devront payer pour accéder à cet élément</p>
HTML;
        return $this->commonItemsInformations($item, $priceLabel, $categorie);
    }

    /**
     * Retourne le formulaire pour ajouter une formation.
     * 
     * @param $item
     * 
     * @return string
     */
    public function addFormationForm($item = null)
    {
        $priceLabel = <<<HTML
        Prix :
        <p class="notice">Ce sera la somme que les utilisateurs devront payer pour avoir accès à cet élément</p>
HTML;
        return <<<HTML
        <div class="row mb-2">
            <div class="col-md-8">
                {$this->titleInput($item)}
                {$this->descriptionTextarea($item)}
            </div>
            <div class="col-md-4">
                {$this->priceInput($item, $priceLabel)}
                {$this->rankInput($item, "formations")}
                {$this->videoInput($item)}
                {$this->imageInput()}
                {$this->notifyUsersBox()}
            </div>
        </div>
HTML;
    }

    /**
     * Formulaire d'un item enfant.
     * 
     * @param mixed  $item 
     * @param string $categorie
     * 
     * @return string Le formulaire.
     */
    public function addChildForm($item = null, string $categorie = null)
    {
        $priceLabel = <<<HTML
        Prix :
        <p class="notice">Ce sera la somme que les utilisateurs devront payer pour avoir accès à cet élément</p>
HTML;
        return $this->commonItemsInformations($item, $priceLabel, $categorie)
            . $this->articleContentTextarea($item, $categorie);
    }

    /**
     * Formulaire d'un item enfant.
     * 
     * @param mixed  $item 
     * @param string $categorie
     * 
     * @return string Le formulaire.
     */
    public function addArticleForm($item = null)
    {
        $priceLabel = <<<HTML
        Prix :
        <p class="notice">Ce sera la somme que les utilisateurs devront payer pour
        avoir accès à cet élément</p>
HTML;

        return <<<HTML
        <div class="row">
            <div class="col-md-8">
                {$this->selectParent("videos")}
                {$this->titleInput($item)}
                {$this->descriptionTextarea($item)}
            </div>
            <div class="col-md-4">
                {$this->videoInput($item)}
                {$this->imageInput()}
                {$this->priceInput($item, $priceLabel)}
                {$this->rankInput($item, "videos")}
                {$this->notifyUsersBox()}
            </div>
        </div>
        {$this->articleContentToModify($item)}
        {$this->articleContentTextarea($item, "articles")}
HTML;
    }

    /**
     * Formumaire d'ajout d'une vidéo.
     * 
     * @param mixed $item Dans le cas ou le formulaire charge pour une modification.
     * 
     * @return string
     */
    public function addVideoForm($item = null)
    {
        $priceLabel = <<<HTML
        Prix :
        <p class="notice">Ce sera la somme que les utilisateurs devront payer pour
        avoir accès à cet élément</p>
HTML;
        
        return <<<HTML
        <div class="row">
            <div class="col-md-8">
                {$this->selectParent("videos")}
                {$this->titleInput($item)}
                {$this->videoInput($item)}
                {$this->descriptionTextarea($item)}
            </div>
            <div class="col-md-4">
                {$this->priceInput($item, $priceLabel)}
                {$this->rankInput($item, "videos")}
                {$this->imageInput()}
                {$this->notifyUsersBox()}
            </div>
        </div>
HTML;
    }

    /**
     * Formulaire pour ajouter un mini service.
     * 
     * @param $item      A passer dans le cas ou on veut modifier un miniservice.
     * @param $categorie 
     * 
     * @return string
     */
    public function addMiniserviceForm($item = null, string $categorie = null)
    {
        $miniservicePriceLabel = <<<HTML
        Prix :
        <p class="notice">
            Cette somme sera affichée aux utilisateurs qui voudront ce service
        </p>
HTML;
        return $this->commonItemsInformations($item, $miniservicePriceLabel, $categorie);
    }

    /**
     * Retourne un bloc qui affiche le titre et la description sur la même
     * ligne.
     * 
     * @param mixed  $item       L'item à passer en paramètre si c'est dans le
     *                           cas de la modification d'un item.
     * @param string $priceLabel 
     * @param string $categorie  
     * 
     * @return string
     */
    public function commonItemsInformations($item = null, $priceLabel = null, $categorie = null)
    {
        $uploadPdf = $categorie === "ebooks" ? true : false;

        return <<<HTML
        <div class="row mb-2">
            <div class="col-12 col-md-8">
                {$this->selectParent($categorie)}
                {$this->titleInput($item)}
                {$this->descriptionTextarea($item)}
            </div>
            <div class="col-12 col-md-4">
                {$this->videoInput($item)}
                {$this->priceInput($item, $priceLabel)}
                {$this->rankInput($item, $categorie)}
                {$this->imageInput()}
                {$this->pdfFileInput($uploadPdf)}
                {$this->notifyUsersBox()}
            </div>
        </div>
HTML;
    }

    /**
     * Retourne le code pour un input pour entrer le login d'un compte qu'on veut
     * créer.
     * 
     * @param mixed  $user 
     * @param string $class 
     * 
     * @return string
     */
    public function loginInput($user = null, string $class = null)
    {
        $login = !is_null($user) ? $user->getLogin() : "";
        $label = $this->label("login", "Login");

        extract($_POST);
        $input = $this->text('login', 'login', $login, "Login", $class);

        return <<<HTML
        <div class="form-group">
            {$label}
            {$input}
        </div>
HTML;
    }

    /**
     * Retourne un input pour saisir un mot de passe.
     * 
     * @param string $class 
     * 
     * @return string
     */
    public function passwordInput(string $class = null)
    {
        $password = "";

        extract($_POST);

        return <<<HTML
        <div class="form-group">
            {$this->label("password", "Entrez le mot de passe")}
            {$this->passwordInput('password', 'password', $password, "Saisir le mot de passe", $class)}
        </div>
HTML;
    }

    /**
     * Retourne un champ pour saisir un email avec son label.
     * 
     * @param mixed  $user 
     * @param string $class 
     * 
     * @return string
     */
    public function emailInput($user = null, string $class = null)
    {
        $email = !is_null($user) ? $user->getEmailAddress(): "";

        extract($_POST);

        return <<<HTML
        <div class="form-group">
            {$this->label("email", "Adresse email")}
            {$this->email('email', 'email', $email, "johny@mail.com", $class)}
        </div>
HTML;
    }

    /**
     * Retourne deux boutons radios pour choisir le type de compte.
     * 
     * @return string
     */
    public function chooseAdministratorRole()
    {
        return <<<HTML
        {$this->label("", "Type de compte :")}
        <div class="row mb-2">
            <span class="col-6">
                {$this->radio("role", "3", "Administrateur tous droits")}
            </span>
            <span class="col-6">
                {$this->radio("role", "2", "Administrateur droits réservés")}
            </span>
        </div>
HTML;
    }

    /**
     * Retourne un input pour confirmer le mot de passe.
     * 
     * @param string $class 
     * 
     * @return string
     */
    public function confirmPasswordInput(string $class = null)
    {
        $confirmInputPassword = "";

        extract($_POST);
        $input = $this->passwordInput("confirminputPassword", "confirmPassword", $confirmInputPassword, "Confirmer le mot de passe", $class);

        return <<<HTML
        <div class="form-group">
            {$this->label("confirmPassword", "Confirmez le mot de passe")}
            {$input}
        </div>
HTML;
    }

    /**
     * Retourne une liste de bouton radio pour choisir le type de l'item parent
     * et une liste dans laquelle sera affiché les items dont le type a été choisi
     * dans la liste.
     * 
     * @param string $categorie
     * 
     * @return string
     */
    public function selectParent(string $categorie = null)
    {
        if (null !== $categorie && ItemChild::isChildCategorie($categorie) && $categorie !== "mini-services") {

            return <<<HTML
            <div id="chooseParentBox" class="mb-2">
                {$this->label("selectParentList", "Choisir le parent :")}
                <select name="parent_code" id="selectParentList" class="select2 col-12 form-control">
                    <option value="0">-- Sans parent --</option>
                    <option value="MTVP">Motivation plus</option>
                    {$this->parentList()}
                </select>
            </div>
HTML;
        }
    }

    /**
     * Retourne un champ dans le formulaire pour le titre.
     * 
     * @param mixed $item 
     * 
     * @return string Le code HTML pour le champ.
     */
    public function titleInput($item = null)
    {
        $title = null !== $item ? $item->getTitle() : "";

        extract($_POST);

        return <<<HTML
        <div class="form-group">
            {$this->label("title", "Titre")}
            {$this->text('title', 'title', $title, "Saisir le titre", "col-12 form-control")}
        </div>
HTML;
    }

    /**
     * Retourne un champ de type textarea pour le champ de la description
     * de l'item à ajouter.
     * 
     * @param mixed $item 
     * 
     * @return string Le code HTML de la description.
     */
    public function descriptionTextarea($item)
    {
        $description = !is_null($item) ? $item->getDescription() : "";

        extract($_POST);

        return <<<HTML
        <div class="form-group">
            {$this->label("descriptionTextarea", "Description")}
            {$this->textarea('description', 'descriptionTextarea', "Saisir la description...", $description, "form-control", "10")}
        </div>
HTML;
    }
    
    /**
     * Retourne un champ de type textarea pour écrire le contenu d'un article.
     * 
     * @param $item      A passer dans le cas ou on veut modifier un item.
     * @param string $categorie 
     * 
     * @return string Le code HTML pour le champ du contenu de l'article.
     */
    public function articleContentTextarea($item = null, string $categorie = null)
    {
        $articleContent = null !== $item ? $item->getArticleContent() : $categorie === "articles" ? "" : null;

        extract($_POST);

        if (null !== $articleContent) {
            return <<<HTML
            <div class="row mt-3">
                <div class="col-12">
                    <div class="form-group">
                        {$this->textarea('article_content', "summernote", null, $articleContent)}
                    </div>
                </div>
            </div>
HTML;
        }
    }

    /**
     * Retourne un champ dans le formulaire pour le price.
     * 
     * @param mixed  $item 
     * @param string $label 
     * 
     * @return string Le code HTML pour le champ.
     */
    public function priceInput($item = null, $label = null)
    {
        $price =  !is_null($item) ? $item->getPrice() : "";

        extract($_POST);

        return <<<HTML
        <div class="form-group">
            <div class="card">
                <div class="card-body">
                    {$this->label("Prix", $label)}
                    {$this->number('price', 'Prix', $price, "Prix", "col-12 form-control", 0)}
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Retourne un champ dans le formulaire pour le rang.
     * 
     * @param mixed $item 
     * @param string $categorie 
     * 
     * @return string Le code HTML pour le champ.
     */
    public function rankInput($item = null, string $categorie = null)
    {
        if (null !== $item) {
            $rank = $item->getRank();
            $rank = $rank == "1" ? $rank . "er" : $rank . "ème";

            $label = <<<HTML
            Donnez un rang à cet élément :
            <p class="notice"> Cet élément sera classé : {$rank}</p>
HTML;
        } else {
            $database = Entity::database();
            $rank = $database->getMaxValueOf("rank", Entity::getTableName($categorie), "categorie", "categorie", $categorie) + 1;
            $rank = $rank == "1" ? $rank . "er" : $rank . "ème";

            $label = <<<HTML
            Donnez un rang à cet élément :
            <p class="notice"> Cet élément sera classé : {$rank}</p>
HTML;
        }

        extract($_POST);

        return <<<HTML
        <div class="form-group">
            <div class="card">
                <div class="card-body">
                    {$this->label("rank", $label)}
                    {$this->number('rank', 'rank', (int)$rank, "Rang", "col-12 form-control", 1)}
                </div>
            </div>
        </div>
HTML;
    }
        
    /**
     * Champ pour entrer le lien d'une vidéo.
     * 
     * @param mixed $item 
     * 
     * @return string|null
     */
    public function videoInput($item = null)
    {
        $ytbeVideoLink = null !== $item ? $item->getVideoLink("youtube") : "";

        $label = <<<HTML
        Coller l'id de la vidéo de Youtube :
        <p class="notice">Cette vidéo peut être une vidéo de description</p>
HTML;
        extract($_POST);

        return <<<HTML
        <div class="form-group">
            <div class="card">
                <div class="card-body">
                    {$this->label("videoLink", $label)}
                    {$this->text('youtube_video_link', 'videoLink', $ytbeVideoLink, 'www.youtube.com?v=...', "col-12 form-control")}
                </div>
            </div>
        </div>
HTML;
    }
       
    /**
     * Retourne un champ de type file pour pouvoir uploader un fichier image.
     * 
     * @return string Le code HTML pour le champ.
     */
    public function avatarInput()
    {
        return <<<HTML
        <div class="form-group">
            <div class="card">
                <div class="card-body">
                    {$this->label("avatarUploaded", "Importer un avatar :")}
                    {$this->fileInput("avatar_uploaded", "avatarUploaded")}
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Retourne un champ de type file pour pouvoir uploader un fichier image.
     * 
     * @param bool $image_uploaded Permet de dire si le formulaire doit contenir
     *                             un champ pour une image de couverture.
     * 
     * @return string Le code HTML pour le champ.
     */
    public function imageInput(bool $image_uploaded = null)
    {
        return <<<HTML
        <div class="form-group">
            <div class="card">
                <div class="card-body">
                    {$this->label("imageUploaded", "Importer une image de couverture :")}
                    {$this->fileInput("image_uploaded", "imageUploaded")}
                </div>
            </div>
        </div>
HTML;
    }
   
    /**
     * Retourne un champ de type file pour pouvoir uploader un fichier pdf.
     * 
     * @param bool $pdf_uploaded Permet de dire si le formulaire doit contenir
     *                           un champ pour un fichier pdf.
     * 
     * @return string Le code HTML pour le champ.
     */
    public function pdfFileInput(bool $pdf_uploaded = null)
    {
        if ($pdf_uploaded) {
            return <<<HTML
            <div class="form-group">
                <div class="card">
                    <div class="card-body">
                        {$this->label("pdfUploaded", "Importer un fichier PDF :")}
                        {$this->fileInput("pdf_uploaded", "pdfUploaded")}
                    </div>
                </div>
            </div>
HTML;
        }
    }

    /**
     * Retourne une checkbox que l'utilisateur peut cocher au cas où il veut informer
     * les abonnés de la création d'un nouvel item.
     * 
     * @return string|null
     */
    public function notifyUsersBox()
    {
//         return <<<HTML
//         <div class="card p-3">
//             <div class="mb-2">Envoyer une notification à :</div>
//             <div class="custom-control custom-radio">
//                 <input class="custom-control-input" type="radio" id="informAll" name="notify_users" value="all">
//                 <label for="informAll" class="custom-control-label">tous les utilisateurs :</label>
//                 <p class="notice">Les emails seront envoyés à tous les utilisateurs</p>
//             </div>
//             <div class="custom-control custom-radio">
//                 <input class="custom-control-input" type="radio" id="customRadio2" name="notify_users" value="newsletter">
//                 <label for="customRadio2" class="custom-control-label">que la newsletter :</label>
//                 <p class="notice">Les emails seront envoyés qu'aux abonnés à la newsletter</p>
//             </div>
//             <div class="custom-control custom-radio">
//                 <input class="custom-control-input" type="radio" id="customRadio3" name="notify_users" value="registereds">
//                 <label for="customRadio3" class="custom-control-label">que les personnes inscrites :</label>
//                 <p class="notice">Les emails seront envoyés qu'à ceux qui sont abonnés à une
//                     formation ou à une étape</p>
//             </div>
//         </div>
// HTML;
    }

    /**
     * Retourne une balise HTML label
     * 
     * @param string $for   [[Description]]
     * @param string $label [[Description]]
     * @param string $class
     * 
     * @author Joel
     * @return string
     */
    public function label(string $for = null, string $label = null, string $class = null) : string
    {
        return <<<HTML
		<label for="{$for}" class="{$class}">{$label}</label>
HTML;
    }

    /**
     * Retourne un bouton de submit.
     * 
     * @param string $name  [[Description]]
     * @param string $text  [[Description]]
     * @param string $class [[Description]]
     * 
     * @return string
     */
    public function submitButton(string $name = null,  string $text = null, string $class = null)
    {
        return $this->button("submit", $name, $text, "btn-sm btn-success");
    }

    /**
     * Retourne un input.
     * 
     * @param string $type        
     * @param string $name        [[Description]]
     * @param string $id          [[Description]]
     * @param string $value       [[Description]] 
     * @param string $placeholder [[Description]] 
     * @param string $class       
     * @param int    $min         
     * @param int    $max  
     * 
     * @return string
     */
    public function input(string $type = null, string $name = null, string $id = null, string $value = null, string $placeholder = null, string $class = null, int    $min = null, int    $max = null)
    {
        return <<<HTML
        <input type="{$type}" name="{$name}" id="{$id}" value="{$value}" placeholder="{$placeholder}" min="{$min}" max="{$max}" class="{$class}"/>
HTML;
    }
    
    /**
     * Retourne une balise HTML button
     * 
     * @param string $type 
     * @param string $name  
     * @param string $text  
     * @param string $class  
     * 
     * @author Joel
     * @return string [[Description]]
     */
    public function button(string $type = null, string $name = null,  string $text = null, string $class = null)
    {
        return <<<HTML
		<button type="{$type}" name="{$name}" class="{$class}">{$text}</button>
HTML;
    }

    /**
     * Retourne le formulaire.
     * 
     * @param string $formContent 
     * 
     * @return string
     */
    private function returnForm($formContent)
    {
        if ($formContent) {
            return <<<HTML
            <form id="myForm" method="post" enctype="multipart/form-data"
                action="{$_SERVER['REQUEST_URI']}" class="mb-3">
                {$formContent}
                <div class="row">
                    <div class="col-12">
                        {$this->submitButton('enregistrement', 'Enregistrer')}
                    </div>
                </div>
            </form>
HTML;
        }
    }

    /**
     * Affiche la liste des items parents pour en choisir un comme parent de
     * l'item enfant que l'utlisateur veut créer.
     * 
     * @return string
     */
    private function parentList()
    {
        $options = null;
        $items = ItemParent::getAllItems();

        foreach ($items as $item) {
            $options .= '<option value="'. $item->getCode() . '">';
            $options .= ucfirst($item->getTitle()) . ' - ' . ucfirst($item->getCategorie());
            $options .= '</option>';
        }

        return $options;
    }

    /**
     * Retourne un input pour le formulaire de type file
     * 
     * @param string $name 
     * @param string $id 
     * @param string $class  
     * 
     * @return string
     */
    private function fileInput(string $name = null, string $id = null, string $class = null)
    {
        return <<<HTML
        <div class="{$class}">
            <div class="custom-file">
                {$this->input("file", $name, $id, null, null, "custom-file-input")}
                {$this->label("customFile", "Importer", "custom-file-label")}
            </div>
        </div>
HTML;
    }
    
    /**
     * Retourne une balise input pour le texte.
     * 
     * @param string $name        [[Description]]
     * @param string $id          [[Description]]
     * @param string $value       [[Description]] 
     * @param string $placeholder [[Description]] 
     * @param string $class 
     * 
     * @return string
     */
    private function text(string $name = null,  string $id = null,  string $value = null,  string $placeholder = null, string $class = null)
    {
        return $this->input("text", $name, $id, $value, $placeholder, $class);
    }
    
    /**
     * Retourne une balise input pour saisir un mot de passe.
     * 
     * @param string $name        [[Description]]
     * @param string $id          [[Description]]
     * @param string $value       [[Description]] 
     * @param string $placeholder [[Description]]
     * @param string $class 
     * 
     * @return string
     */
    private function password(string $name = null, string $id = null, string $value = null, string $placeholder = null, string $class = null)
    {
        return $this->input("password", $name, $id, $value, $placeholder, $class);
    }

    /**
     * Retourne une balise HTML input pour saisir un email
     * 
     * @param string $name        [[Description]]
     * @param string $id          [[Description]]
     * @param string $value       [[Description]] 
     * @param string $placeholder [[Description]]
     * @param string $class 
     * 
     * @author Joel
     * @return string [[Description]]
     */
    private function email(string $name = null,  string $id = null, string $value = null,  string $placeholder = null, string $class = null)
    {
        return $this->input("email", $name, $id, $value, $placeholder, $class);
    }

    /**
     * Retourne une balise de bouton radio.
     * 
     * @param string $name  Nom de la balise dans la variable superglobale $_POST.
     * @param string $value La valeur que doit contenir la balise.
     * @param string $text  Texte à afficher.
     * @param string $class 
     * 
     * @return string
     */
    private function radio(string $name = null, string $value = null, string $text = null, string $class = null)
    {
        return <<<HTML
        <label>
            <input type="radio" name="{$name}" id="" value="{$value}" class="{$class}"> {$text}
        </label>
HTML;
    }

    /**
     * Retourne une balise HTML input pour de type number.
     * 
     * @param string $name        [[Description]]
     * @param string $id          [[Description]]
     * @param string $value       [[Description]] 
     * @param string $placeholder [[Description]] 
     * @param string $class    
     * @param int    $min         
     * @param int    $max       
     * 
     * @author Joel
     * @return string [[Description]]
     */
    private function number(string $name = null, string $id = null, string $value = null, string $placeholder = null, string $class = null, int    $min = null, int    $max = null)
    {
        return $this->input("number", $name, $id, $value, $placeholder, $class, $min, $max);
    }

    /**
     * Retourne une balise HTML textarea.
     * 
     * @param string $name        
     * @param string $id          
     * @param string $placeholder 
     * @param string $value 
     * @param string $class   
     * @param string $rows        
     * 
     * @author Joel
     * @return string 
     */
    private function textarea(string $name = null, string $id = null, string $placeholder = null, string $value = null, string $class = null, string $rows = null)
    {
        return <<<HTML
        <textarea name="{$name}" id="{$id}" rows="{$rows}" placeholder="{$placeholder}" class="col-12 {$class}">{$value}</textarea>
HTML;
    }

    /**
     * Retourne une textarea pour qui contient le contenu de l'article à modifier,
     * ce contenu est récupéré et afficher comme texte par défaut du textarea summernote.
     * 
     * @param \App\Model\Items\ItemChild $item
     * 
     * @return string Une balise de type textarea
     */
    private function articleContentToModify($item = null)
    {
        if (null !== $item) {
            return <<<HTML
            <div id="articleContentToModify" class="d-none">{$item->getArticleContent()}</div>
HTML;
        }
    }
}
