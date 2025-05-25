<?php
session_start();
require 'php/confi.php';

if (!isset($_SESSION['user_id'])) {
    die("Usuario no autenticado");
}

$sender_id = $_SESSION['user_id'];
$receiver_id = intval($_POST['chat_id']); // en realidad es user_id del receptor
$message = trim($_POST['message']);

if (empty($message) || $receiver_id === 0) {
    die("Datos incompletos");
}

// Llamar al procedimiento almacenado
$stmt = $conn->prepare("CALL SP_SendMsgPriv(?, ?, ?)");
$stmt->bind_param("iis", $sender_id, $receiver_id, $message);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error al enviar mensaje";
}
?>
