-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 17 Maj 2023, 20:00
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `gamehub.pl`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `achievements`
--

CREATE TABLE `achievements` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `level` enum('bronze','silver','gold','platinum') NOT NULL,
  `category` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `achievements`
--

INSERT INTO `achievements` (`id`, `name`, `description`, `level`, `category`) VALUES
(1, 'Mam na imię...', 'Ustaw swój nick', 'bronze', 'Konto'),
(2, 'Ja tak nie wyglądam!', 'Zmień swój awatar', 'bronze', 'Konto'),
(3, 'Uwielbiam ten kolor!', 'Zmień swój kolor główny w grach', 'bronze', 'Konto'),
(4, 'Ten kolor też lubię', 'Zmień swój kolor alternatywny w grach', 'bronze', 'Konto'),
(5, 'To już rok', 'Posiadaj konto rok, lub dłużej', 'bronze', 'Konto'),
(6, 'Ale długi!', 'Zdobądź przynajmniej 30 punktów w grze Snake', 'bronze', 'Gry - Snake'),
(7, 'Jeszcze dłuższy', 'Zdobądź przynajmniej 70 punktów w grze Snake', 'bronze', 'Gry - Snake'),
(8, 'Wzloty i upadki', 'Wygraj i przegraj w grze Pong 10 razy', 'bronze', 'Gry - Pong'),
(9, 'Równi sobie', 'Zremisuj w grze Pong 10 razy', 'bronze', 'Gry - Pong');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `collected_achievements`
--

CREATE TABLE `collected_achievements` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `achievement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `collected_achievements`
--

INSERT INTO `collected_achievements` (`id`, `user_id`, `achievement_id`) VALUES
(19, 2, 2),
(20, 2, 1),
(21, 2, 3),
(22, 2, 4),
(23, 3, 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pong_scoreboard`
--

CREATE TABLE `pong_scoreboard` (
  `id` int(11) NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `win_count` int(11) DEFAULT 0,
  `loose_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `pong_scoreboard`
--

INSERT INTO `pong_scoreboard` (`id`, `player_id`, `win_count`, `loose_count`) VALUES
(2, 2, 0, 0),
(3, 3, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `snake_scoreboard`
--

CREATE TABLE `snake_scoreboard` (
  `id` int(11) NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `games_played` int(11) DEFAULT 0,
  `max_score` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `snake_scoreboard`
--

INSERT INTO `snake_scoreboard` (`id`, `player_id`, `games_played`, `max_score`) VALUES
(2, 2, 1, 50),
(3, 3, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tic_tac_toe_scoreboard`
--

CREATE TABLE `tic_tac_toe_scoreboard` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `win_count` int(11) NOT NULL DEFAULT 0,
  `loose_count` int(11) NOT NULL DEFAULT 0,
  `tie_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `tic_tac_toe_scoreboard`
--

INSERT INTO `tic_tac_toe_scoreboard` (`id`, `player_id`, `win_count`, `loose_count`, `tie_count`) VALUES
(2, 2, 17, 5, 3),
(3, 3, 0, 9999, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `e-mail` text NOT NULL,
  `password` text NOT NULL,
  `show_name` varchar(13) DEFAULT NULL,
  `avatar` int(11) NOT NULL DEFAULT 0,
  `color` varchar(7) NOT NULL DEFAULT '#0ff',
  `alternative_color` varchar(7) NOT NULL DEFAULT '#f00',
  `register_date` date NOT NULL,
  `e-mail_confirmed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `e-mail`, `password`, `show_name`, `avatar`, `color`, `alternative_color`, `register_date`, `e-mail_confirmed`) VALUES
(2, 'raksoorigami@onet.pl', 'c56a29653588495daefe7c1cb7806a87', 'BushiLamber', 3, '#f00', '#ff0', '2023-05-08', 1),
(3, 'aaaa.@aa.aa', 'e219b56989281a7846dd836161d7a2bd', 'player_3', 0, '#ffa31a', '#f00', '2023-05-12', 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `collected_achievements`
--
ALTER TABLE `collected_achievements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `achievement_id` (`achievement_id`);

--
-- Indeksy dla tabeli `pong_scoreboard`
--
ALTER TABLE `pong_scoreboard`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_id` (`player_id`);

--
-- Indeksy dla tabeli `snake_scoreboard`
--
ALTER TABLE `snake_scoreboard`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_id` (`player_id`);

--
-- Indeksy dla tabeli `tic_tac_toe_scoreboard`
--
ALTER TABLE `tic_tac_toe_scoreboard`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_id` (`player_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `collected_achievements`
--
ALTER TABLE `collected_achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT dla tabeli `pong_scoreboard`
--
ALTER TABLE `pong_scoreboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `snake_scoreboard`
--
ALTER TABLE `snake_scoreboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `tic_tac_toe_scoreboard`
--
ALTER TABLE `tic_tac_toe_scoreboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `collected_achievements`
--
ALTER TABLE `collected_achievements`
  ADD CONSTRAINT `collected_achievements_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `collected_achievements_ibfk_2` FOREIGN KEY (`achievement_id`) REFERENCES `achievements` (`id`);

--
-- Ograniczenia dla tabeli `pong_scoreboard`
--
ALTER TABLE `pong_scoreboard`
  ADD CONSTRAINT `pong_scoreboard_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `snake_scoreboard`
--
ALTER TABLE `snake_scoreboard`
  ADD CONSTRAINT `snake_scoreboard_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `tic_tac_toe_scoreboard`
--
ALTER TABLE `tic_tac_toe_scoreboard`
  ADD CONSTRAINT `tic_tac_toe_scoreboard_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
