<?php
session_start();

// provera da li je korisnik ulogovan
if (!isset($_SESSION['username'])) {
    header('Location: ../../login.php?status=expired_session');
    exit();
}

if ($_SESSION['id_tip_korisnika'] != 1) {
    header('Location: ../login.php?error=restricted_access');
    $errorMessage = 'Sesija je istekla. Molimo ulogujte se ponovo.';
    exit();
}

require_once __DIR__ . '/../../../database/Korisnik.php';

$tipovi_korisnika = Korisnik::vrati_tipove_korisnika();

$poruka_uspesno = '';
$poruka_greska = '';

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'uspesno') {
        $poruka_uspesno = 'Tip korisnika je uspešno izmenjen.';
    } else if ($_GET['status'] == 'greska') {
        $poruka_greska = 'Došlo je do greške pri izmeni tipa korisnika. Pokušajte ponovo.';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izmeni tip korisnika</title>
    <link rel="icon" href="../../../css/img/logo_krug.png">
    <link rel="stylesheet" href="../../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<header class="header1">
    <a href="../administrator.php" class="ikonica"><i class="fas fa-home"></i></a>
    <h1>Izmeni tip korisnika</h1>
    <a href="../../../logic/logout.php" class="ikonica"><i class="fa-sharp fa-solid fa-right-from-bracket"></i></a>
</header>
<form action="../../../logic/izmeni_tip_korisnika.php" method="POST">
    <p id="status_uspesno"><?= $poruka_uspesno ?></p>
    <p id="status_greska"><?= $poruka_greska ?></p>

    <label for="id">Izaberi tip korisnika za izmenu</label>
    <select name="dropdown" id="id_grupe" required>
        <?php foreach ($tipovi_korisnika as $tip_korisnika): ?>
            <option value="<?= $tip_korisnika->id ?>"><?= $tip_korisnika->naziv ?></option>
        <?php endforeach; ?>
    </select>

    <label for="id">Novi naziv tipa korisnika</label>
    <input type="text" name="naziv" placeholder="Unesite naziv tipa korisnika" required>

    <input type="submit" value="Izmeni tip korisnika" class="button">
</form>
<footer>
    Milica Lazić I011-41/2020<br>Copyright © 2024
</footer>
</body>
</html>
