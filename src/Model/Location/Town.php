<?php

namespace App\Model\Location;

/** Classe de gestion de pays. */
class Town extends Location
{
    /** @var string Le nom de la table */
    const TABLE_NAME = "towns";

    /** @var App\Model\Location\Country Le pays dans lequel se trouve la ville. */
    private $country;

    /**
     * Constructeur d'une ville.
     * 
     * @param int $id
     */
    public function __construct(int $id)
    {
        $req = parent::connectToDb()->prepare("SELECT id, name, id_country FROM " . self::TABLE_NAME . " WHERE id = :id");
        $req->execute([
            "id" => $id
        ]);
        $result = $req->fetch();

        $this->id = $result["id"];
        $this->name = $result["name"];
        $this->country = new Country($result["id_country"]);
        $this->tableName = self::TABLE_NAME;
    }

    /**
     * Retourne le pays de cette ville.
     * @return App\Model\Location\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

}