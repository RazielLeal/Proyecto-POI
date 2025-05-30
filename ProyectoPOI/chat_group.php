<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Grupal</title>
    <link rel="stylesheet" href="CSS/general.css">
    <link rel="stylesheet" href="CSS/chat_group.css">
</head>
<body>
    <header>
        <nav>
            <h1>Nombre o logo</h1>
            <div class = "navegation_bar">
                <a href="chat_priv.php" class = "tag-width" id="chatprivado"></a> 
                <a href="chat_group.php" class = "tag-width" id="grupal"></a>
                <a href="tasks.php" class = "tag-width" id="tasks"></a>
                <a href="rewards.php" class = "tag-width" id="rewards"></a>
                <!-- <a href="settings.php" class = "tag-width" id="settings"></a> -->
                <a href="logout.php" class = "tag-width" id="logout"></a>
            </div>
            <img src="CSS/img/avatar.png" alt="Avatar" class="avatar">
        </nav>
    </header>
    
    <br><br><br><br><br>

    <div class="container">
        
        <!-- Panel izquierdo con lista de grupos -->
        <aside class="group-list">
            <h2>Grupos</h2>
            <ul>
                <li onclick="openChat('grupo1')">⚡ Grupo 1</li>
                <li onclick="openChat('grupo2')">🔥 Grupo 2</li>
                <li onclick="openChat('grupo3')">🌎 Grupo 3</li>     
            </ul>
            <div>
                <button id="btn_creargrupo">+ Crear grupo</button>
            </div>
            
        </aside>

        <!-- Panel derecho con chat -->
        <section class="chat-container show" id="chat-container-CB">
            <div class="chat-header">
                <h2 id="group-name">Selecciona un grupo</h2>
                <p id="group-members"></p>
            </div>
            
            <div class="chat-box" id="chat-box">
                <p>📩 Aquí aparecerán los mensajes...</p>
            </div>
            <div class="chat-input">
                <button >🔗</button>
                <button >📍</button>
                <input type="text" id="message" placeholder="Escribe un mensaje...">
                <button >&#9206</button>
            </div>
        </section>
        
        <form class="chat-container hide" id="create-group-container">
            <div class="chat-header" id="header-createGC">
                <input type="text" placeholder="Escribir nombre del grupo:" id="input-group-name">
            </div>
            
            <div class="chat-box" id="members-box">
                <input class="buscador_para_invitar" id="buscador_para_invitar" placeholder="Buscar contacto:">
                <div class="invitar_contactos_container" id="invitar_contactos_container">
                    <div class="contacto_a_invitar_container" data-contacto="Sebas">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado"> Jesus Sebastian</div>
                    </div>
                    <div class="contacto_a_invitar_container" data-contacto="Grecia">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Grecia</div>
                    </div>
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>       
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
                    <div class="contacto_a_invitar_container" data-contacto="Mercy">
                        <img src="CSS/img/avatar2.png" class="imgcontacto">
                        <div class="nombreinvitado">Mercy</div>
                    </div>                                                        
            
                </div>
            </div>
            <div class="botonescreaciongpos">
                <button id="btn_aceptar">Aceptar</button>
                <button id="btn_cancelargpo">Cancelar</button>

            </div>
        </form>

    </div>

    <script >
        // Datos de ejemplo de los grupos
        const grupos = {
            grupo1: { nombre: "⚡ Grupo 1", miembros: "Ana, Carlos, David" },
            grupo2: { nombre: "🔥 Grupo 2", miembros: "Sofía, Marcos, Elena" },
            grupo3: { nombre: "🌎 Grupo 3", miembros: "Luis, Marta, Pedro" }
        };

        // Función para abrir el chat de un grupo
        function openChat(grupo) {
            document.getElementById("group-name").textContent = grupos[grupo].nombre;
            document.getElementById("group-members").textContent = grupos[grupo].miembros;
            document.getElementById("chat-box").innerHTML = "<p>Bienvenido al chat de " + grupos[grupo].nombre + "</p>";
        }

        //PARA OCULTAR Y MOSTRAR LO DE CREACION DE GRUPOS
        const chatcontainerCB = document.getElementById('chat-container-CB');
        const btn_creargrupo = document.getElementById('btn_creargrupo');
        const creategroupcontainer = document.getElementById('create-group-container');
        const btn_cancelargpo = document.getElementById('btn_cancelargpo');
        const contacto_a_invitar_container = document.querySelectorAll('.contacto_a_invitar_container');
        const btn_aceptar = document.getElementById('btn_aceptar');
        
        btn_creargrupo.addEventListener('click',(e)=>{
            e.preventDefault();
            mostrargroupcontainer();
        });
        btn_cancelargpo.addEventListener('click',(e)=>{
            e.preventDefault();
            ocultargroupcontainer();
            quitar_seleccionado();
        });
        
        btn_aceptar.addEventListener('click', function(e) {
            e.preventDefault();
            const groupNameInput = document.getElementById('input-group-name');
            const groupName = groupNameInput.value.trim();
            
            if (groupName !== '') {
                // Obtener solo los contactos seleccionados
                const selectedDivs = document.querySelectorAll('.contacto_seleccionado');
                const contactos = [];

                selectedDivs.forEach(div => {
                    const contactoNombre = div.dataset.contacto;
                    if (contactoNombre) {
                        contactos.push(contactoNombre);
                    }
                });

                // Crear un nuevo elemento de lista para el grupo
                const newListItem = document.createElement('li');
                newListItem.textContent = `🆕 ${groupName}`;
                newListItem.onclick = function() { openChat(groupName.toLowerCase().replace(/\s+/g, '')); };

                const groupList = document.querySelector('.group-list ul');
                groupList.appendChild(newListItem);

                // Actualizar el objeto de grupos
                grupos[groupName.toLowerCase().replace(/\s+/g, '')] = { 
                    nombre: `🆕 ${groupName}`, 
                    miembros: contactos.join(', ') 
                };

                // Limpiar el campo de entrada y volver al chat principal
                groupNameInput.value = '';
                ocultargroupcontainer();    
                quitar_seleccionado();           
            } else {
                alert('Por favor, introduce un nombre para el grupo.');
            }
        });

        // LE CAMBIA EL COLOR A CADA UNO DE LOS DIVS SELECCIONADOS POR SEPARADO
        contacto_a_invitar_container.forEach(contacto_a_invitar_containers => {
            contacto_a_invitar_containers.addEventListener('click', function() {
            this.classList.toggle('contacto_seleccionado');
        });
        });

        function quitar_seleccionado(){
            contacto_a_invitar_container.forEach(contacto=>{
            if(contacto.classList.contains('contacto_seleccionado')){
                contacto.classList.remove('contacto_seleccionado');
            }
        });

        }
        function mostrargroupcontainer(){
            if (chatcontainerCB.classList.contains('show')) {
                chatcontainerCB.classList.remove('show');
                chatcontainerCB.classList.add('hide');
                creategroupcontainer.classList.remove('hide');
                creategroupcontainer.classList.add('show');
            }
        }

        function ocultargroupcontainer(){
            if(creategroupcontainer.classList.contains('show')){
                chatcontainerCB.classList.add('show');
                chatcontainerCB.classList.remove('hide');
                creategroupcontainer.classList.add('hide');
                creategroupcontainer.classList.remove('show');

            }
        }


    </script>

</body>
</html>
