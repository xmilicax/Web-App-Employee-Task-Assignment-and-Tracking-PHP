<?php

session_start();

// provera da li je korisnik ulogovan
if (!isset($_SESSION['username'])) {
    header('Location: ../../login.php?status=expired_session');
    exit();
}

if ($_SESSION['id_tip_korisnika'] != 2) {
    header('Location: ../../login.php?status=restricted_access');
    exit();
}

require_once __DIR__ . '/../../../database/Korisnik.php';
require_once __DIR__ . '/../../../database/Zadatak.php';
require_once __DIR__ . '/../../../database/Grupa.php';
require_once __DIR__ . '/../../../database/Komentar.php';

$id_zadatka = $_GET['id'];
if (isset($_GET['id'])) {
    $_SESSION['id_zadatka'] = $_GET['id'];
}
$zadatak = Zadatak::vrati_zadatak($id_zadatka);
$komentari = Zadatak::vrati_komentar_zadatak($id_zadatka);
$zadatak->komentari = $komentari;

$database = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadatak</title>
    <link rel="icon" href="../../../css/img/logo_krug.png">
    <link rel="stylesheet" href="../../../css/styles.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"
            integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
            crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#commentForm').submit(function(event) {
                event.preventDefault();
                const id_zadatka = <?= json_encode($id_zadatka) ?>;
                const sadrzaj = $('#newComment').val();

                $.ajax({
                    url: '../../../logic/dodaj_komentar.php',
                    method: 'POST',
                    data: { id_zadatka: id_zadatka, sadrzaj: sadrzaj },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.status === 'success') {
                            $('.komentari').append(`
                        <div class="komentar">
                            <p id="korisnik">${response.korisnik}</p>
                            <p id="datum">${response.kreirano}</p>
                            <p id="komentar">${response.sadrzaj}</p>
                            <button class="brisi" onclick="deleteComment(${response.id})">Obriši</button>
                            <div class="divider"></div>
                        </div>
                    `);
                            // očisti polje
                            $('#newComment').val('');
                        } else {
                            console.log(response);
                            alert('Došlo je do greške prilikom dodavanja komentara: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Došlo je do greške prilikom dodavanja komentara.');
                    }
                });
            });
        });

        function deleteComment(kom) {
            $.ajax({
                url: '../../../logic/izbrisi_komentar.php',
                method: 'POST',
                data: { id_komentara: kom },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status === 'success') {
                        location.reload();
                    } else {
                        alert('Došlo je do greške prilikom brisanja komentara: ' + response.message);
                    }
                },
                error: function() {
                    alert('Došlo je do greške prilikom brisanja komentara.');
                }
            });
        }
    </script>
</head>
<body>
<header class="header1">
    <a href="../rukovodilac_odeljenja.php" class="ikonica"><i class="fas fa-home"></i></a>
    <h1>Zadatak</h1>
    <a href="../../../logic/logout.php" class="ikonica"><i class="fa-sharp fa-solid fa-right-from-bracket"></i></a>
</header>
<div class="zadatak">

    <h2 id="naslov_zadatka"><?= $zadatak->naslov ?></h2>

    <p>
        <span>Opis: </span>
        <div class="linija"></div>
        <?= $zadatak->opis ?>
    </p>
    <p>
        <span>Lista izvršioca: </span>
        <div class="linija"></div>
        <?= implode(', ', Korisnik::vrati_ime_vise_korisnika($zadatak->lista_izvrsioca)) ?>
    </p>
    <p>
        <span>Rukovodilac: </span>
        <div class="linija"></div>
        <?= Korisnik::vrati_ime_korisnika($zadatak->rukovodilac) ?>
    </p>
    <p>
        <span>Rok izvršenja: </span>
        <div class="linija"></div>
        <?= $zadatak->rok_izvrsenja ?>
    </p>
    <p>
        <span>Prioritet: </span>
        <div class="linija"></div>
        <?= $zadatak->prioritet ?>
    </p>
    <p>
        <span>Grupa zadataka: </span>
        <div class="linija"></div>
        <?= Zadatak::vrati_naziv_grupe_zadataka($zadatak->id_grupe) ?>
    </p>
    <p>
        <span>Status: </span>
        <div class="linija"></div>
        <?= $zadatak->status ?>
    </p>
    <p>
        <span>Fajl: </span>
        <div class="linija"></div>
        <a href="../../../logic/download.php?file_path=<?= $zadatak->fajl ?>"><?= $zadatak->fajl ?></a>
    </p>

    <a href="../../../logic/zavrsi_zadatak_detaljnije_ruk.php?id=<?= urlencode($id_zadatka) ?>" class="button2">Završi zadatak</a>
    <a href="../../../logic/otkazi_zadatak_detaljnije_ruk.php?id=<?= urlencode($id_zadatka) ?>" class="button2">Otkaži zadatak</a>

</div>

<div class="komentari">
    <h2>Komentari</h2>
    <div class="divider"></div>

    <form id="commentForm">
        <textarea id="newComment" name="sadrzaj" placeholder="Dodajte komentar" maxlength="150" required></textarea>
        <button type="submit" class="button3">Dodaj komentar</button>
    </form>

    <?php foreach ($zadatak->komentari as $komentar): ?>
        <div class="komentar">
            <p id="korisnik"><?= $komentar->korisnik()->username ?></p>
            <p id="datum"><?= $komentar->kreirano ?></p>
            <p id="komentar"><?= $komentar->sadrzaj ?></p>
            <button class="brisi" onclick="deleteComment(<?= $komentar->id ?>)">Obriši</button>
            <div class="divider"></div>
        </div>
    <?php endforeach; ?>
</div>
<footer>
    Milica Lazić I011-41/2020<br>Copyright © 2024
</footer>
</body>
</html>