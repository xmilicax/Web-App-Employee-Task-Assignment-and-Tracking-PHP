<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/Database.php';

class Fajl
{
    public int $id;
    public string $naziv;
    public string $putanja;
    public int $velicina;
    public string $tip;

    public static function sacuvaj_fajl(string $putanja, string $naziv, int $velicina, string $tip): int
    {
        $db = Database::getInstance();

        $query = 'INSERT INTO fajlovi (naziv, putanja, velicina, tip) '
            . 'VALUES (:naziv, :putanja, :velicina, :tip)';

        $params = [
            ':putanja' => $putanja,
            ':naziv' => $naziv,
            ':velicina' => $velicina,
            ':tip' => $tip
        ];

        $db->insert(Fajl::class, $query, $params);

        return $db->lastInsertId();
    }

}