<?php
require 'php/confi.php'; // asegúrate de que esta conexión es válida

if (!isset($_GET['user_id'])) {
    echo json_encode(["success" => false, "message" => "Falta user_id"]);
    exit;
}

$user_id = intval($_GET['user_id']);
$stmt = $conn->prepare("SELECT img, fname, lname FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        "success" => true,
        "img" => $row['img'] ?? "CSS/img/avatar.png",
        "name" => $row['fname'] . ' ' . $row['lname']
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Usuario no encontrado"]);
}
?>
