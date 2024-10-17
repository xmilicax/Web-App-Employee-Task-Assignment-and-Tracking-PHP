<?php
session_start();

// provera da li je korisnik ulogovan
if (!isset($_SESSION['username'])) {
    header('Location: ../../login.php?status=expired_session');
    exit();
}

if ($_SESSION['id_tip_korisnika'] != 2) {
    session_destroy();
    header('Location: ../../login.php?status=restricted_access');
    exit();
}

require_once __DIR__ . '/../../../database/Zadatak.php';
require_once __DIR__ . '/../../../database/Korisnik.php';
require_once __DIR__ . '/../../../database/Grupa.php';

$grupe_zadataka = Zadatak::vrati_grupe_zadataka();

$poruka_uspesno = '';
$poruka_greska = '';

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'uspesno') {
        $poruka_uspesno = '<br>Grupa zadataka je uspešno izbrisana.<br><br>';
    } else if ($_GET['status'] == 'greska') {
        $poruka_greska = '<br>Došlo je do greške pri brisanju grupe zadatka.<br>Pokušajte ponovo.<br><br>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izbriši grupu zadataka</title>
    <link rel="icon" href="../../../css/img/logo_krug.png">
    <link rel="stylesheet" href="../../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<header class="header1">
    <a href="../rukovodilac_odeljenja.php" class="ikonica"><i class="fas fa-home"></i></a>
    <h1>Izbriši grupu zadataka</h1>
    <a href="../../../logic/logout.php" class="ikonica"><i class="fa-sharp fa-solid fa-right-from-bracket"></i></a>
</header>
<form action="../../../logic/izbrisi_grupu_zadataka.php" method="POST">
    <p id="status_uspesno"><?= $poruka_uspesno ?></p>
    <p id="status_greska"><?= $poruka_greska ?></p>

    <label for="id">Grupa zadataka za brisanje:</label>
    <select name="dropdown" id="id_grupe" required>
        <?php foreach ($grupe_zadataka as $grupa_zadataka): ?>
            <option value="<?= $grupa_zadataka->id ?>"><?= $grupa_zadataka->naziv ?></option>
        <?php endforeach; ?>
    </select>

    <input type="submit" value="Izbriši grupu" class="button">
</form>
<footer>
    Milica Lazić I011-41/2020<br>Copyright © 2024
</footer>
</body>
</html>