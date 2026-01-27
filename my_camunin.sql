-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 23, 2026 alle 14:56
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_camunin`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `altastagione`
--

CREATE TABLE `altastagione` (
  `id` int(11) NOT NULL,
  `descrizione` varchar(255) NOT NULL,
  `prezzo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `altastagione`
--

INSERT INTO `altastagione` (`id`, `descrizione`, `prezzo`) VALUES
(1, 'camera 1', '3'),
(2, 'camera tripla', '5');

-- --------------------------------------------------------

--
-- Struttura della tabella `bassastagione`
--

CREATE TABLE `bassastagione` (
  `id` int(11) NOT NULL,
  `descrizione` varchar(255) NOT NULL,
  `prezzo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `bassastagione`
--

INSERT INTO `bassastagione` (`id`, `descrizione`, `prezzo`) VALUES
(1, 'camera settupla', '9');

-- --------------------------------------------------------

--
-- Struttura della tabella `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `login`
--

INSERT INTO `login` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$/nWZoCURJ8RiNUhtSR2b.eA93m3cI/kQZHQk4rJGfksHfQaJW0Dpm');

-- --------------------------------------------------------

--
-- Struttura della tabella `onlinelistino`
--

CREATE TABLE `onlinelistino` (
  `id` int(11) NOT NULL,
  `online` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `onlinelistino`
--

INSERT INTO `onlinelistino` (`id`, `online`) VALUES
(1, 'si');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `altastagione`
--
ALTER TABLE `altastagione`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `bassastagione`
--
ALTER TABLE `bassastagione`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `onlinelistino`
--
ALTER TABLE `onlinelistino`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `altastagione`
--
ALTER TABLE `altastagione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `bassastagione`
--
ALTER TABLE `bassastagione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `onlinelistino`
--
ALTER TABLE `onlinelistino`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
