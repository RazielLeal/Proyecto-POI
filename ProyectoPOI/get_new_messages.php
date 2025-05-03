<?php
header('Content-Type: application/json');
require 'php/confi.php'; 

$chat_id = $_GET['chat_id'] ?? 0;
$last_id = $_GET['last_id'] ?? 0;
$timeout = 30;  // Timeout en segundos

$sql = "SELECT message_id AS id, user_id AS sender, text FROM messages WHERE chat_id = ? AND message_id > ? ORDER BY message_id ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $chat_id, $last_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

// Si hay nuevos mensajes, devolverlos
if (!empty($messages)) {
    echo json_encode([
        'new_messages' => true,
        'messages' => $messages
    ]);
} else {
    // Mantener la conexión abierta hasta que haya nuevos mensajes
    // Reintentar hasta el timeout
    $start_time = time();
    while ((time() - $start_time) < $timeout) {
        // Verificar si hay nuevos mensajes
        $stmt->execute();
        $result = $stmt->get_result();
        $messages = [];
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
        
        if (!empty($messages)) {
            echo json_encode([
                'new_messages' => true,
                'messages' => $messages
            ]);
            break;
        }
        // Deja que el servidor pueda procesar otras solicitudes mientras espera
        sleep(1);
    }
    
    // Si no hay nuevos mensajes, devolver la respuesta sin mensajes
    if (empty($messages)) {
        echo json_encode(['new_messages' => false]);
    }
}

$conn->close();
?>
