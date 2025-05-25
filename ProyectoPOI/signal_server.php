<?php
session_start();

$signalDir = __DIR__ . '/signal_data';

// Crear el directorio si no existe
if (!file_exists($signalDir)) {
    mkdir($signalDir, 0777, true);
}

// Limpieza automática de archivos viejos (más de 2 minutos)
$files = glob("$signalDir/*.json");
$now = time();
foreach ($files as $file) {
    if (is_file($file) && ($now - filemtime($file)) > 120) {
        unlink($file);
    }
}

// Identificar al usuario actual
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Usuario no autenticado"]);
    exit;
}
$currentUserId = $_SESSION['user_id'];

// Modo lectura
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $filePath = "$signalDir/$currentUserId.json";
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        echo $content;
        unlink($filePath); // eliminar tras leer para que no se procese dos veces
    } else {
        echo json_encode([]);
    }
    exit;
}

// Modo escritura
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['type'])) {
        http_response_code(400);
        echo json_encode(["error" => "Falta el tipo de señal"]);
        exit;
    }

    // Receptor obligatorio para saber a quién enviar la señal
    if (!isset($_GET['to'])) {
        http_response_code(400);
        echo json_encode(["error" => "Falta receptor"]);
        exit;
    }

    $receiverId = intval($_GET['to']);
    $filePath = "$signalDir/$receiverId.json";

    // Guardar el contenido como JSON plano
    file_put_contents($filePath, json_encode($data));
    echo json_encode(["success" => true]);
    exit;
}

http_response_code(405);
echo json_encode(["error" => "Método no permitido"]);
?>
