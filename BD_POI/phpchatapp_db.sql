-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-05-2025 a las 19:49:55
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `phpchatapp_db`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `CreateChatsForNewUser` (IN `new_user_id` INT)   BEGIN
    DECLARE existing_user_id INT;
    DECLARE done INT DEFAULT FALSE;
    
    -- Cursor para recorrer todos los usuarios existentes antes del nuevo usuario
    DECLARE user_cursor CURSOR FOR 
    SELECT user_id FROM users WHERE user_id < new_user_id;
    
    -- Manejo de errores del cursor
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    -- Abrir el cursor
    OPEN user_cursor;
    
    -- Recorrer cada usuario existente
    read_loop: LOOP
        FETCH user_cursor INTO existing_user_id;
        
        -- Salir del loop si no hay más usuarios
        IF done THEN 
            LEAVE read_loop;
        END IF;
        
        -- Insertar un nuevo chat solo si no existe
        IF NOT EXISTS (
            SELECT 1 FROM chat WHERE (user_id1 = existing_user_id AND user_id2 = new_user_id) 
                                 OR (user_id1 = new_user_id AND user_id2 = existing_user_id)
        ) THEN
            INSERT INTO chat (DateLastMessage, DateCreation, user_id1, user_id2)
            VALUES (NULL, NOW(), existing_user_id, new_user_id);
        END IF;
        
    END LOOP;

    -- Cerrar el cursor
    CLOSE user_cursor;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `FillChatTable` ()   BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE user1 INT;
    DECLARE user2 INT;

    -- Cursor para recorrer todas las combinaciones únicas de usuarios
    DECLARE user_cursor CURSOR FOR 
    SELECT u1.user_id, u2.user_id 
    FROM users u1 
    JOIN users u2 ON u1.user_id < u2.user_id;  -- Solo crea (1,2), no (2,1)

    -- Manejo de errores para el cursor
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    -- Abrir el cursor
    OPEN user_cursor;

    read_loop: LOOP
        FETCH user_cursor INTO user1, user2;

        -- Si no hay más datos, salir del loop
        IF done THEN 
            LEAVE read_loop;
        END IF;

        -- Insertar en la tabla chat solo si no existe
        IF NOT EXISTS (
            SELECT 1 FROM chat WHERE (user_id1 = user1 AND user_id2 = user2) OR (user_id1 = user2 AND user_id2 = user1)
        ) THEN
            INSERT INTO chat (DateLastMessage, DateCreation, user_id1, user_id2)
            VALUES (NULL, NOW(), user1, user2);
        END IF;

    END LOOP;

    -- Cerrar el cursor
    CLOSE user_cursor;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat`
--

CREATE TABLE `chat` (
  `chat_id` int(11) NOT NULL,
  `DateLastMessage` timestamp NULL DEFAULT NULL,
  `DateCreation` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id1` int(11) NOT NULL,
  `user_id2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `chat`
--

INSERT INTO `chat` (`chat_id`, `DateLastMessage`, `DateCreation`, `user_id1`, `user_id2`) VALUES
(1, NULL, '2025-03-31 00:27:20', 1, 2),
(2, NULL, '2025-03-31 00:27:20', 1, 3),
(3, NULL, '2025-03-31 00:27:20', 1, 4),
(4, NULL, '2025-03-31 00:27:20', 2, 3),
(5, NULL, '2025-03-31 00:27:20', 2, 4),
(6, NULL, '2025-03-31 00:27:20', 3, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `date_sent` timestamp NOT NULL DEFAULT current_timestamp(),
  `chat_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `messages`
--

INSERT INTO `messages` (`message_id`, `text`, `date_sent`, `chat_id`, `user_id`) VALUES
(1, 'Hola, cómo estás?', '2025-03-31 02:03:29', 1, 1),
(2, 'Bien y tú?', '2025-03-31 02:35:19', 1, 2),
(3, 'Hola', '2025-03-31 08:33:34', 2, 3),
(4, 'Cómo estás?', '2025-03-31 08:33:52', 2, 1),
(5, 'q onda we', '2025-03-31 08:35:32', 6, 3),
(6, 'k paso papi', '2025-03-31 08:39:48', 6, 3),
(7, 'k kieres loco', '2025-03-31 09:09:53', 6, 4),
(8, 'no nada pa', '2025-03-31 09:10:04', 6, 3),
(9, 'apoco sui', '2025-03-31 09:11:06', 6, 4),
(10, 'aaa', '2025-03-31 09:11:08', 6, 4),
(11, 'asdasd', '2025-03-31 09:11:10', 6, 4),
(12, 'abr ora si ya vas a jalar o no', '2025-03-31 09:13:57', 6, 3),
(13, 'a huevo ya jala', '2025-03-31 09:14:01', 6, 3),
(14, 'uwu', '2025-03-31 09:14:02', 6, 3),
(15, 'confirmo', '2025-03-31 09:14:11', 2, 1),
(16, 'ajas apoco si me lo pones todo mal apa', '2025-03-31 09:14:38', 6, 3),
(17, 'acaray', '2025-03-31 09:14:56', 6, 3),
(18, 'dejo de jalar', '2025-03-31 09:14:59', 6, 3),
(19, 'k we', '2025-03-31 09:17:52', 6, 3),
(20, 'aa', '2025-03-31 09:18:21', 6, 3),
(21, 'asdasdasd', '2025-03-31 09:19:27', 6, 3),
(22, 'abr', '2025-03-31 09:25:14', 6, 3),
(23, 'ola', '2025-03-31 09:25:18', 6, 4),
(24, 'ola si', '2025-03-31 09:25:54', 2, 1),
(25, 'ah ya jala', '2025-03-31 09:26:00', 2, 3),
(26, 'sisi ya jala', '2025-03-31 09:26:52', 2, 1),
(27, 'q genial', '2025-03-31 09:26:54', 2, 1),
(28, 'por fin', '2025-03-31 09:26:56', 2, 1),
(29, 'abr', '2025-03-31 09:31:24', 2, 3),
(30, 'waos', '2025-03-31 09:31:52', 2, 1),
(31, 'intentemos de nuez', '2025-03-31 09:32:05', 2, 3),
(32, 'yeee', '2025-03-31 09:32:07', 2, 3),
(33, 'siiiii ya jala', '2025-03-31 09:32:11', 2, 1),
(34, ';-;', '2025-03-31 09:32:13', 2, 1),
(35, 'vamos a probar con este chat', '2025-04-01 00:17:05', 1, 1),
(36, 'si funciiona', '2025-04-01 00:17:10', 1, 2),
(37, 'Vamos ahora a probar con samu y grecia', '2025-04-01 00:17:41', 3, 4),
(38, 'se tardo un poco pero ya aparecio', '2025-04-01 00:18:31', 3, 4),
(39, 'Efectivamente ya jalo', '2025-04-01 00:18:37', 3, 1),
(40, 'Ahora vamos a probar con Samu y Sebas', '2025-04-01 00:19:40', 5, 4),
(41, 'vamos a ver si jala con el tiempo real', '2025-04-01 00:20:09', 5, 2),
(42, 'si jala', '2025-04-01 00:20:11', 5, 2),
(43, 'y por ultimo vamos a probar con Raziel y Sebas', '2025-04-01 00:21:21', 4, 3),
(44, 'Funciona a la perfección', '2025-04-01 00:21:28', 4, 2),
(45, 'hola', '2025-04-01 01:11:05', 4, 3),
(46, 'como estas', '2025-04-01 01:11:11', 4, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `unique_id` varchar(255) DEFAULT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL COMMENT 'Offline now, Online',
  `cr_date` datetime NOT NULL DEFAULT current_timestamp(),
  `connected` enum('ONLINE','OFFLINE') DEFAULT 'OFFLINE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `unique_id`, `fname`, `lname`, `email`, `password`, `img`, `status`, `cr_date`, `connected`) VALUES
(1, '67e708bb53da9', 'Grecia', 'Segovia', 'marlen777875@gmail.com', '$2y$10$RJqxExMgAvnABI/B1KM67uwXxYzzVgrruoflYc9XLVu09Ga2SWJKS', 'CSS/img/Perfiles/IMG_67e708bb53dcd6.66285135.png', 'Activo', '2025-03-28 21:38:19', 'OFFLINE'),
(2, '67e7092f178f9', 'Sedas', 'tian', 'Seb@gmail.com', '$2y$10$vHoydy1eflEnB2c3rM7G0OrgQQ5US57TuqtiFZ/iV7qZ4wKEYPhUa', 'CSS/img/Perfiles/IMG_67e7092f179161.50959964.png', 'Activo', '2025-03-28 21:40:15', 'ONLINE'),
(3, '67e867daab00c', 'Carlos Raziel', 'Leal Pérez', 'raziel@outlook.com', '$2y$10$PIJ5hZT1MRtp00uJLeI7l..adJ91KL1251mwLNSZ0vJfKhbMhN.9e', 'CSS/img/Perfiles/IMG_67e867daab0232.58365029.png', 'Activo', '2025-03-29 22:36:26', 'ONLINE'),
(4, '67e8b52776a6f', 'Samuel', 'Quintero', 'samu@gmail.com', '$2y$10$hWqHeqWf4iBZRKC5dj1WWeHiCbSZMJgyDAhS/KgDXKhPo4ZxDF2Hi', 'CSS/img/Perfiles/IMG_67e8b52776a807.76421146.jpg', 'Activo', '2025-03-30 05:06:15', 'OFFLINE');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chat_id`),
  ADD KEY `user_id1` (`user_id1`),
  ADD KEY `user_id2` (`user_id2`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `fk_chat_id` (`chat_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `chat`
--
ALTER TABLE `chat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`user_id1`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`user_id2`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_chat_id` FOREIGN KEY (`chat_id`) REFERENCES `chat` (`chat_id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
