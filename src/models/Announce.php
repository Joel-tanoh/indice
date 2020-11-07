<?php

namespace App\Models;

use App\Files\Image;
use App\Database\SqlQueryFormater;
use App\Utilities\Utility;

/**
 * Classe de gestion d'une annonce.
 */
class Announce extends Model
{
    private $category;
    private $subCategory;
    private $user;
    private $phoneNumber;
    private $state;
    private $postedAt;
    private $views;
    const TABLE_NAME = "announces";
    const IMAGES_DIR_PATH = Image::IMAGES_DIR_PATH . DIRECTORY_SEPARATOR . "announces" . DIRECTORY_SEPARATOR;
    const IMAGES_DIR_URL = Image::IMAGES_DIR_URL . "/announces";
    const DEFAULT_THUMBS = Image::IMAGES_DIR_URL . "/defaul-thumbs" . Image::EXTENSION;

    /**
     * Constructeur de l'objet annonce.
     * 
     * @param int $id
     */
    public function __construct(int $id)
    {
        $queryFormatter = new SqlQueryFormater();

        $query = $queryFormatter->select(
            "id, slug, title, description, id_category, id_sub_category, id_user, phone_number,
             state, created_at, posted_at, modified_at, views"
            )->from(self::TABLE_NAME)->where("id = ?");

        $rep = parent::connect()->prepare($query);
        $rep->execute([$id]);

        $result = $rep->fetch();

        $this->id = $result["id"];
        $this->slug = $result["slug"];
        $this->title = $result["title"];
        $this->description = $result["description"];
        $this->idCategory = $result["id_category"];
        $this->idSubCategory = $result["id_sub_category"];
        $this->idUser = $result["id_user"];
        $this->phoneNumber = $result["phone_number"];
        $this->state = $result["state"];
        $this->createdAt = $result["created_at"];
        $this->postedAt = $result["posted_at"];
        $this->modifiedAt = $result["modified_at"];
        $this->views = $result["views"];
        $this->thumbsPath = self::IMAGES_DIR_PATH . $this->id . DIRECTORY_SEPARATOR . "thumbs" . Image::EXTENSION;
        $this->thumbsSrc = self::IMAGES_DIR_URL . "/" . $this->id . "/thumbs" . Image::EXTENSION;
    }

    /**
     * Retourne la catégorie de l'annonce.
     * 
     * @return Category
     */
    public function getCategory()
    {
        $this->category = new Category($this->idCategory);
        return $this->category;
    }

    /**
     * Retourne la sous-catégorie de l'annonce.
     * 
     * @return SubCategory
     */
    public function getSubCategory()
    {
        $this->subCategory = new SubCategory($this->idSubCategory);
        return $this->subCategory;
    }

    /**
     * Retourne l'utilisateur à qui appartient l'annonce.
     * 
     * @return User
     */
    public function getUser()
    {
        $this->user = new User($this->idUser);
        return $this->user;
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
        return Utility::formatDate($this->postedAt);
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
     * Permet d'instancier une annonce par son slug.
     * 
     * @param string $slug 
     * 
     * @return self
     */
    public static function getBySlug(string $slug) : self
    {
        $rep = parent::connect()->prepare("SELECT id FROM " . self::TABLE_NAME . " WHERE slug = ?");
        $rep->execute([$slug]);
        $res = $rep->fetch();
        return new self($res["id"]);
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
    public function getAll($idCategory = null, $idSubCategory = null, $nbr = null)
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
     * Retourne la source de la thumbs de l'annonce.
     * 
     * @return string
     */
    public function getThumbsSrc()
    {
        if (\file_exists($this->thumbsPath)) {
            return $this->thumbsSrc;
        } else {
            return self::DEFAULT_THUMBS;
        }
    }

}