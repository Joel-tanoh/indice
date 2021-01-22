<?php

namespace App\Model\Location;

/** Classe de gestion de pays. */
class Country extends Location
{
    /** @var string Le nom de la table */
    const TABLE_NAME = "countries";

    /**
     * Constructeur d'un pays.
     * 
     * @param int $id
     */
    public function __construct(int $id)
    {
        $req = parent::connectToDb()->prepare("SELECT id, name FROM " . self::TABLE_NAME . " WHERE id = :id");
        $req->execute([
            "id" => $id
        ]);
        $result = $req->fetch();

        $this->id = $result["id"];
        $this->name = $result["name"];
        $this->tableName = self::TABLE_NAME;
    }

    /**
     * 
     */
}