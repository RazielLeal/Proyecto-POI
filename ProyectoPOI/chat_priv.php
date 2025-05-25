<?php
session_start();

require 'php/confi.php'; // Asegúrate de que la ruta sea correcta

//Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['unique_id'])) {
    header("Location: login.php");
    exit();
}


// Obtener la ruta de la imagen del usuario desde la sesión
$user_img = isset($_SESSION['img']) ? $_SESSION['img'] : 'CSS/img/avatar.png'; // Imagen predeterminada si no hay imagen

//Obtener el unique_ID del usuario por la sesion para actualizar el estado de conexion
$unique_id = $_SESSION['unique_id'];

$updateStatus = "UPDATE users SET connected = 'ONLINE' WHERE unique_id = ?";
$stmt = $conn->prepare($updateStatus);
$stmt->bind_param("s", $unique_id); 
$stmt->execute();

$user_idsession = $_SESSION['user_id']; // Obtener el user_id del usuario logueado

$mostrarchats = "SELECT 
    user_id, 
    unique_id, 
    fname, 
    lname, 
    img, 
    connected 
    FROM users
    WHERE user_id != ? ";

$stmt = $conn->prepare($mostrarchats);
$stmt->bind_param("i", $user_idsession);
if (!$stmt->execute()) {
    die("Error al ejecutar la consulta: " . $stmt->error);
}
$result = $stmt->get_result();
if (!$result) {
    die("Error al obtener los resultados: " . $stmt->error);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Privado</title>
    <link rel="stylesheet" href="CSS/chat_private.css">
    <link rel="stylesheet" href="CSS/general.css">
</head>
<body>
    <header>
        <nav>
            <h1>Nombre o logo</h1>
            <div class = "navegation_bar">
                <!-- Chat privado -->
                <a href="chat_priv.php" class = "tag-width" id="chatprivado"></a> 
                <a href="chat_group.php" class = "tag-width" id="grupal"></a>
                <a href="tasks.php" class = "tag-width" id="tasks"></a>
                <a href="rewards.php" class = "tag-width" id="rewards"></a>
                <!-- <a href="settings.php" class = "tag-width" id="settings"></a> -->
                <a href="logout.php" class = "tag-width" id="logout"></a>
            </div>
            <img src="<?php echo $user_img; ?>" alt="Avatar" class="avatar">
        </nav>
    </header>

    <br><br><br><br><br>

    <div class="container">

        <!-- Lista de Usuarios -->
        <aside class="user-list">
            <h2>Usuarios</h2>
            <ul>
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $user_id = $row['user_id'];
                        $full_name = $row['fname'] . " " . $row['lname'];
                        $user_img = !empty($row['img']) ? $row['img'] : "CSS/img/avatar.png";
                        $connected = $row['connected']; // Estado de conexión de los usuarios en lista

                        if($row['unique_id'] == $unique_id){
                            continue; // No mostrar el propio usuario en la lista

                        }
                        echo "<li id='user-$user_id' onclick='openChat(\"$full_name\", \"$connected\", $user_id)' data-user-id='$user_id'>";
                        echo "<img src='$user_img' alt='$full_name' class='user-avatar'>";
                        echo $full_name;
                        echo "<span id='user-$user_id-unread' class='unread-badge'>0</span>";
                        echo "</li>";    
                    
                    }
                } else {
                    echo "<p>No hay usuarios registrados.</p>";
                }
            ?>
            
            </ul>
        </aside>

        <!-- Sección de Chat -->
        <section class="chat-container">

            <div class="chat-header">
                <div class="user-info">
                    <h2 id="chat-title">Selecciona un usuario</h2>
                    <p id="status"></p>
                </div>
                <button type="button" onclick="startVideoCall()">📞Videollamada</button>
                <button>🔐Encriptar</button>
            </div>

            <div class="chat-box" id="chat-box">
                
            </div>
            
            <form class="chat-input" onsubmit="sendMessage(event)">
                <button>📷</button>                
                <button>📍</button>
                <input type="text" id="message-input" placeholder="Escribe un mensaje...">            
                <button onclick="sendMessage()">&#9206</button>
            </form>
            
        </section>
    </div>

    <script>
    let currentUser = "";
    let currentChatId = null;
    let lastMessageId = 0; // Guardará el ID del último mensaje recibido

    function openChat(user, connected, receiverId) {
        // Obtener el chat_id real
        fetch("get_or_create_chat.php", {
            method: "POST",
            body: new URLSearchParams({ receiver_id: receiverId }),
            headers: { "Content-Type": "application/x-www-form-urlencoded" }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                currentUser = user;
                currentChatId = data.chat_id;
                document.getElementById("chat-title").textContent = "Chat con " + user;
                document.getElementById("status").innerHTML = "";

                let statusText = (connected === "ONLINE") ? "🟢 En línea" : "🔴 Desconectado";
                document.getElementById("status").textContent += statusText;

                loadMessages(true);
                listenForNewMessages();
            } else {
                alert("Error al obtener chat");
            }
        })
        .catch(error => {
            console.error("Error al obtener chat_id:", error);
        });
    }


    function sendMessage(event) {
        event.preventDefault();

        let messageInput = document.getElementById("message-input");
        let message = messageInput.value.trim();

        if (message === "" || currentChatId === null) return;

        let formData = new FormData();
        formData.append("chat_id", currentChatId);
        formData.append("message", message);

        fetch("send_message.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data === "success") {
                messageInput.value = ""; 
                loadMessages(); // Cargar mensajes después de enviar
            } else {
                console.error("Error al enviar mensaje:", data);
            }
        });
    }

    function loadMessages(scrollToBottom = false) {
        if (currentChatId === null) return;

        fetch(`get_messages.php?chat_id=${currentChatId}`)
        .then(response => response.json()) // Recibe un array de mensajes
        .then(data => {
            let chatBox = document.getElementById("chat-box");
            let isScrolledToBottom = chatBox.scrollHeight - chatBox.clientHeight <= chatBox.scrollTop + 1;

            let newMessagesHtml = data.messages.map(msg => `<p><b>${msg.sender}:</b> ${msg.text}</p>`).join("");
            chatBox.innerHTML = newMessagesHtml;

            // Actualizar el último mensaje ID
            if (data.messages.length > 0) {
                lastMessageId = data.messages[data.messages.length - 1].id;
            }

            if (scrollToBottom || isScrolledToBottom) {
                chatBox.scrollTop = chatBox.scrollHeight; // Desplazar al último mensaje
            }
        });
    }

    function listenForNewMessages() {
        if (currentChatId === null) return;

        fetch(`get_new_messages.php?chat_id=${currentChatId}&last_id=${lastMessageId}`)
        .then(response => response.json())
        .then(data => {
            if (data.new_messages) {
                console.log("Nuevos mensajes recibidos:", data.messages);

                // Añadir los nuevos mensajes al chat
                let chatBox = document.getElementById("chat-box");
                // let newMessagesHtml = data.messages.map(msg => `<p><b>${msg.sender}:</b> ${msg.text}</p>`).join("");
                    
                // chatBox.innerHTML += newMessagesHtml; // Añadir mensajes sin borrar los anteriores

                loadMessages(scrollToBottom = false ); // Cargar mensajes después de recibir nuevos
                // Actualizar el último mensaje ID
                lastMessageId = data.messages[data.messages.length - 1].id;
                    
                // Desplazar al último mensaje
                chatBox.scrollTop = chatBox.scrollHeight;
            }
            // Vuelve a escuchar nuevos mensajes inmediatamente
            listenForNewMessages();
        })
        .catch(error => console.error('Error al obtener nuevos mensajes:', error));

            

        setInterval(checkIncomingCall, 5000);

        function checkIncomingCall() {
            fetch("check_videollamada.php")
                .then(res => res.json())
                .then(data => {
                    if (data.call_pending) {
                        if (confirm("Tienes una videollamada entrante de " + data.caller_name + ". ¿Aceptar?")) {
                            window.location.href = "video_llamada.html?caller=" + data.caller_id;
                        }
                    }
                });
        }

    }

    function startVideoCall() {
        if (currentChatId === null) {
            alert("Selecciona un usuario primero.");
            return;
        }

        fetch("solicitar_videollamada.php", {
            method: "POST",
            body: new URLSearchParams({ receiver_id: currentChatId }),
            headers: { "Content-Type": "application/x-www-form-urlencoded" }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.href = `video_llamada.html?receiver_id=${currentChatId}`;
            } else {
                alert("Error al iniciar videollamada.");
            }
        });
    }

</script>


</body>
</html>