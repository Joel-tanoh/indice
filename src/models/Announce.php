<?php

namespace App\Models;

use App\Database\SqlQueryFormater;
use App\Utilities\Utility;

/**
 * Classe de gestion d'une annonce.
 */
class Announce extends Model
{
    private $slug;
    private $category;
    private $subCategory;
    private $user;
    private $phoneNumber;
    private $state;
    private $postedAt;
    private $views;
    const TABLE_NAME = "announces";

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

}