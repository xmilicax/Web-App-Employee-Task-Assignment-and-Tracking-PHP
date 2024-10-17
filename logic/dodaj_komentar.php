<?php
require_once __DIR__ . '/../database/Komentar.php';

session_start();

header('Content-Type: application/json'); // Ensure the response is JSON

if (!isset($_SESSION['id_zadatka']) || !isset($_SESSION['korisnik_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Session variables not set']);
    exit();
}

$id_zadatka = $_SESSION['id_zadatka'];
$korisnik_id = (string)$_SESSION['korisnik_id'];
$sadrzaj = $_POST['sadrzaj'] ?? '';

try {
    $dodajkomentar = Komentar::dodaj_komentar($id_zadatka, $korisnik_id, $sadrzaj);
    if ($dodajkomentar) {
        echo json_encode([
            'status' => 'success',
            'kreirano' => $dodajkomentar->kreirano,
            'sadrzaj' => $dodajkomentar->sadrzaj,
            'korisnik' => $_SESSION['username']
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add comment']);
    }
    exit();
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    exit();
}
