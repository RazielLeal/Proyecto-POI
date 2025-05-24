<?php
require 'php/confi.php';

if (isset($_POST['submit'])) {
    $nombre = trim($_POST["fname"]);
    $apellidos = trim($_POST["lname"]);
    $correo = trim($_POST["email"]);
    $contra = password_hash(trim($_POST["password"]), PASSWORD_BCRYPT); // Encriptar la contraseña
    $status = "Activo"; // Estado inicial del usuario
    $unique_id = uniqid(); // Generar un ID único para el usuario
    $cr_date = date("Y-m-d H:i:s"); // Fecha de creación

    // Manejo del archivo de imagen
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $img_name = $_FILES['image']['name'];
        $img_tmp = $_FILES['image']['tmp_name'];
        $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $allowed_ext = ['png', 'jpg', 'jpeg', 'gif'];

        if (in_array($img_ext, $allowed_ext)) {
            // Ruta de destino para guardar la imagen
            $new_img_name = uniqid("IMG_", true) . '.' . $img_ext;
            $img_upload_path = "CSS/img/Perfiles/" . $new_img_name;

            // Mover la imagen a la carpeta de destino
            if (move_uploaded_file($img_tmp, $img_upload_path)) {
                // Guardar la ruta relativa en la base de datos
                $img_db_path = $img_upload_path;

                // Insertar datos en la base de datos
                $query = "INSERT INTO users (unique_id, fname, lname, email, password, img, status, cr_date) 
                          VALUES ('$unique_id', '$nombre', '$apellidos', '$correo', '$contra', '$img_db_path', '$status', '$cr_date')";

                if (mysqli_query($conn, $query)) {
                    $last_user_id = mysqli_insert_id($conn); // Obtener el ID del nuevo usuario insertado
                    $createChatsQuery = "CALL CreateChatsForNewUser($unique_id)";                    
                    echo "<script>alert('Usuario registrado correctamente.'); window.location.href='register.php';</script>";
                } else {
                    echo "Error al registrar el usuario: " . mysqli_error($conn);
                }
            } else {
                echo "Error al subir la imagen.";
            }
        } else {
            echo "Formato de imagen no permitido. Solo se permiten PNG, JPG, JPEG y GIF.";
        }
    } else {
        echo "Por favor, selecciona una imagen.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="Chisme Net 2.0" content="width=device-width, initial-scale=1.0">
    <title>ChismeNet 2.0 / Register</title>
    <link rel="stylesheet" type="text/css" href="CSS/general.css">
    <link rel="stylesheet" type="text/css" href="CSS/register.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
</head>

<body>
    
    <div id="registro">
        <form id = "form-register" action = "#" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div id = "text-register">Registrarme</div> <br><br>

            <label id = "text_name">Nombre:</label> <br>
            <input type="text" class = "text" name="fname" id="name" placeholder="Nombre(s)" required>            
            <input type="text" class = "text" name="lname" id="lastname" placeholder="Apellidos" required> <br><br>
            <div class="error-message" id="error-name"></div>

            <label id = "text_email">Correo electrónico:</label> <br>
            <input type="email" class = "text" name="email" id="email" placeholder="Correo electrónico" required> <br><br>
            <div class="error-message" id="error-email"></div>

            <label id = "text_email">Foto de perfil:</label> <br>
            <input type="file" name="image" name="image" accept="image/x-png, image /gif,image/jpeg,image/jpg" required> <br>
            <br>
            <label id = "text_password">Contraseña:</label> <br>
            <div style="position: relative;">
                <input type="password" class="text" name="password" id="email" placeholder="Contraseña" required>
                <i class="fas fa-eye" id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
            </div>
            <div class="error-message" id="error-password"></div>

            <button type = "submit" name = "submit" id = "botonRegister" class="button-grow"> Enviar </button> <br>
            <br>
            <a href = "login.php" type="submit" id = "registerLink"> ¿Ya tienes cuenta? Inicia sesion aqui</a> 
            <br>

        </form>
        

    </div>

    <script src = "css/js-animation/slidedown.js"></script>
    <script type="text/javascript" src = "JS/pass-show-hide.js"></script>
    <!-- <script src = "js/validations.js"></script> -->
</body>
</html>
