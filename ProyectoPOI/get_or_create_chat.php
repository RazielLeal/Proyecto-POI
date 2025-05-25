<?php
session_start();
require 'php/confi.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['receiver_id'])) {
    echo json_encode(["success" => false, "message" => "Datos faltantes"]);
    exit;
}

$uid1 = $_SESSION['user_id'];
$uid2 = intval($_POST['receiver_id']);

$stmt = $conn->prepare("CALL SP_GetOrCreateChatID(?, ?, @chat_id_result)");
$stmt->bind_param("ii", $uid1, $uid2);
$stmt->execute();
$stmt->close();

$result = $conn->query("SELECT @chat_id_result AS chat_id");
$row = $result->fetch_assoc();

echo json_encode([
    "success" => true,
    "chat_id" => $row['chat_id']
]);
?>
