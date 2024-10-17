<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/Database.php';

class Grupa
{
    public int $id;
    public string $naziv;

    public static function vrati_ime_grupe($id)
    {
        $database = Database::getInstance();

        $grupe = $database->select(
            'Grupa',
            'SELECT * FROM grupe_zadataka WHERE id = :id',
            [
                ':id' => $id
            ]
        );

        foreach ($grupe as $grupa) {
            return $grupa;
        }

        return null;
    }

}