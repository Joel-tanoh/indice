<?php

namespace App\View\Model\User;

use App\Model\Location\Town;
use App\Model\User\User;
use App\View\AdvertisingView;
use App\View\Form;
use App\View\Model\AnnounceView;
use App\View\Model\ModelView;
use App\View\Snippet;

/**
 * Classe de gestion des vues de User.
 */
class UserView extends ModelView
{
    /**
     * Affiche les annonces validées d'un utlisateur.
     * @param \App\Model\User\Registered $user
     * @return  string
     */
    public static function readRegisteredValidatedAnnounces(\App\Model\User\Registered $user)
    {
        return <<<HTML

HTML;
    }

    /**
     * Vue pour la création d'un compte.
     * 
     * @param string $message
     * 
     * @return string
     */
    public static function register(string $message = null)
    {
        $snippet = new Snippet();
        $form = new Form($_SERVER["REQUEST_URI"], "login-form");
        $name = $_POST["name"] ?? null;
        $firstNames = $_POST["first_names"] ?? null;
        $pseudo = $_POST["pseudo"] ?? null;
        $emailAddress = $_POST["email_address"] ?? null;
        $phoneNumber = $_POST["phone_number"] ?? null;

        return <<<HTML
        {$snippet->pageHeader("Je m'inscris", "inscription")}
        {$message}
        <section class="register section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-12 col-xs-12">
                        <div class="register-form login-area">
                            <h3>Inscription</h3>
                            {$form->open()}
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <div class="input-icon">
                                            <i class="lni-user"></i>
                                            <input type="text" id="name" class="form-control" name="name" placeholder="Entrer Votre Nom" value="$name" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="input-icon">
                                            <i class="lni-user"></i>
                                            <input type="text" id="first_names" class="form-control" name="first_names" placeholder="Entrer Votre Prénom" value="$firstNames" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon">
                                        <i class="lni-user"></i>
                                        <input type="text" id="pseudo" class="form-control" name="pseudo" placeholder="Entrer Votre Pseudo" value="$pseudo" required>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <div class="input-icon">
                                        <i class="lni-envelope"></i>
                                        <input type="email" id="sender-email" class="form-control" name="email_address" placeholder="Entrer Votre Adresse email" value="$emailAddress" required>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <div class="input-icon">
                                        <i class="lni-lock"></i>
                                        <input type="password" class="form-control" placeholder="Entre votre mot de passe" name="password" required>
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <div class="input-icon">
                                        <i class="lni-lock"></i>
                                        <input type="password" class="form-control" placeholder="Confirmer le mot de passe" name="confirm_password" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon">
                                        <i class="lni-phone"></i>
                                        <input type="text" id="phone_number" class="form-control" name="phone_number" placeholder="Entrer Votre Numéro de téléphone" value="$phoneNumber" required>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <div class="input-icon">
                                        <label for="avatar">Charger votre avatar :</label>
                                        <i class="lni-file"></i>
                                        <input type="file" id="avatar" class="form-control" name="avatar">
                                    </div>
                                </div> 
                                <div class="form-group mb-3">
                                    <div class="checkbox">
                                        <input type="checkbox" name="accept_condition" value="yes" id="accept_condition" required>
                                        <label for="accept_condition">J'accepte les conditions d'utilisations</label>
                                    </div>
                                </div>   
                                <div class="text-center">
                                    <button class="btn btn-common log-btn">Envoyer</button>
                                </div>
                            {$form->close()}
                        </div>
                    </div>
                </div>
            </div>
        </section>
HTML;
    }

    /**
     * Vue de la connexion.
     * 
     * @param string $error
     * 
     * @return string
     */
    public function signIn(string $error = null)
    {
        $form = new Form($_SERVER["REQUEST_URI"], "login-form", "post", "login-form", "form");
        $snippet = new Snippet();

        return <<<HTML
        {$snippet->pageHeader("S'identifier", "S'identifier")}
        <section class="login section-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-12 col-xs-12">
                        {$error}
                        <div class="login-form login-area">
                            <h3>
                                Identifiez-vous maintenant !
                            </h3>
                            {$form->open()}
                                <div class="form-group">
                                    <div class="input-icon">
                                        <i class="lni-user"></i>
                                        <input type="text" id="sender-email" class="form-control" name="email_address" placeholder="Entrer Votre Adresse Email">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <div class="input-icon">
                                        <i class="lni-lock"></i>
                                        <input type="password" class="form-control" placeholder="Entrer Votre Mot de Passe" name="password">
                                    </div>
                                </div>
                                <p class="form-group">
                                    Pas de compte ? <a href="register">Créer votre compte.</a>
                                </p>                
                                <div class="form-group">
                                    <div class="checkbox">
                                        <input type="checkbox" name="remember_me" value="yes" id="remember_me">
                                        <label for="remember_me">Se souvenir de moi</label>
                                    </div>
                                    {$this->forgotPassword()}
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-common log-btn">Se connecter</button>
                                </div>
                            {$form->close()}
                        </div>
                    </div>
                </div>
            </div>
        </section>
HTML;
    }

    /**
     * Affiche le navbar des utilisateurs.
     * 
     * @return string
     */
    public function navbarMenu()
    {
        if (User::isAuthenticated()) {
            $content = (new RegisteredView())->navbar(User::authenticated());
        } else {
            $content = $this->navbarForUnconnectedUser();
        }

        return <<<HTML
        <ul class="sign-in">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="lni-user"></i> Mon compte</a>
                <div class="dropdown-menu">
                    {$content}                    
                </div>
            </li>
        </ul>
HTML;
    }

    /**
     * Affiche la navbar dans le menu version mobile.
     * 
     * @return string
     */
    public function mobileNavbar()
    {
        if (User::isAuthenticated()) {
            return (new RegisteredView())->mobileNavbarForConnectedUser(User::authenticated());
        } else {
            return $this->mobileNavbarForUnconnectedUser();
        }
    }

    /**
     * Menu qui sera affiché si l'utilisateur n'est pas encore authentifé.
     * 
     * @return string
     */
    private function navbarForUnconnectedUser()
    {
        return <<<HTML
        <a class="dropdown-item" href="register"><i class="lni-user"></i> S'inscrire</a>
        <a class="dropdown-item" href="sign-in"><i class="lni-lock"></i> Connexion</a>
HTML;
    }

    /**
     * Affiche le menu dans la version mobile pour un visitor non connecté.
     * 
     * @return string
     */
    private function mobileNavbarForUnconnectedUser()
    {
        return <<<HTML
        <li><a href="/"><i class="lni-home"></i>Accueil</a></li>
        <li><a href="register"><i class="lni-user"></i> S'inscrire</a></li>
        <li><a href="sign-in"><i class="lni-lock"></i> Connexion</a></li>
HTML;
    }

    /**
     * Affiche un lien pour changer le mot de passe.
     * 
     * @return string
     */
    private function forgotPassword()
    {
        return '<a class="forgetpassword" href="forgot-password">Mot de passe oublié ?</a>';
    }

    /**
     * Affiche la liste des villes.
     * 
     * @return string
     */
    public function townsSelectList(string $postName)
    {
        $options = null;
        foreach (Town::getAll() as $town) {
            $options .= '<option value="' . $town->getName() . '">'. $town->getName() . '</option>';
        }

        return <<<HTML
        <select name="{$postName}">
            <option value="0">Choisir la ville</option>
            {$options}
        </select>
HTML;
    }

    /**
     * Un tableau qui affiche la liste des utilisateurs.
     * 
     * @return string
     */
    public function usersTable(array $users)
    {
        $form = new Form("administration/users/delete", "w-100");
        $usersRows = null;

        foreach ($users as $user) {
            $usersRows .= $this->usersTableRow($user);
        }

        return <<<HTML
        <h5 class="mb-3 p-3">Liste des utilisateurs</h5>
        {$form->open()}
            <table class="table table-hover bg-white">
                {$this->usersTableHead()}
                <tbody>
                    {$usersRows}
                </tbody>
            </table>
        {$form->close()}
HTML;
    }

    /**
     * Affiche les entêtes des colonnes dans le tableau qui liste les utilisateurs.
     * 
     * @return string
     */
    private function usersTableHead()
    {
        return <<<HTML
        <thead>
            <tr>
                <th scope="col"><input type="checkbox" name="users[]" id="checkAllUsers"></th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom(s)</th>
                <th scope="col">Pseudo</th>
                <th scope="col">Nbr. Post</th>
                <th scope="col">Adresse Email</th>
                <th scope="col">Statut</th>
                <th scope="col">Date d'inscription</th>
            </tr>
        </thead>
HTML;
    }

    /**
     * Affiche une ligne dans le tableau qui affiche la liste
     * des utilisateurs.
     * 
     * @param App\Model\User\Registered $user
     */
    private function usersTableRow(\App\Model\User\Registered $user)
    {
        return <<<HTML
        <tr>
            <td><input type="checkbox" name="{$user->getId()}" id="checkAllUsers"></td>
            <td><a href="{$user->getProfileLink()}">{$user->getName()}</a></td>
            <td>{$user->getFirstNames()}</td>
            <td>{$user->getPseudo()}</th>
            <td>{$user->getAnnounceNumber()}</th>
            <td>{$user->getEmailAddress()}</td>
            <td>{$user->getStatus()}</td>
            <td>{$user->getRegisteredAt()}</td>
        </tr>
HTML;
    }

    /**
     * La vue qui affiche les annonces vu du visiteur.
     * 
     * @return string
     */
    public static function showPosts(\App\Model\User\Registered $user, array $posts)
    {
        $snippet = new Snippet;
        $announceView = new AnnounceView();
        $advertising = new AdvertisingView();

        return <<<HTML
        {$snippet->pageHeader("Les meilleures annonces de " .$user->getFullName(), "Annonces / " .$user->getFullName())}
        <section class="container my-4">
            <section class="row">
                <aside class="col-9">
                    {$announceView->list($posts)}
                </aside>
                <aside class="col-3">
                    {$advertising->right()}
                </aside>
            </section>
        </section>
HTML;
    }
}