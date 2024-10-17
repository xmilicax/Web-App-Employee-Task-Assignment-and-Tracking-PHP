<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/Korisnik.php';
class Komentar
{
    public $id;
    public $id_zadatka;
    public $id_korisnika;
    public $sadrzaj;
    public $kreirano;

    public function korisnik()
    {
        return Korisnik::vrati_korisnik_id($this->id_korisnika);
    }

    public static function dodaj_komentar($id_zadatka, $id_korisnika, $sadrzaj) {
        try {
            $database = Database::getInstance();

            $kreirano = date('Y-m-d H:i');

            $query = 'INSERT INTO komentari (sadrzaj, id_korisnika, id_zadatka, kreirano) 
                  VALUES (:sadrzaj, :id_korisnika, :id_zadatka, :kreirano)';
            $params = [
                ':sadrzaj' => $sadrzaj,
                ':id_korisnika' => $id_korisnika,
                ':id_zadatka' => $id_zadatka,
                ':kreirano' => $kreirano
            ];

            $database->insert('Komentar', $query, $params);
            $poslednji_komentar = $database->lastInsertId();

            return (object)[
                'id' => $poslednji_komentar,
                'id_zadatka' => $id_zadatka,
                'id_korisnika' => $id_korisnika,
                'sadrzaj' => $sadrzaj,
                'kreirano' => $kreirano
            ];

        } catch (Exception $e) {
            throw new Exception("Error inserting comment: " . $e->getMessage());
        }
    }

    public static function izbrisi_komentar($id_komentara)
    {
        $database = Database::getInstance();

        $database->delete(
            'DELETE FROM komentari WHERE id = :id',
            [
                ':id' => $id_komentara
            ]
        );
        return true;
    }

    public static function vrati_komentare()
    {
        $database = Database::getInstance();

        return $database->select(
            'Komentar',
            'SELECT * FROM komentari'
        );

    }

    public static function izmeni_komentar($id_komentara, $sadrzaj)
    {
        $database = Database::getInstance();

        $komentar = $database->selectQuery(
            'SELECT id FROM komentari WHERE id = :id_komentara',
            [
                ':id_komentara' => $id_komentara
            ]
        );

        if (!$komentar) {
            throw new Exception("Uneli ste pogrešan ID komentara.");
        }

        $izmenjeno = date('Y-m-d H:i:s');

        $database->update('komentari',
            'UPDATE komentari 
            SET sadrzaj = :sadrzaj, izmenjeno = :izmenjeno 
            WHERE id = :id_komentara',
            [
                ':id_komentara' => $id_komentara,
                ':sadrzaj' => $sadrzaj,
                ':izmenjeno' => $izmenjeno
            ]
        );

        return $id_komentara;
    }

}