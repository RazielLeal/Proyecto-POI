<?php

session_start();
require 'php/confi.php'; // Asegúrate de que la ruta sea correcta

// Verificar si el usuario está logueado
if (isset($_SESSION['unique_id'])) {
    $unique_id = $_SESSION['unique_id'];

    // Actualizar el estado a 'OFFLINE'
    $updateStatus = "UPDATE users SET connected = 'OFFLINE' WHERE unique_id = ?";
    $stmt = $conn->prepare($updateStatus);
    $stmt->bind_param("s", $unique_id);
    $stmt->execute();

    // Destruir sesión y redirigir al login
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}

// session_start();
// session_unset(); // Elimina todas las variables de sesión
// session_destroy(); // Destruye la sesión

// // Redirige al usuario al login
// header("Location: login.php");
// exit;
?>
