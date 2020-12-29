<?php

namespace App\Model;

use App\Action\Create;
use App\Action\InsertData;
use App\File\Image\Image;
use App\Database\SqlQueryFormater;
use App\Model\User\User;
use App\Utility\Utility;

/**
 * Classe de gestion d'une annonce.
 */
class Announce extends Model
{
    private $category;
    private $subCategory;
    private $price;
    private $user;
    private $userToJoin;
    private $phoneNumber;
    private $location;
    private $state;
    private $postedAt;
    private $views;
    private $iconClass;
    const TABLE_NAME = "ind_announces";
    const IMG_DIR_PATH = Image::IMG_DIR_PATH . DIRECTORY_SEPARATOR . "productinfo" . DIRECTORY_SEPARATOR;
    const IMG_DIR_URL = Image::IMG_DIR_URL . "/productinfo";
    const DEFAULT_THUMBS = Image::IMG_DIR_URL . "/defaul-thumbs" . Image::EXTENSION;

    /**
     * Constructeur de l'objet annonce.
     * 
     * @param int $id
     */
    public function __construct(int $id)
    {
        $queryFormatter = new SqlQueryFormater();

        $query = $queryFormatter->select(
            "id, title, description, slug, id_category, id_sub_category, price,
            user_email_address, user_to_join, phone_number, location, state, created_at, posted_at, updated_at, views, icon_class"
        )->from(self::TABLE_NAME)->where("id = ?")->returnQueryString();

        $rep = parent::connect()->prepare($query);
        $rep->execute([$id]);

        $result = $rep->fetch();

        $this->id = $result["id"];
        $this->title = $result["title"];
        $this->description = $result["description"];
        $this->slug = $result["slug"];
        $this->category = new Category($result["id_category"]);
        $this->subCategory = $result["id_sub_category"];
        $this->price = $result["price"];
        $this->userEmailAddress = $result["user_email_address"];
        $this->user = new User($this->userEmailAddress);
        $this->userToJoin = $result["user_to_join"];
        $this->phoneNumber = $result["phone_number"];
        $this->location = $result["location"];
        $this->state = $result["state"];
        $this->createdAt = $result["created_at"];
        $this->postedAt = $result["posted_at"];
        $this->updatedAt = $result["updated_at"];
        $this->views = $result["views"];
        $this->iconClass = $result["icon_class"];
        $this->tableName = self::TABLE_NAME;

        $this->featuredImgPath = Image::FEATURED_DIR_PATH . $this->slug . Image::EXTENSION;
        $this->featuredImgSrc = Image::FEATURED_DIR_URL . "/" . $this->slug . Image::EXTENSION;

        $this->productImgPath = Image::PRODUCT_DIR_PATH . $this->slug . Image::EXTENSION;
        $this->productImgSrc = Image::PRODUCT_DIR_URL . "/" . $this->slug . Image::EXTENSION;

        $this->productInfoImgPath = Image::PRODUCT_INFO_DIR_PATH . $this->slug . Image::EXTENSION;
        $this->productInfoImgSrc = Image::PRODUCT_INFO_DIR_URL . "/" . $this->slug . Image::EXTENSION;

        $this->artInFooterImgPath = Image::ART_IN_FOOTER_PATH . $this->slug . Image::EXTENSION;
        $this->artInFooterImgSrc = Image::ART_IN_FOOTER_URL . "/" . $this->slug . Image::EXTENSION;
    }

    /**
     * Retourne la catégorie de l'annonce.
     * 
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Retourne la sous-catégorie de l'annonce.
     * 
     * @return SubCategory
     */
    public function getSubCategory()
    {
        return $this->subCategory;
    }

    /**
     * Retourne l'utilisateur à qui appartient l'annonce.
     * 
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Retourne l'adresse email de l'utilisateur à joindre.
     * 
     * @return string|null
     */
    public function getUserToJoin()
    {
        return $this->userToJoin;
    }

    /**
     * Retourne l'addresse email de celui qui a posté l'annonce.
     * 
     * @return string
     */
    public function getUserEmailAddress()
    {
        return $this->userEmailAddress;
    }

    /**
     * Retourne le numéro de téléphone enregistré lors de la création de l'annonce.
     * 
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Retourne l'état de l'annonce.
     * 
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Retourne la date de post de l'annonce.
     * 
     * @return string
     */
    public function getPostedAt()
    {
        return Utility::formatDate($this->postedAt, "day", true);
    }

    /**
     * Retourne le nombre de vue de l'annonce.
     * 
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Retourne l'icon de l'annonce.
     * 
     * @return string
     */
    public function getIconClass()
    {
        return $this->iconClass;
    }

    /**
     * Retourne la source de l'image dans la carte de vedette de
     * format 600x400.
     * 
     * @return string
     */
    public function getFeaturedImgSrc()
    {
        return $this->featuredImgSrc;
    }

    /**
     * Retourne la source de l'image dans la carte product de format
     * 640x420.
     * 
     * @return string
     */
    public function getProductImgSrc()
    {
        return $this->productImgSrc;
    }
    
    /**
     * Retourne la source de l'image qui se trouve dans le dossier
     * product info de format 625x415.
     * 
     * @return string
     */
    public function getProductInfoImgSrc()
    {
        return $this->productInfoImgSrc;
    }

    /**
     * Retourne le lien de l'image dans le footer.
     * 
     * @return string
     */
    public function getArtInFooterImgSrc()
    {
        return $this->productInfoImgSrc;
    }

    /**
     * Retourne la location de l'annonce.
     * 
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Retourne le lien de l'annonce.
     * 
     * @return string
     */
    public function getLink()
    {
        return $this->category->getSlug() . "/" . $this->getSlug();
    }

    /**
     * Retourne le prix.
     * 
     * @return string
     */
    public function getPrice()
    {
        if ($this->price == 0) {
            return "Gratuit";
        } elseif ($this->price == "price_on_call") {
            return "Me contacter pour le prix";
        } else {
            return $this->price . " XOF";
        }
    }

    /**
     * Permet de vérifier si c'est une annonce vedette.
     * @return bool
     */
    public function isFeatured() : bool
    {
        return true;
    }

    /**
     * Permet de vérifier si c'est une annonce en attente de validation.
     * @return bool
     */
    public function isPending() : bool
    {
        return true;
    }

    /**
     * Permet de vérifier si c'est une annonce validée.
     * @return bool
     */
    public function isValidated() : bool
    {
        return true;
    }

    /**
     * Permet de vérifier si c'est une annonce suspendue|bloquée.
     * @return bool
     */
    public function isSuspended() : bool
    {
        return true;
    }

    /**
     * Retourne un certain nombre d'annonces en fonction des paramètres
     * passés à la méthode.
     * 
     * @param int $idCategory    Pour spécifier qu'on veut des annonces appartenant
     *                           à une catégorie précise.
     * @param int $idSubCategory Pour spécifier qu'on veut des annonces appartenant à
     *                           une sous-catégorie précise.
     * @param int $nbr           Pour spécifier qu'on veut un nombre d'annonces précis.
     */
    public static function getAll($idCategory = null, $idSubCategory = null, $nbr = null)
    {
        // Format de la requête à la base.
        $query = "SELECT id FROM " . self::TABLE_NAME;

        // Si on passe une catégorie précise et une sous-catégorie précise.
        if (null !== $idCategory && null !== $idSubCategory) {

            $query .= " WHERE id_category = ? AND id_sub_category = ?";

            // Si on spécifie un nombre d'annonces précis
            if (null !== $nbr) {
                $query .= " LIMIT 0, $nbr";
            }

            $rep = parent::connect()->prepare($query);
            $rep->execute([$idCategory, $idSubCategory]);

        } elseif (null !== $idCategory && null == $idSubCategory) { // Si on spécifie que la catégorie

            $query .= " WHERE id_category = ?";

            // Si on spécifie un nombre d'annonces précis
            if (null !== $nbr) {
                $query .= " LIMIT 0, $nbr";
            }

            $rep = parent::connect()->prepare($query);
            $rep->execute([$idCategory]);

        } elseif (null == $idCategory && null !== $idSubCategory) { // Si on spécifie que la sous-catégorie

            $query .= " WHERE id_sub_category = ?";

            // Si on spécifie un nombre d'annonces précis
            if (null !== $nbr) {
                $query .= " LIMIT 0, $nbr";
            }

            $rep = parent::connect()->prepare($query);
            $rep->execute([$idSubCategory]);

        } else {

            // Si on spécifie un nombre d'annonces précis
            if (null !== $nbr) {
                $query .= " LIMIT 0, $nbr";
            }

            $rep = parent::connect()->query($query);
        }

        $result = $rep->fetchAll();

        $announces = [];
        foreach($result as $announce) {
            $announces[] = new self($announce["id"]);
        }

        return $announces;
    }

    /**
     * Retourne les annonces par orde de création, de la plus récente à la plus
     * ancienne.
     * 
     * @param int $nbr Pour spécifier si on veut un nombre d'annonces précis.
     * 
     * @return array
     */
    public static function getLastPosted(int $nbr = null) : array
    {
        $query = "SELECT id FROM " . self::TABLE_NAME . " ORDER BY created_at DESC";

        if (null !== $nbr) {
            $query .= " LIMIT 0, 5";
        }

        $rep = parent::connect()->prepare($query);
        $result = $rep->fetchAll();

        $announces = [];

        foreach($result as $announce) {
            $announces[] = new self($announce["id"]);
        }

        return $announces;
    }

    /**
     * Retourne les annonces les plus vues.
     * 
     * @param int $nbr Pour spécifier si on veut un nombre d'annonces précis.
     * 
     * @return array
     */
    public static function getMoreViewed(int $nbr = null) : array
    {
        $query = "SELECT id FROM " . self::TABLE_NAME . " ORDER BY views DESC";

        if (null !== $nbr) {
            $query .= " LIMIT 0, 5";
        }

        $rep = parent::connect()->prepare($query);
        $result = $rep->fetchAll();

        $announces = [];

        foreach($result as $announce) {
            $announces[] = new self($announce["id"]);
        }

        return $announces;
    }

    /**
     * Permet de créer une nouvelle ligne d'annonce et d'enregistrer les données.
     */
    public static function create() : bool
    {
        $image = new Image();
        $data["title"] = htmlspecialchars($_POST["title"]);
        $data["description"] = htmlspecialchars($_POST["description"]);
        $data["id_category"] = htmlspecialchars($_POST["id_category"]);
        $data["location"] = htmlspecialchars($_POST["location"]);

        //=== Fonctionnalité rétirée pour le moment ====/
        // $data["id_sub_category"] = htmlspecialchars($_POST["id_sub_category"]);

        //=== Si l'user veut qu'on l'appelle pour le prix ======================/
        if (isset($_POST["price_on_call"]) && $_POST["price_on_call"] == "on" && empty($_POST["price"])) {
            $data["price"] = htmlspecialchars($_POST["price_on_call"]);
        } else {
            $data["price"] = htmlspecialchars($_POST["price"]);
        }

        // Enregistrement de l'utilisateur qui a sa session active
        // $data["user_email_address"] = htmlspecialchars(Session::getSessionId());
        $data["user_email_address"] = "tanohbassapatrick@gmail.com";

        //=== Si user à choisi un autre utilisateur à contacter =================/
        if (isset($_POST["usertype"]) && $_POST["usertype"] === "someone_else") {
            $data["user_to_join"] = $_POST["user_to_join"];
            $data["phone_number"] = $_POST["phone_number"];
        }

        // Insertion des données
        $insertion = new InsertData($data, self::TABLE_NAME);
        $insertion->run();

        /** Récupérer l'annonce qui vient d'être enregistrée */
        $currentAnnounce = new self($insertion->getPDO()->lastInsertId());

        // Enregistrement du slug et insertion dans la db
        $slug = Utility::slugify($_POST["title"]) . "-" . $currentAnnounce->getId();
        $currentAnnounce->set("slug", $slug);

        /** Récupérer l'annonce qui vient d'être enregistrée */
        $currentAnnounce = new self($insertion->getPDO()->lastInsertId());

        // S'il y'a des images
        if (Create::fileIsUploaded("images")) {

            // Formater le nom de l'image
            $imgName = $currentAnnounce->getSlug();

            // Format featured 600 x 400
            $image->save($_FILES['images']['tmp_name'][0], $imgName, Image::FEATURED_DIR_PATH, 600, 400);

            // Product 640 x 420
            $image->save($_FILES['images']['tmp_name'][0], $imgName, Image::PRODUCT_DIR_PATH, 640, 420);

            // Art in Footer 240 x 200
            $image->save($_FILES['images']['tmp_name'][0], $imgName, Image::ART_IN_FOOTER_PATH, 240, 200);

            // ProductInfo 625x415
            $arrayLength = count($_FILES["images"]["tmp_name"]);
            for ($i = 0; $i < $arrayLength; $i++) {
                $image->save($_FILES['images']['tmp_name'][$i], $imgName."-".$i, Image::PRODUCT_INFO_DIR_PATH, 625, 415);
            }
        }
        
        return true;
    }

    /**
     * Retourne les annonces validées.
     * 
     * @return array
     */
    public static function getValidated($idCategory) : array
    {
        $query = "SELECT id FROM ". self::TABLE_NAME . " WHERE state = 1 AND id_category = ?";
        $rep = parent::connect()->prepare($query);
        $rep->execute([$idCategory]);

        $result = $rep->fetchAll();

        $announces = [];

        foreach($result as $announce) {
            $announces[] = new self($announce["id"]);
        }

        return $announces;
    }

    /**
     * Retourne les annonces en pending.
     * 
     * @return array
     */
    public static function getPending() : array
    {
        $query = "SELECT id FROM ". self::TABLE_NAME . " WHERE state = 0";
        $rep = parent::connect()->query($query);

        $result = $rep->fetchAll();

        $announces = [];

        foreach($result as $announce) {
            $announces[] = new self($announce["id"]);
        }

        return $announces;
    }

    /**
     * Retourne les annonces suspendue.
     * 
     * @return array
     */
    public static function getSuspended() : array
    {
        $query = "SELECT id FROM ". self::TABLE_NAME . " WHERE state = 2";
        $rep = parent::connect()->query($query);

        $result = $rep->fetchAll();

        $announces = [];

        foreach($result as $announce) {
            $announces[] = new self($announce["id"]);
        }

        return $announces;
    }

    /**
     * Retourne les annonces vedettes.
     * 
     * @return array
     */
    public static function getFeatured(int $nbr)
    {
        return self::getMoreViewed($nbr);
    }

}