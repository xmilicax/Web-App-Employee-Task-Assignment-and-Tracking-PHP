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

require_once __DIR__ . '/../../../database/Komentar.php';

$komentari = Komentar::vrati_komentare();

$poruka_uspesno = '';
$poruka_greska = '';

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'uspesno') {
        $poruka_uspesno = 'Komentar je uspešno izmenjen.';
    } else if ($_GET['status'] == 'greska') {
        $poruka_greska = 'Došlo je do greške pri izmeni komentara. Pokušajte ponovo.';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izmeni komentar</title>
    <link rel="icon" href="../../../css/img/logo_krug.png">
    <link rel="stylesheet" href="../../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<header class="header1">
    <a href="../administrator.php" class="ikonica"><i class="fas fa-home"></i></a>
    <h1>Izmeni komentar</h1>
    <a href="../../../logic/logout.php" class="ikonica"><i class="fa-sharp fa-solid fa-right-from-bracket"></i></a>
</header>
<form action="../../../logic/izmeni_komentar.php" method="POST">
    <p id="status_uspesno"><?= $poruka_uspesno ?></p>
    <p id="status_greska"><?= $poruka_greska ?></p>

    <label for="id">Izaberi komentar za izmenu</label>
    <select name="dropdown" id="id_grupe" required>
        <?php foreach ($komentari as $komentar): ?>
            <option value="<?= $komentar->id ?>"><?= $komentar->id ?> - <?= $komentar->sadrzaj ?></option>
        <?php endforeach; ?>
    </select>

    <label for="sadrzaj">Novi sadrzaj komentara</label>
    <input type="text" name="sadrzaj" placeholder="Unesite novi sadržaj komentara" required>

    <input type="submit" value="Izmeni komentar" class="button">
</form>
<footer>
    Milica Lazić I011-41/2020<br>Copyright © 2024
</footer>
</body>
</html>
