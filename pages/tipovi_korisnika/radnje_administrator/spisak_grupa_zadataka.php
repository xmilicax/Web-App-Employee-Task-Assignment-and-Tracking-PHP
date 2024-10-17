<?php

session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: ../../login.php?status=expired_session');
    exit();
}

// Check user type
if ($_SESSION['id_tip_korisnika'] != 1) {
    header('Location: ../../login.php?status=restricted_access');
    exit();
}

require_once __DIR__ . '/../../../database/Zadatak.php';

$grupe_zadataka = Zadatak::vrati_grupe_zadataka();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spisak grupa zadataka</title>
    <link rel="icon" href="../../../css/img/logo_krug.png">
    <link rel="stylesheet" href="../../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<header class="header1">
    <a href="../administrator.php" class="ikonica"><i class="fas fa-home"></i></a>
    <h1>Spisak grupa zadataka</h1>
    <a href="../../../logic/logout.php" class="ikonica"><i class="fa-sharp fa-solid fa-right-from-bracket"></i></a>
</header>
<div class="container">
    <table id="tasksTable" class="skinny">
        <thead>
        <tr>
            <th>ID</th>
            <th>Naziv</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($grupe_zadataka as $grupa_zadataka): ?>
            <tr>
                <td><?= $grupa_zadataka->id ?></td>
                <td><?= $grupa_zadataka->naziv ?></td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
</div>
<footer>
    Milica Lazić I011-41/2020<br>Copyright © 2024
</footer>
</body>
</html>