<?php

session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: ../../login.php?status=expired_session');
    exit();
}

// Check user type
if ($_SESSION['id_tip_korisnika'] != 3) {
    header('Location: ../../login.php?status=restricted_access');
    exit();
}

require_once __DIR__ . '/../../../database/Korisnik.php';
require_once __DIR__ . '/../../../database/Zadatak.php';
require_once __DIR__ . '/../../../database/Grupa.php';

// Collect all necessary data
$database = new PDO("mysql:host=localhost;dbname=baza", "root", "");

// Default sorting by naslov if no sorting parameter is provided
$orderBy = $_GET['sort'] ?? 'naslov';
$sortOrder = $_GET['order'] ?? 'asc';

$query = "SELECT * FROM zadaci ORDER BY $orderBy $sortOrder";
$zadaci = $database->query($query)->fetchAll(PDO::FETCH_ASSOC);


$grupe_zadataka = Zadatak::vrati_grupe_zadataka();

$zadaci_sa_komentarima = [];
foreach ($zadaci as $row) {
    $id = $row['id'];
    $komentari = Zadatak::vrati_komentar_zadatak($id);
    $row['komentari'] = $komentari;
    $zadaci_sa_komentarima[] = $row;
}

$database = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spisak zadataka</title>
    <link rel="icon" href="../../../css/img/logo_krug.png">
    <link rel="stylesheet" href="../../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var currentUrl = window.location.href;
            if (!currentUrl.includes('?')) {
                window.location.href = currentUrl + '?sort=id&order=asc';
            }
        });

        function toggleSort(column) {
            var currentUrl = window.location.href;
            var newUrl;

            if (currentUrl.includes('?')) {
                // provera da li već postoji sort u url-u
                if (currentUrl.includes('sort=' + column)) {
                    // sortiranje pomoću naizmeničnog klika
                    if (currentUrl.includes('order=asc')) {
                        newUrl = currentUrl.replace('order=asc', 'order=desc');
                    } else {
                        newUrl = currentUrl.replace('order=desc', 'order=asc');
                    }
                } else {
                    // promena sort-a po koloni (dolazi do ovoga čim kliknemo na naslov, jer se sort radi sa id po default-u)
                    newUrl = currentUrl.includes('sort=') ?
                        currentUrl.replace(/sort=[^&]*/, 'sort=' + column).replace(/order=[^&]*/, 'order=asc') :
                        currentUrl + '&sort=' + column + '&order=asc';
                }
            }
            window.location.href = newUrl;
        }
    </script>
</head>
<body>
<header class="header1">
    <a href="../izvrsilac.php" class="ikonica"><i class="fas fa-home"></i></a>
    <h1>Spisak vaših zadataka</h1>
    <a href="../../../logic/logout.php" class="ikonica"><i class="fa-sharp fa-solid fa-right-from-bracket"></i></a>
</header>
<div class="container">
    <table id="tasksTable" class="display">
        <thead>
        <tr>
            <th>Naslov</th>
            <th>Opis</th>
            <th>
                <a href="#" onclick="toggleSort('lista_izvrsioca')">Izvršioci<i class="fa-solid fa-sort"></i></a>
            </th>
            <th>
                <a href="#" onclick="toggleSort('rukovodilac')">Rukovodilac<i class="fa-solid fa-sort"></i></a>
            </th>
            <th>
                <a href="#" onclick="toggleSort('rok_izvrsenja')">Rok izvršenja<i class="fa-solid fa-sort"></i></a>
            </th>
            <th>Prioritet</th>
            <th>Grupa zadatka</th>
            <th>Status</th>
            <th>Komentari</th>
            <th>Akcije</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($zadaci_sa_komentarima as $zadatak): ?>
            <!-- prikazuju se samo zadaci trenutnog izvrsioca -->
            <?php if (in_array($_SESSION['korisnik_id'], explode(',', $zadatak['lista_izvrsioca']))): ?>
                <tr>
                    <td>
                        <a href="zadatak_detaljnije_izvrsilac.php?id=<?= $zadatak['id'] ?>"><?= $zadatak['naslov']?></a>
                    </td>
                    <td><?= $zadatak['opis'] ?></td>
                    <!-- razdvajamo niz kako bismo ispisali imena pojedinačnih korisnika -->
                    <td><?= implode(',', Korisnik::vrati_ime_vise_korisnika($zadatak['lista_izvrsioca'])) ?></td>
                    <td><?= Korisnik::vrati_ime_korisnika($zadatak['rukovodilac']) ?></td>
                    <td><?= $zadatak['rok_izvrsenja'] ?></td>
                    <td><?= $zadatak['prioritet'] ?></td>
                    <td><?= Zadatak::vrati_naziv_grupe_zadataka($zadatak['id_grupe'])?></td>
                    <td><?= $zadatak['status'] ?></td>
                    <td>
                        <a href="zadatak_detaljnije_izvrsilac.php?id=<?= $zadatak['id'] ?>#komentar" id="table_button_1">Prikaži komentare</a>
                    </td>
                    <td>
                        <?php if ($zadatak['status'] !== "otkazan"): ?>
                            <a href="../../../logic/zavrsi_zadatak.php?id=<?= $zadatak['id'] ?>" id="table_button">Završi zadatak</a>
                        <?php endif ?>
                        <a href="zadatak_detaljnije_izvrsilac.php?id=<?= $zadatak['id'] ?>#komentar" id="table_button">Dodaj komentar</a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>

        </tbody>
    </table>
</div>
<footer>
    Milica Lazić I011-41/2020<br>Copyright © 2024
</footer>
</body>
</html>