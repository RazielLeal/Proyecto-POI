<?php
session_start();

if (!isset($_SESSION['img'])) {
    echo json_encode(["success" => false, "img" => "CSS/img/avatar.png"]);
    exit;
}

echo json_encode([
    "success" => true,
    "img" => $_SESSION['img']
]);
?>
