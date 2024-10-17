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

$datum = $_GET['datum'] ?? null;
$izvrsilac = $_GET['izvrsilac'] ?? null;
$rukovodioci = $_GET['rukovodioci'] ?? null;

$zadaci = [];

if (isset($_GET['filtrirajDatum'])) {
    if ($datum !== null)
        $zadaci = Zadatak::filtriraj_po_datumu_izvrsilac($_SESSION['korisnik_id'], $datum);
} elseif (isset($_GET['filtrirajIzvrsioce'])) {
    if ($izvrsilac !== null)
        $zadaci = Zadatak::filtriraj_po_izvrsiocima_izvrsilac($_SESSION['korisnik_id'], $izvrsilac);
} elseif (isset($_GET['filtrirajRukovodioce'])) {
    if ($rukovodioci !== null)
        $zadaci = Zadatak::filtriraj_po_rukovodiocima_izvrsilac($_SESSION['korisnik_id'], $rukovodioci);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtriranje zadataka</title>
    <link rel="icon" href="../../../css/img/logo_krug.png">
    <link rel="stylesheet" href="../../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<header class="header1">
    <a href="../izvrsilac.php" class="ikonica"><i class="fas fa-home"></i></a>
    <h1>Filtriranje zadataka</h1>
    <a href="../../../logic/logout.php" class="ikonica"><i class="fa-sharp fa-solid fa-right-from-bracket"></i></a>
</header>

<div class="form-container">
    <form method="GET">
        <label for="datum">Datum:</label>
        <input type="date" name="datum" placeholder="Datum završetka:">
        <button type="submit" name="filtrirajDatum" class="dugme">Filtriraj</button>
    </form>

    <form method="GET">
        <label for="izvrsilac">Izvršilac:</label>
        <input type="text" name="izvrsilac" placeholder="Unesite ID izvršioca:">
        <button type="submit" name="filtrirajIzvrsioce" class="dugme">Filtriraj</button>
    </form>

    <form method="GET">
        <label for="rukovodioci">Rukovodioci:</label>
        <input type="text" name="rukovodioci" placeholder="Unesite ID rukovodioca">
        <button type="submit" name="filtrirajRukovodioce" class="dugme">Filtriraj</button>
    </form>
</div>
<?php if (!empty($zadaci)): ?>
    <div class="rezultati">
        <h2 id="sa_rezultatom">Rezultati pretrage:</h2>
        <table>
            <tr>
                <th>ID zadatka</th>
                <th>Naslov</th>
                <th>Opis</th>
                <th>Lista izvršioca</th>
                <th>Rukovodilac</th>
                <th>Rok izvršenja</th>
                <th>Prioritet</th>
                <th>Grupa zadataka</th>
                <th>Fajl</th>
                <th>Status</th>
            </tr>

            <?php foreach ($zadaci as $zadatak): ?>
                <tr>
                    <td><?= $zadatak->id ?></td>
                    <td><?= $zadatak->naslov ?></td>
                    <td><?= $zadatak->opis ?></td>
                    <td><?= $zadatak->lista_izvrsioca ?></td>
                    <td><?= Korisnik::vrati_ime_korisnika($zadatak->rukovodilac) ?></td>
                    <td><?= $zadatak->rok_izvrsenja ?></td>
                    <td><?= $zadatak->prioritet ?></td>
                    <td><?= Zadatak::vrati_naziv_grupe_zadataka($zadatak->id_grupe)?></td>
                    <td><?= $zadatak->fajl ?? "/" ?></td>
                    <td><?= $zadatak->status ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php else: ?>
    <p id="bez_rezultata">Nema pronađenih zadataka za traženi kriterijum.</p>
<?php endif; ?>
<footer>
    Milica Lazić I011-41/2020<br>Copyright © 2024
</footer>
</body>
</html>