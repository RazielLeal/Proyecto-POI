<?php
session_start();

$readyDir = __DIR__ . '/signal_ready';
$signalDir = __DIR__ . '/signal_data';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Usuario no autenticado"]);
    exit;
}

$userId = $_SESSION['user_id'];
$readyFile = "$readyDir/$userId.ready";
$signalFile = "$signalDir/$userId.json";

// Borrar archivo .ready
if (file_exists($readyFile)) {
    unlink($readyFile);
}

// Borrar archivo .json de señalización
if (file_exists($signalFile)) {
    unlink($signalFile);
}

echo json_encode(["cleared" => true]);
