<?php
require 'php/confi.php'; // Asegúrate de que este archivo contiene la conexión a la base de datos

session_start();

if (isset($_POST['botonLogin'])) {
    $correo = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Verificar si los campos están vacíos
    if (!empty($correo) && !empty($password)) {
        // Consulta para verificar el correo
        $query = "SELECT * FROM users WHERE email = '$correo'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Verificar la contraseña
            if (password_verify($password, $row['password'])) {
                // Guardar información del usuario en la sesión
                $_SESSION['unique_id'] = $row['unique_id'];
                $_SESSION['fname'] = $row['fname'];
                $_SESSION['lname'] = $row['lname'];
                $_SESSION['img'] = $row['img']; // Guardar la ruta de la imagen en la sesión
                $_SESSION['user_id'] = $row['user_id']; // Guardar el user_id en la sesión
                // Redirigir al usuario a la página de inicio
                header("Location: chat_priv.php");
                exit();
            } else {
                echo "<script>alert('Contraseña incorrecta.');</script>";
            }
        } else {
            echo "<script>alert('El correo no está registrado.');</script>";
        }
    } else {
        echo "<script>alert('Por favor, completa todos los campos.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="Chisme Net 2.0" content="width=device-width, initial-scale=1.0">
    <title>ChismeNet 2.0 / Login</title>
    <link rel="stylesheet" type="text/css" href="CSS/general.css">
    <link rel="stylesheet" type="text/css" href="CSS/login.css">
</head>

<body>
    <br><br><br><br><br><br>

    <div id="login">
        <form action="#" method="POST" autocomplete="off">
            <div id="text-login">Iniciar sesión</div> <br><br>
            
            <input type="text" name="email" id="text_email" placeholder="Correo electrónico" required>
            <img src="css/img/user-icon.png" class="user-icon" alt="user-icon">
            <br><br>
           
            <input type="password" name="password" id="text_password" placeholder="Contraseña" required> 
            <img src="css/img/lock-icon.png" class="lock-icon" alt="lock-icon">    
            <br><br><br>
            <a href="register.php" id="registerLink">¿No tienes cuenta? Regístrate aquí</a> <br>
    
            <button type="submit" name="botonLogin" id="botonLogin" class="button-grow">Ingresar</button>
        </form>
    </div>

</body>
</html>