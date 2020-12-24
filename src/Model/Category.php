<?php

namespace App\Model;

use App\Database\SqlQueryFormater;

/**
 * Classe de gestion des catégories.
 */
class Category extends Model
{
    protected $announces = [];
    private $subCategories = [];
    private $iconClass;
    const TABLE_NAME = "ind_categories";

    /**
     * Constructeur d'une catégorie.
     * 
     * @param int $id
     */
    public function __construct(int $id)
    {
        $queryFormatter = new SqlQueryFormater();

        $query = $queryFormatter->select(
            "id, title, slug, created_at, updated_at, description, icon_class"
            )->from(self::TABLE_NAME)->where("id = ?")->returnQueryString();

        $rep = parent::connect()->prepare($query);
        $rep->execute([$id]);

        $result = $rep->fetch();

        $this->id = $result["id"];
        $this->title = $result["title"];
        $this->slug = $result["slug"];
        $this->createdAt = $result["created_at"];
        $this->updatedAt = $result["updated_at"];
        $this->description = $result["description"];
        $this->iconClass = $result["icon_class"];
    }

    /**
     * Retourne les annonces postées qui appartiennent à cette catégorie.
     * 
     * @return array
     */
    public function getAnnounces()
    {
        $rep = parent::connect()->prepare("SELECT id FROM " . Announce::TABLE_NAME . " WHERE id_category = ?");
        $rep->execute([$this->id]);
        $result = $rep->fetchAll();

        foreach($result as $announce) {
            $this->announces[] = new Announce($announce["id"]);
        }

        return $this->announces;
    }

    /**
     * Retourne les sous-catégories de cette catégorie.
     * 
     * @return array
     */
    public function getSubCategories()
    {
        $rep = parent::connect()->prepare("SELECT id FROM " . SubCategory::TABLE_NAME . " WHERE id_category = ?");
        $rep->execute([$this->id]);
        $result = $rep->fetchAll();

        foreach($result as $subCategory) {
            $this->subCategories[] = new SubCategory($subCategory["id"]);
        }

        return $this->subCategories;
    }

    /**
     * Retourne la classe pour l'icône de l'élément courant.
     * 
     * @return string
     */
    public function getIconClass() : string
    {
        return $this->iconClass;
    }

    /**
     * Retourne toutes les catégories.
     * 
     * @param string $tableName Le nom de la table dont on veut récupérer tous
     *                          les éléments.
     * 
     * @return array
     */
    public static function getAll(string $tableName)
    {
        $query = "SELECT id FROM $tableName";
        $rep = self::connect()->query($query);
        return $rep->fetchAll();        
    }

    /**
     * Permet de vérifier si la variable passée en paramètre est un slug
     * de catégorie.
     * 
     * @param $var
     * 
     * @return bool
     */
    public static function isCategorySlug($var) : bool
    {
        return in_array($var, parent::getSlugs(self::TABLE_NAME));
    }

}