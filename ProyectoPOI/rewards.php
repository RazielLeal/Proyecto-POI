<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recompensas</title>
    <link rel="stylesheet" href="CSS/rewards.css">
    <link rel="stylesheet" href="CSS/general.css">
</head>
<body>
    <header>
        <nav>
            <h1>Nombre o logo</h1>
            <div class = "navegation_bar">
                <a href="chat_priv.php" class = "tag-width"></a>
                <a href="chat_group.php" class = "tag-width"></a>
                <a href="tasks.php" class = "tag-width"></a>
                <!-- rewards -->
                <a href="" class = "tag-width"></a>
                <a href="settings.php" class = "tag-width"></a>
                <a href="logout.php" class = "tag-width"></a>
            </div>

            <img src="CSS/img/avatar.png" alt="Avatar" class="avatar">
        </nav>
    </header>
    
    <br><br><br><br>
    <h1>🎁 ¡Descubre tu Recompensa Pokémon! 🎁</h1>
    <p id="points-container">Puntos: <span id="points">200</span></p>
    <div class="grid-container" id="rewardGrid"></div>
    <p id="error-message">🚫 No tienes suficientes puntos para voltear cartas 🚫</p>

    <!-- Audio para el efecto de volteo -->
    <audio id="flipSound" src="/CSS/audio/page-flip.mp3"></audio>

    <!-- Audio para el efecto de error -->
    <audio id="errorSound" src="/CSS/audio/error-sound.mp3"></audio>

    <script>
        const pokemonCards = [
            "https://images.pokemontcg.io/swsh4/25_hires.png",
            "https://images.pokemontcg.io/swsh3/50_hires.png",
            "https://images.pokemontcg.io/swsh1/59_hires.png",
            "https://images.pokemontcg.io/swsh2/23_hires.png",
            "https://images.pokemontcg.io/swsh5/75_hires.png",
            "https://images.pokemontcg.io/swsh6/110_hires.png",
            "https://images.pokemontcg.io/swsh7/129_hires.png",
            "https://images.pokemontcg.io/swsh8/174_hires.png"
        ];

        let points = 200; // Puntos iniciales
        const cardCost = 100; // Costo de cada carta

        function createRewardGrid() {
            const grid = document.getElementById("rewardGrid");

            for (let i = 0; i < 8; i++) {
                const card = document.createElement("div");
                card.classList.add("card");

                const cardInner = document.createElement("div");
                cardInner.classList.add("card-inner");

                const cardFront = document.createElement("div");
                cardFront.classList.add("card-front");
                cardFront.innerHTML = "🎁 <br> 100";

                const cardBack = document.createElement("div");
                cardBack.classList.add("card-back");

                const img = document.createElement("img");
                img.src = pokemonCards[i % pokemonCards.length]; // Asigna una carta aleatoria
                cardBack.appendChild(img);

                cardInner.appendChild(cardFront);
                cardInner.appendChild(cardBack);
                card.appendChild(cardInner);

                card.addEventListener("click", () => {
                    if (points >= cardCost && !card.classList.contains("flipped")) {
                        card.classList.add("flipped");
                        points -= cardCost;

                        // Reproducir sonido
                        document.getElementById("flipSound").play();

                        // Actualizar puntos en pantalla
                        document.getElementById("points").textContent = points;

                        // Ocultar mensaje de error si tenía insuficientes puntos antes
                        document.getElementById("error-message").style.display = "none";
                    } else if (points < cardCost) {
                        // Mostrar mensaje de error
                        document.getElementById("error-message").style.display = "block";

                        // Reproducir sonido
                        document.getElementById("errorSound").play();


                    }
                });

                grid.appendChild(card);
            }
        }

        createRewardGrid();
    </script>

    
</body>
</html>