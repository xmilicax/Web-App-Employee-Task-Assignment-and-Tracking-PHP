<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/Database.php';

class Korisnik
{
    public $id;
    public $username;
    public $password;
    public $email;
    public $ime_prezime;
    public $id_tip_korisnika;
    public $broj_telefona;
    public $datum_rodjenja;


    public static function registracija(
        $username,
        $password,
        $email,
        $ime_prezime,
        $id_tip_korisnika,
        $broj_telefona,
        $datum_rodjenja,
        $token
    ) {
        $database = Database::getInstance();
        $database->insert(
            'Korisnik', 'INSERT INTO korisnici (username, password, email, ime_prezime, id_tip_korisnika, broj_telefona, datum_rodjenja, token) 
                        VALUES (:username, :password, :email, :ime_prezime, :id_tip_korisnika, :broj_telefona,  :datum_rodjenja, :token)',
            [
                ':username' => $username,
                ':password' => $password,
                ':email' => $email,
                ':ime_prezime' => $ime_prezime,
                ':id_tip_korisnika' => $id_tip_korisnika,
                ':broj_telefona' => $broj_telefona,
                ':datum_rodjenja' => $datum_rodjenja,
                ':token' => $token
            ]
        );
        return $database->lastInsertId();
    }

    public static function prijava($email, $password)
    {
        $password = hash('sha512', $password);

        $database = Database::getInstance();

        $query = 'SELECT * FROM korisnici WHERE email = :email AND password = :password';
        $params = [
            ':email' => $email,
            ':password' => $password
        ];

        $korisnici = $database->select('Korisnik', $query, $params);

        foreach ($korisnici as $korisnik) {
            return $korisnik;
        }

        return null;
    }

    public static function provera_username($username) {
        $database = Database::getInstance();
        $korisnici = $database->select(
            'Korisnik',
            'SELECT * FROM korisnici WHERE username = :username',
            [
                ':username' => $username
            ]
        );

        return !empty($korisnici);
    }

    public static function provera_email($email) {
        $database = Database::getInstance();
        $korisnici = $database->select(
            'Korisnik',
            'SELECT * FROM korisnici WHERE email = :email',
            [
                ':email' => $email
            ]
        );

        return !empty($korisnici);
    }

    public static function verifikacija($token)
    {
        $database = Database::getInstance();

        $database->update(
            'Korisnik',
            'UPDATE korisnici SET status = :status WHERE token = :token',
            [
                ':token' => $token,
                ':status' => "Verifikovan"
            ]
        );
    }

    public static function vrati_token($email)
    {
        $database = Database::getInstance();
        $korisnik = $database->select(
            'Korisnik',
            'SELECT token FROM korisnici WHERE email = :email',
            [
                ':email' => $email
            ]
        );

        //var_dump($korisnik);

        if (!empty($korisnik) && isset($korisnik[0])) {
            return $korisnik[0]->token;
        } else {
            return null;
        }
    }

    public static function vrati_token_pass($email)
    {
        $database = Database::getInstance();
        $token_pass = bin2hex(random_bytes(32));
        $token_pass_vreme = date('Y-m-d H:i:s');

        $database->update(
            'Korisnik',
            'UPDATE korisnici SET token_pass = :token_pass, token_pass_vreme = :token_pass_vreme WHERE email = :email',
            [
                ':token_pass' => $token_pass,
                ':token_pass_vreme' => $token_pass_vreme,
                ':email' => $email
            ]
        );

        return $token_pass;
    }

    public static function proveri_token_pass($token_pass)
    {
        $database = Database::getInstance();
        $vreme = $database->select(
            'Korisnik',
            'SELECT token_pass_vreme FROM korisnici WHERE token_pass = :token_pass',
            [
                ':token_pass' => $token_pass
            ]
        );

        if (!empty($vreme)) {
            $token_pass_vreme = new DateTime($vreme[0]->token_pass_vreme);
            $now = new DateTime();
            $interval = $now->diff($token_pass_vreme);

            // 30 min provera
            if ($interval->i < 30 && $interval->h == 0 && $interval->d == 0) {
                return true;
            }
            // 1 min provera (radi testiranja)
            /*
             if ($interval->i < 1 && $interval->h == 0 && $interval->d == 0) {
                return true;
            }
            */
        }

        return false;
    }

    public static function vrati_email_pass($token_pass)
    {
        $database = Database::getInstance();
        $korisnik = $database->select(
            'Korisnik',
            'SELECT email FROM korisnici WHERE token_pass = :token_pass',
            [
                ':token_pass' => $token_pass
            ]
        );

        if (!empty($korisnik) && isset($korisnik[0])) {
            return $korisnik[0]->email;
        } else {
            return null;
        }
    }


    public static function izmena_lozinke($email, $new_password)
    {
        $new_password = hash('sha512', $new_password);
        $database = Database::getInstance();

        $database->update(
            'Korisnik',
            'UPDATE korisnici SET password = :new_password WHERE email = :email',
            [
                ':new_password' => $new_password,
                ':email' => $email
            ]
        );
    }

    public static function dodaj_grupu_zadataka($naziv)
    {
        $database = Database::getInstance();
        $database->insert(
            'grupe_zadataka',
            'INSERT INTO grupe_zadataka (naziv) VALUES (:naziv)',
            [
                ':naziv' => $naziv,
            ]
        );
        return $database->lastInsertId();
    }

    public static function izmeni_grupu_zadataka($id, $naziv)
    {
        $database = Database::getInstance();

        $promena = $database->selectQuery(
            'SELECT id FROM grupe_zadataka WHERE id=:id',
            [
                ':id' => $id
            ]
        );

        $database->update(
            'Korisnik',
            'UPDATE grupe_zadataka SET naziv = :naziv WHERE id = :id',
            [
                ':naziv' => $naziv,
                ':id' => $id
            ]
        );

        return $database->lastInsertId();
    }

    public static function izbrisi_grupu_zadataka($id)
    {
        $database = Database::getInstance();
        $promena = $database->selectQuery('SELECT id FROM grupe_zadataka WHERE id = :id', [
            ':id' => $id
        ]);
        if ($promena === null) {
            throw new Exception("Uneli ste pogrešan ID grupe zadataka.");
        }

        $database->delete(
            'DELETE FROM grupe_zadataka WHERE id = :id',
            [
                ':id' => $id
            ]
        );
    }

    public static function vrati_tip_korisnika($id_tip_korisnika)
    {
        $database = Database::getInstance();
        $tipovi_korisnika = $database->select(
            'Korisnik',
            'SELECT * FROM tipovi_korisnika WHERE id = :id',
            [
                ':id' => $id_tip_korisnika
            ]
        );

        if (!empty($tipovi_korisnika)) {
            return $tipovi_korisnika[0];

        } else {
            return null;
        }
    }

    public static function vrati_tip_korisnika2($id_tip_korisnika)
    {
        $database = Database::getInstance();
        $tipovi_korisnika = $database->select(
            'Korisnik',
            'SELECT * FROM tipovi_korisnika WHERE id = :id',
            [
                ':id' => $id_tip_korisnika
            ]
        );

        if (!empty($tipovi_korisnika)) {
            return $tipovi_korisnika[0]->naziv;

        } else {
            return null;
        }
    }

    public static function vrati_tipove_korisnika()
    {
        $database = Database::getInstance();
        return $database->select(
            'Korisnik',
            'SELECT * FROM tipovi_korisnika'
        );
    }

    public static function vrati_korisnik_id($id)
    {
        $database = Database::getInstance();

        $korisnici = $database->select(
            'Korisnik',
            'SELECT * FROM korisnici WHERE id = :id',
            [
                ':id' => $id
            ]
        );

        foreach ($korisnici as $korisnik) {
            return $korisnik;
        }

        return null;
    }

    public static function vrati_ime_korisnika($id)
    {
        $database = Database::getInstance();

        $korisnici = $database->select(
            'Korisnik',
            'SELECT id, ime_prezime FROM korisnici WHERE id = :id',
            [
                ':id' => $id
            ]
        );

        foreach ($korisnici as $korisnik) {
            return $korisnik->ime_prezime;
        }

        return null;
    }

    public static function vrati_ime_vise_korisnika($id_lista)
    {
        $ids = array_map('intval', explode(',', $id_lista));

        // Fetch names using the existing function for each ID
        $imena = [];
        foreach ($ids as $id) {
            $ime = self::vrati_ime_korisnika($id);
            if ($ime !== null) {
                $imena[$id] = $ime;
            }
        }

        return $imena;
    }

    public static function izmeni_tip_korisnika($id, $naziv)
    {
        $database = Database::getInstance();

        $stari_tip = $database->select(
            'Korisnik',
            'SELECT * FROM tipovi_korisnika WHERE id = :id',
            [
                ':id' => $id
            ]
        );

        if (empty($stari_tip)) {
            throw new Exception('Traženi tip korisnika nije pronađen.');
        }

        $database->update(
            'Korisnik',
            'UPDATE tipovi_korisnika SET naziv = :naziv WHERE id = :id',
            [
                ':id' => $id,
                ':naziv' => $naziv,
            ]
        );
    }

    public static function izmeni_korisnika(
        $id,
        $username,
        $password,
        $email,
        $ime_prezime,
        $id_tip_korisnika,
        $broj_telefona,
        $datum_rodjenja,
        $status
    ) {
        $database = Database::getInstance();

        $stari_korisnik = $database->select(
            'Korisnik',
            'SELECT * FROM korisnici WHERE id = :id',
            [
                ':id' => $id
            ]
        );

        if (!$stari_korisnik) {
            throw new Exception('Traženi korisnik nije pronađen.');
        }

        $database->update(
            'Korisnik',
            'UPDATE korisnici SET username = :username, password = :password, email = :email, 
                     ime_prezime = :ime_prezime, id_tip_korisnika = :id_tip_korisnika, broj_telefona = :broj_telefona,  
                     datum_rodjenja = :datum_rodjenja, status = :status WHERE id = :id',
            [
                ':id' => $id,
                ':username' => $username,
                ':password' => $password,
                ':email' => $email,
                ':ime_prezime' => $ime_prezime,
                ':id_tip_korisnika' => $id_tip_korisnika,
                ':broj_telefona' => $broj_telefona,
                ':datum_rodjenja' => $datum_rodjenja,
                ':status' => $status
            ]
        );

        return $database->lastInsertId();
    }

    public static function svi_korisnici(): array
    {
        $database = Database::getInstance();

        $korisnici = $database->select(
            'Korisnik',
            'SELECT * FROM korisnici'
        );

        return $korisnici;
    }

    public static function napravi_tip_korisnika($naziv)
    {
        $database = Database::getInstance();
        $database->insert(
            'Korisnik',
            'INSERT INTO tipovi_korisnika (naziv) VALUES (:naziv)',
            [
                ':naziv' => $naziv,
            ]
        );
        return $database->lastInsertId();
    }

    public static function registracija_admin(
        $username,
        $password,
        $email,
        $ime_prezime,
        $id_tip_korisnika,
        $broj_telefona,
        $datum_rodjenja,
        $status
    ) {
        $database = Database::getInstance();
        $database->insert(
            'Korisnik', 'INSERT INTO korisnici (username, password, email, ime_prezime, id_tip_korisnika, broj_telefona, datum_rodjenja, status) 
                        VALUES (:username, :password, :email, :ime_prezime, :id_tip_korisnika, :broj_telefona,  :datum_rodjenja, :status)',
            [
                ':username' => $username,
                ':password' => $password,
                ':email' => $email,
                ':ime_prezime' => $ime_prezime,
                ':id_tip_korisnika' => $id_tip_korisnika,
                ':broj_telefona' => $broj_telefona,
                ':datum_rodjenja' => $datum_rodjenja,
                ':status' => $status
            ]
        );
        return $database->lastInsertId();
    }

}
