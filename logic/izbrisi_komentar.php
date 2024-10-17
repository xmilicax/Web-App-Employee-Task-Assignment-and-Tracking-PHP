<?php
require_once __DIR__ . '/../database/Komentar.php';

session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_komentara = $_POST['id_komentara'];

    try {
        Komentar::izbrisi_komentar($id_komentara);
        echo json_encode(["status" => "success"]);
        exit;
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        exit;
    }
}
?>
