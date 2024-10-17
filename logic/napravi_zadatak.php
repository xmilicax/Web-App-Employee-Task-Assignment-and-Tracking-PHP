<?php

session_start();

require_once __DIR__ . '/../database/Korisnik.php';
require_once __DIR__ . '/../database/Zadatak.php';
require_once __DIR__ . '/../database/Grupa.php';
require_once __DIR__ . '/../database/Fajl.php';
require_once __DIR__ . '/../includes/Upload.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naslov = $_POST['naslov'];
    $opis = $_POST['opis'];
    $lista_izvrsioca = $_POST['lista_izvrsioca'];
    $rukovodilac = $_SESSION['korisnik_id'] ?? '';
    $rok_izvrsenja = $_POST['rok_izvrsenja'];
    $prioritet = $_POST['prioritet'];
    $id_grupe = $_POST['dropdown'];
    $fajl = $_FILES['fajl'];
    $naziv_fajla = $fajl['name'];

    if (empty($fajl)) {
        $fajl = null;
    } else {
        $upload = Upload::factory('files');
        $upload->file($fajl);
        $upload->set_allowed_mime_types(['image/jpeg', 'image/png', 'application/pdf', 'application/zip']);
        $upload->set_max_file_size(10); // in MB
        $upload->set_filename($naziv_fajla);
        $upload->check();
        $fajl = 'files/' . $naziv_fajla;
        $upload->upload();
    }

    try {
        Zadatak::napravi_zadatak($naslov, $opis, $lista_izvrsioca, $rukovodilac, $rok_izvrsenja, $prioritet, $id_grupe, $fajl);
        header('Location: ../pages/tipovi_korisnika/radnje_ruk_odlj/napravi_zadatak.php?status=uspesno');
        exit();
    } catch (Exception $e) {
        header('Location: ../pages/tipovi_korisnika/radnje_ruk_odlj/napravi_zadatak.php?status=greska');
        exit();
    }
}
