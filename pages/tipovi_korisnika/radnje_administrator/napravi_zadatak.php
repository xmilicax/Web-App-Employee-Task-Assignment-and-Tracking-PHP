<?php
session_start();

// provera da li je korisnik ulogovan
if (!isset($_SESSION['username'])) {
    header('Location: ../../login.php?status=expired_session');
    exit();
}

if ($_SESSION['id_tip_korisnika'] != 1) {
    header('Location: ../../login.php?error=restricted_access');
    $poruka_login = 'Sesija je istekla. Molimo ulogujte se ponovo.';
    exit();
}

require_once __DIR__ . '/../../../database/Zadatak.php';
require_once __DIR__ . '/../../../database/Korisnik.php';
require_once __DIR__ . '/../../../database/Grupa.php';

$izvrsioci = Zadatak::vrati_izvrsioce();
$grupe_zadataka = Zadatak::vrati_grupe_zadataka();
$rukovodioci = Zadatak::vrati_rukovodioce();

$poruka_uspesno = '';
$poruka_greska = '';

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'uspesno') {
        $poruka_uspesno = '<br>Zadatak je uspešno kreiran.<br><br>';
    } else if ($_GET['status'] == 'greska') {
        $poruka_greska = '<br>Došlo je do greške pri kreiranju zadatka.<br>Pokušajte ponovo.<br><br>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Napravi zadatak</title>
    <link rel="icon" href="../../../css/img/logo_krug.png">
    <link rel="stylesheet" href="../../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<header class="header1">
    <a href="../administrator.php" class="ikonica"><i class="fas fa-home"></i></a>
    <h1>Napravi zadatak</h1>
    <a href="../../../logic/logout.php" class="ikonica"><i class="fa-sharp fa-solid fa-right-from-bracket"></i></a>
</header>
<form id="napravi" action="../../../logic/napravi_zadatak_admin.php" method="POST" enctype="multipart/form-data">
    <p id="status_uspesno"><?= $poruka_uspesno ?></p>
    <p id="status_greska"><?= $poruka_greska ?></p>

    <label for="naslov">Naslov:</label>
    <input type="text" name="naslov" placeholder="Unesite naslov" id="naslov" maxlength="191" required><br>

    <label for="opis">Opis zadatka:</label>
    <textarea name="opis" id="opis" placeholder="Unesite opis zadatka" required></textarea>

    <br><br>
    <label for="lista_izvrsioca">Izvršilac:</label>
    <select name="lista_izvrsioca[]" id="lista_izvrsioca" multiple required>
        <?php foreach ($izvrsioci as $izvrsilac): ?>
            <option value="<?= $izvrsilac->id ?>"><?= $izvrsilac->username ?></option>
        <?php endforeach; ?>
    </select>

    <label for="rukovodilac">Rukovodilac:</label>
    <select name="rukovodilac" id="rukovodilac" required>
        <?php foreach ($rukovodioci as $rukovodilac): ?>
            <option value="<?= $rukovodilac->id ?>"><?= $rukovodilac->username ?></option>
        <?php endforeach; ?>
    </select>

    <br><br>
    <label for="rok_izvrsenja" >Rok izvršenja:</label>
    <input type="datetime-local" name="rok_izvrsenja" id="rok_izvrsenja" required><br>

    <br>
    <label for="prioritet" >Prioritet:</label>
    <input type="number" name="prioritet" id="prioritet" min="1" max="10" placeholder="1-10" required><br>

    <br>
    <label for="id_grupe" >Grupa zadataka:</label>
    <select name="dropdown" id="id_grupe" required>
        <?php foreach ($grupe_zadataka as $grupa_zadataka): ?>
            <option value="<?= $grupa_zadataka->id ?>"><?= $grupa_zadataka->naziv ?></option>
        <?php endforeach; ?>
    </select>

    <br><br>
    <label for="fajl">Fajl:</label>
    <input type="file" name="fajl" id="fajl" multiple><br>

    <input type="submit" value="Napravi zadatak" class="button">
</form>
<footer>
    Milica Lazić I011-41/2020<br>Copyright © 2024
</footer>
</body>
</html>