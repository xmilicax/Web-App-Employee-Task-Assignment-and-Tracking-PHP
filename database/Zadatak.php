<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/../includes/Factory.php';
require_once __DIR__ . '/Korisnik.php';



class Zadatak
{
    public $id;
    public $naslov;
    public $opis;
    public $lista_izvrsioca;
    public $rukovodilac;
    public $rok_izvrsenja;
    public $prioritet;
    public $id_grupe;
    public $fajl;
    public $status;

    public static function napravi_zadatak($naslov, $opis, $lista_izvrsioca, $rukovodilac, $rok_izvrsenja, $prioritet, $id_grupe, $fajl)
    {
        $database = Database::getInstance();
        $lista_izvrsioca = implode(',', $lista_izvrsioca);

        $database->insert(
            'Zadatak',
            'INSERT INTO zadaci (naslov, opis, lista_izvrsioca, rukovodilac, rok_izvrsenja, prioritet, id_grupe, fajl) 
        VALUES (:naslov, :opis, :lista_izvrsioca, :rukovodilac, :rok_izvrsenja, :prioritet, :id_grupe, :fajl)',
            [
                ':naslov' => $naslov,
                ':opis' => $opis,
                ':lista_izvrsioca' => $lista_izvrsioca,
                ':rukovodilac' => $rukovodilac,
                ':rok_izvrsenja' => $rok_izvrsenja,
                ':prioritet' => $prioritet,
                ':id_grupe' => $id_grupe,
                ':fajl' => $fajl
            ]
        );

        $id_zadatka = $database->lastInsertId();

        return $id_zadatka;
    }


    public static function vrati_rukovodioce()
    {
        $database = Database::getInstance();

        $rukovodioci = $database->select(
            'Korisnik',
            'SELECT id, username FROM korisnici WHERE id_tip_korisnika = 2'
        );

        return $rukovodioci;
    }

    public static function vrati_izvrsioce()
    {
        $database = Database::getInstance();

        $izvrsioci = $database->select(
            'Korisnik',
            'SELECT id, username FROM korisnici WHERE id_tip_korisnika = 3'
        );

        return $izvrsioci;
    }

    public static function vrati_grupe_zadataka()
    {
        $database = Database::getInstance();

        $grupe_zadataka = $database->select(
            'Zadatak',
            'SELECT * FROM grupe_zadataka'
        );

        return $grupe_zadataka;
    }

    public static function vrati_naziv_grupe_zadataka($id)
    {
        $database = Database::getInstance();

        $naziv = $database->select(
            'Grupa',
            'SELECT naziv FROM grupe_zadataka WHERE id = :id',
            [
                ':id' => $id
            ]
        );

        if (!empty($naziv)) {
            return $naziv[0] -> naziv;
        }

        return null;
    }

    public static function vrati_naslov($id)
    {
        $database = Database::getInstance();

        $naslov = $database->select(
            'Zadatak',
            'SELECT naslov FROM zadaci WHERE id = :id',
            [
                ':id' => $id
            ]
        );

        return $naslov[0] -> naslov;
    }
    public static function izmeni_zadatak(
        $id,
        $naslov,
        $opis,
        $lista_izvrsioca,
        $rukovodilac,
        $rok_izvrsenja,
        $prioritet,
        $id_grupe,
        $fajl
    ) {
        $database = Database::getInstance();

        $stari_zadatak = $database->select(
            'Zadatak',
            'SELECT id FROM zadaci WHERE id = :id',
            [
                ':id' => $id
            ]
        );

        if (empty($stari_zadatak)) {
            throw new Exception('Traženi zadatak nije pronađen.');
        }

        // pretvaranje iz niza u string
        $lista_izvrsioca = implode(',', $lista_izvrsioca);

        $database->update(
            'Zadatak',
            'UPDATE zadaci SET naslov = :naslov, opis = :opis, lista_izvrsioca = :lista_izvrsioca, 
                  rukovodilac = :rukovodilac, rok_izvrsenja = :rok_izvrsenja, prioritet = :prioritet, 
                  id_grupe = :id_grupe, fajl = :fajl WHERE id = :id',
            [
                ':id' => $id,
                ':naslov' => $naslov,
                ':opis' => $opis,
                ':lista_izvrsioca' => $lista_izvrsioca,
                ':rukovodilac' => $rukovodilac,
                ':rok_izvrsenja' => $rok_izvrsenja,
                ':prioritet' => $prioritet,
                ':id_grupe' => $id_grupe,
                ':fajl' => $fajl
            ]
        );

        return true;
    }

    public static function vrati_zadatak($id)
    {
        $database = Database::getInstance();

        $zadatak = $database->select(
            'Zadatak',
            'SELECT * FROM zadaci WHERE id = :id',
            [
                ':id' => $id
            ]
        );

        return $zadatak[0];
    }

    public static function vrati_zadatke()
    {
        $database = Database::getInstance();

        $zadatak = $database->select(
            'Zadatak',
            'SELECT id, naslov FROM zadaci'
        );

        return $zadatak;
    }

    public function korisnik()
    {
        return Korisnik::vrati_korisnik_id($this->id_korisnika);
    }

    public function grupa()
    {
        return Grupa::vrati_ime_grupe($this->id_grupe);
    }

    public static function izbrisi_zadatak($id)
    {
        $database = Database::getInstance();
        $promena = $database->selectQuery('SELECT id FROM zadaci WHERE id = :id', [
            ':id' => $id
        ]);
        if ($promena === null) {
            throw new Exception("Uneli ste pogrešan ID zadatka. Pokušajte ponovo.");
        }

        $database->delete(
            'DELETE FROM zadaci WHERE id = :id',
            [
                ':id' => $id
            ]
        );
    }

    public static function zavrsi_zadatak($id)
    {
        $database = Database::getInstance();
        $postojeci_zadatak = $database->select(
            'Zadatak',
            'SELECT id FROM zadaci WHERE id=:id',
            [
                ':id' => $id
            ]
        );

        if (empty($postojeci_zadatak)) {
            return false;
        }

        $database->update(
            'Zadatak',
            'UPDATE zadaci SET status = "završen" WHERE id = :id',
            [
                ':id' => $id
            ]
        );

        return true;
    }

    public static function otkazi_zadatak($id)
    {
        $database = Database::getInstance();
        $postojeci_zadatak = $database->select(
            'Zadatak', 'SELECT id FROM zadaci WHERE id=:id',
            [':id' => $id]
        );

        if (empty($postojeci_zadatak)) {
            return false;
        }

        $database->update(
            'Zadatak',
            'UPDATE zadaci SET status = "otkazan" WHERE id = :id',
            [
                ':id' => $id
            ]
        );

        return true;
    }

    public static function vrati_komentar_zadatak($id_zadatka)
    {
        $database = Database::getInstance();

        $rezultat = $database->select('Zadatak', 'SELECT * FROM komentari WHERE id_zadatka = :id_zadatka', [
            ':id_zadatka' => $id_zadatka
        ]);

        return $rezultat;
    }


    public static function filtriraj_po_datumu($datum)
    {
        $database = Database::getInstance();
        $zadaci = $database->select(
            'Zadatak',
            'SELECT id, naslov, opis, lista_izvrsioca, rukovodilac, rok_izvrsenja, prioritet, id_grupe, fajl, status FROM zadaci WHERE DATE(rok_izvrsenja) = :datum',
            [
                ':datum' => $datum
            ]
        );

        return $zadaci;
    }

    public static function filtriraj_po_izvrsiocima($id_izvrsioca)
    {
        $database = Database::getInstance();
        $zadaci = [];
        try {
            $zadaci = $database->select(
                'Zadatak',
                'SELECT id, naslov, opis, lista_izvrsioca, rukovodilac, rok_izvrsenja, prioritet, id_grupe, fajl, status FROM zadaci WHERE FIND_IN_SET(:id, lista_izvrsioca)',
                [
                    ':id' => $id_izvrsioca
                ]
            );
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        return $zadaci;
    }


    public static function filtriraj_po_rukovodiocima($rukovodioci)
    {
        $database = Database::getInstance();
        $zadaci = $database->select(
            'Zadatak',
            'SELECT id, naslov, opis, lista_izvrsioca, rukovodilac, rok_izvrsenja, prioritet, id_grupe, fajl, status FROM zadaci WHERE rukovodilac LIKE :rukovodioci',
            [
                ':rukovodioci' => '%' . $rukovodioci . '%'
            ]
        );

        return $zadaci;
    }

    public static function filtriraj_po_datumu_izvrsilac($id, $datum)
    {
        $database = Database::getInstance();
        $zadaci = $database->select(
            'Zadatak',
            'SELECT id, naslov, opis, lista_izvrsioca, rukovodilac, rok_izvrsenja, prioritet, id_grupe, fajl, status 
            FROM zadaci 
            WHERE DATE(rok_izvrsenja) = :datum AND FIND_IN_SET(:id, lista_izvrsioca)',
            [
                ':datum' => $datum,
                ':id' => $id
            ]
        );

        return $zadaci;
    }

    public static function filtriraj_po_izvrsiocima_izvrsilac($id, $id_izvrsioca)
    {
        $database = Database::getInstance();
        $zadaci = [];
        try {
            $zadaci = $database->select(
                'Zadatak',
                'SELECT id, naslov, opis, lista_izvrsioca, rukovodilac, rok_izvrsenja, prioritet, id_grupe, fajl, status 
                FROM zadaci 
                WHERE FIND_IN_SET(:id, lista_izvrsioca) AND FIND_IN_SET(:id_izvrsioca, lista_izvrsioca)',
                [
                    ':id_izvrsioca' => $id_izvrsioca,
                    ':id' => $id
                ]
            );
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        return $zadaci;
    }


    public static function filtriraj_po_rukovodiocima_izvrsilac($id, $rukovodioci)
    {
        $database = Database::getInstance();
        $zadaci = $database->select(
            'Zadatak',
            'SELECT id, naslov, opis, lista_izvrsioca, rukovodilac, rok_izvrsenja, prioritet, id_grupe, fajl, status 
                FROM zadaci 
                WHERE rukovodilac LIKE :rukovodioci AND FIND_IN_SET(:id, lista_izvrsioca)',
            [
                ':rukovodioci' => '%' . $rukovodioci . '%',
                ':id' => $id
            ]
        );

        return $zadaci;
    }

}