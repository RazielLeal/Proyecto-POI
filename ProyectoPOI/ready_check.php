<?php
session_start();

$readyDir = __DIR__ . '/signal_ready';
if (!file_exists($readyDir)) {
    mkdir($readyDir, 0777, true);
}

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Usuario no autenticado"]);
    exit;
}

$userId = $_SESSION['user_id'];
$filePath = "$readyDir/$userId.ready";

// 🔄 Limpieza automática (más de 2 minutos)
foreach (glob("$readyDir/*.ready") as $file) {
    if (time() - filemtime($file) > 120) {
        unlink($file);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // El usuario avisa que está listo
    file_put_contents($filePath, time());
    echo json_encode(["ready" => true]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['other'])) {
        http_response_code(400);
        echo json_encode(["error" => "Falta el ID del otro usuario"]);
        exit;
    }

    $otherId = intval($_GET['other']);
    $otherPath = "$readyDir/$otherId.ready";
    $isReady = file_exists($otherPath);
    echo json_encode(["other_ready" => $isReady]);
    exit;
}

http_response_code(405);
echo json_encode(["error" => "Método no permitido"]);
