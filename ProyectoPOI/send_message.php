<?php
session_start();
require 'php/confi.php'; // Asegúrate de que la ruta sea correcta

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; // ID del usuario actual
    $chat_id = $_POST['chat_id']; // ID del chat
    $message = trim($_POST['message']); // Mensaje enviado

    if (!empty($message)) {
        $insertQuery = "INSERT INTO messages (chat_id, text, user_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("isi", $chat_id, $message, $user_id);  // Usar $user_id
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "empty";
    }
}
?>
