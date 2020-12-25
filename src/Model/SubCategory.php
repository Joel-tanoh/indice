<?php

namespace App\Model;

use App\Database\SqlQueryFormater;

/**
 * Classe de gestion des sous-catégories.
 */
class SubCategory extends Category
{
    protected $category;
    const TABLE_NAME = "ind_sub_categories";

    /**
     * Constructeur d'une sous-catégorie.
     * 
     * @param int $id
     */
    public function __construct(int $id)
    {
        $queryFormatter = new SqlQueryFormater();

        $query = $queryFormatter->select(
            "id, title, slug, id_category, created_at, updated_at, description"
            )->from(self::TABLE_NAME)->where("id = ?")->returnQueryString();

        $rep = parent::connect()->prepare($query);
        $rep->execute([$id]);

        $result = $rep->fetch();

        $this->id = $result["id"];
        $this->title = $result["title"];
        $this->slug = $result["slug"];
        $this->idCategory = $result["id_category"];
        $this->createdAt = $result["created_at"];
        $this->updatedAt = $result["updated_at"];
        $this->description = $result["description"];
        $this->tableName = self::TABLE_NAME;
    }

    /**
     * Retourne les annonces postées qui appartiennent à cette catégorie.
     * 
     * @return array
     */
    public function getAnnounces()
    {
        $rep = parent::connect()->prepare("SELECT id FROM " . Announce::TABLE_NAME . " WHERE id_sub_category = ?");
        $rep->execute([$this->id]);
        $result = $rep->fetchAll();

        foreach($result as $announce) {
            $this->announces[] = new Announce($announce["id"]);
        }

        return $this->announces;
    }

    /**
     * Retourne la catégorie à laquelle appartient cette sous-catégorie.
     * 
     * @return \App\Model\Category
     */
    public function getCategory()
    {
        return new Category($this->idCategory);
    }
    
    /**
     * Permet de vérifier si la variable passée en paramètre est un slug
     * de catégorie.
     * 
     * @param $var
     * 
     * @return bool
     */
    static function isSubCategorySlug($var) : bool
    {
        return in_array($var, parent::getSlugs(self::TABLE_NAME));
    }

}