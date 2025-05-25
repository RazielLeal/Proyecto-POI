<?php
session_start();
require 'php/confi.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['receiver_id'])) {
    echo json_encode(["success" => false]);
    exit;
}

$caller_id = $_SESSION['user_id'];
$receiver_id = intval($_POST['receiver_id']);

// Insertar la solicitud
$stmt = $conn->prepare("INSERT INTO video_calls (caller_id, receiver_id) VALUES (?, ?)");
$stmt->bind_param("ii", $caller_id, $receiver_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}
?>
