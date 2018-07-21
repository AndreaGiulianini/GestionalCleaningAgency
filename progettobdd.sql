-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Creato il: Giu 24, 2018 alle 14:26
-- Versione del server: 5.7.19
-- Versione PHP: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `progettobdd`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `amministratori`
--

DROP TABLE IF EXISTS `amministratori`;
CREATE TABLE IF NOT EXISTS `amministratori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_bin NOT NULL,
  `cognome` varchar(255) COLLATE utf8_bin NOT NULL,
  `utente` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `utente` (`utente`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `amministratori`
--

INSERT INTO `amministratori` (`id`, `nome`, `cognome`, `utente`) VALUES
(1, 'nomeAdmin', 'cognomeAdmin', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `anagrafica`
--

DROP TABLE IF EXISTS `anagrafica`;
CREATE TABLE IF NOT EXISTS `anagrafica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8_bin NOT NULL,
  `prezzo_vendita` decimal(10,2) DEFAULT NULL,
  `prezzo_acquisto` decimal(10,2) DEFAULT NULL,
  `old` tinyint(1) NOT NULL DEFAULT '0',
  `id_categoria` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `anagrafica`
--

INSERT INTO `anagrafica` (`id`, `nome`, `prezzo_vendita`, `prezzo_acquisto`, `old`, `id_categoria`) VALUES
(1, 'Prodotto1', '15.78', '9.81', 1, 1),
(2, 'Prodotto2', '21.56', '12.32', 0, 2),
(3, 'Prodotto1V2', '21.21', '10.81', 0, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8_bin NOT NULL,
  `descrizione` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`id`, `nome`, `descrizione`) VALUES
(1, 'Sgrassatore', 'Sgrassa'),
(2, 'Disinfettante ', 'Disinfetta');

-- --------------------------------------------------------

--
-- Struttura della tabella `causali`
--

DROP TABLE IF EXISTS `causali`;
CREATE TABLE IF NOT EXISTS `causali` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `causale` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `causali`
--

INSERT INTO `causali` (`id`, `causale`) VALUES
(1, 'Spostamento prodotti');

-- --------------------------------------------------------

--
-- Struttura della tabella `causali_spedizioni`
--

DROP TABLE IF EXISTS `causali_spedizioni`;
CREATE TABLE IF NOT EXISTS `causali_spedizioni` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_spedizione` int(11) NOT NULL,
  `id_causale` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_causale` (`id_causale`),
  KEY `id_spedizione` (`id_spedizione`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `causali_spedizioni`
--

INSERT INTO `causali_spedizioni` (`id`, `id_spedizione`, `id_causale`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `clienti`
--

DROP TABLE IF EXISTS `clienti`;
CREATE TABLE IF NOT EXISTS `clienti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_bin NOT NULL,
  `rag_soc` varchar(255) COLLATE utf8_bin NOT NULL,
  `via` varchar(255) COLLATE utf8_bin NOT NULL,
  `citta` varchar(255) COLLATE utf8_bin NOT NULL,
  `provincia` varchar(20) COLLATE utf8_bin NOT NULL,
  `cap` varchar(20) COLLATE utf8_bin NOT NULL,
  `p_iva` varchar(20) COLLATE utf8_bin NOT NULL,
  `cod_fisc` varchar(20) COLLATE utf8_bin NOT NULL,
  `utente` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `utente` (`utente`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `clienti`
--

INSERT INTO `clienti` (`id`, `nome`, `rag_soc`, `via`, `citta`, `provincia`, `cap`, `p_iva`, `cod_fisc`, `utente`) VALUES
(1, 'nomeCliente', 'SRL', 'Via San Giorgio', 'Cesena', 'FC', '47522', 'BG302929639', 'BPPGLL00A25A944M', 3),
(2, 'nomeCliente2', 'SRL', 'Via San Piero', 'Cesena', 'FC', '47522', 'BG303924635', 'BPPGLL00A15A944M', 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `clienti_esterni`
--

DROP TABLE IF EXISTS `clienti_esterni`;
CREATE TABLE IF NOT EXISTS `clienti_esterni` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_bin NOT NULL,
  `rag_soc` varchar(255) COLLATE utf8_bin NOT NULL,
  `via` varchar(255) COLLATE utf8_bin NOT NULL,
  `citta` varchar(255) COLLATE utf8_bin NOT NULL,
  `provincia` varchar(255) COLLATE utf8_bin NOT NULL,
  `cap` int(11) NOT NULL,
  `p_iva` varchar(255) COLLATE utf8_bin NOT NULL,
  `cod_fisc` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `dipendenti`
--

DROP TABLE IF EXISTS `dipendenti`;
CREATE TABLE IF NOT EXISTS `dipendenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(11) COLLATE utf8_bin NOT NULL,
  `cognome` varchar(11) COLLATE utf8_bin NOT NULL,
  `cod_fisc` varchar(11) COLLATE utf8_bin NOT NULL,
  `utente` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `utente` (`utente`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `dipendenti`
--

INSERT INTO `dipendenti` (`id`, `nome`, `cognome`, `cod_fisc`, `utente`) VALUES
(1, 'nomeDipende', 'cognomeDipe', 'GLNNDR97P25', 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `fatture`
--

DROP TABLE IF EXISTS `fatture`;
CREATE TABLE IF NOT EXISTS `fatture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `aggiunta_numero` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `totale` decimal(10,2) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_cliente_esterno` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cliente_esterno` (`id_cliente_esterno`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `fatture`
--

INSERT INTO `fatture` (`id`, `numero`, `aggiunta_numero`, `totale`, `id_cliente`, `id_cliente_esterno`) VALUES
(1, 1, 'First', '150.00', 1, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `fatture_spedizioni`
--

DROP TABLE IF EXISTS `fatture_spedizioni`;
CREATE TABLE IF NOT EXISTS `fatture_spedizioni` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fattura_id` int(11) NOT NULL,
  `spedizone_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `spedizone_id` (`spedizone_id`),
  KEY `fattura_id` (`fattura_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `fatture_spedizioni`
--

INSERT INTO `fatture_spedizioni` (`id`, `fattura_id`, `spedizone_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `inventario`
--

DROP TABLE IF EXISTS `inventario`;
CREATE TABLE IF NOT EXISTS `inventario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantita` int(11) NOT NULL,
  `id_magazzino` int(11) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_magazzino` (`id_magazzino`),
  KEY `id_prodotto` (`id_prodotto`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `inventario`
--

INSERT INTO `inventario` (`id`, `quantita`, `id_magazzino`, `id_prodotto`) VALUES
(1, 7, 1, 3),
(2, 4, 1, 2),
(3, 3, 2, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `magazzini`
--

DROP TABLE IF EXISTS `magazzini`;
CREATE TABLE IF NOT EXISTS `magazzini` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `descrizione` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `indirizzo` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `utente` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `utente` (`utente`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `magazzini`
--

INSERT INTO `magazzini` (`id`, `nome`, `descrizione`, `indirizzo`, `utente`) VALUES
(1, 'MagazzinoAmministratore', 'Deposito prodotti dell\'azienda di pulizie', 'Via Quercia 33', 1),
(2, 'MagazzinoCliente', 'Magazzino del cliente per tenere i prodotti', 'Via Girolamo 98', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti_in_spedizione`
--

DROP TABLE IF EXISTS `prodotti_in_spedizione`;
CREATE TABLE IF NOT EXISTS `prodotti_in_spedizione` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantita` int(11) NOT NULL,
  `id_spedizione` int(11) NOT NULL,
  `id_anagrafica` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_anagrafica` (`id_anagrafica`),
  KEY `id_spedizione` (`id_spedizione`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `prodotti_in_spedizione`
--

INSERT INTO `prodotti_in_spedizione` (`id`, `quantita`, `id_spedizione`, `id_anagrafica`) VALUES
(1, 3, 1, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `servizi_fattura`
--

DROP TABLE IF EXISTS `servizi_fattura`;
CREATE TABLE IF NOT EXISTS `servizi_fattura` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iva` tinyint(4) NOT NULL,
  `descrizione` varchar(255) COLLATE utf8_bin NOT NULL,
  `prezzo_unitario` decimal(10,2) DEFAULT NULL,
  `quantita` int(11) NOT NULL,
  `data` date NOT NULL,
  `id_fattura` int(11) NOT NULL,
  `id_dipendente` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_fattura` (`id_fattura`),
  KEY `id_dipendente` (`id_dipendente`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `servizi_fattura`
--

INSERT INTO `servizi_fattura` (`id`, `iva`, `descrizione`, `prezzo_unitario`, `quantita`, `data`, `id_fattura`, `id_dipendente`) VALUES
(1, 1, 'Pulizie', '150.00', 1, '2018-07-01', 1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `spedizioni`
--

DROP TABLE IF EXISTS `spedizioni`;
CREATE TABLE IF NOT EXISTS `spedizioni` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `id_provenienza` int(11) NOT NULL,
  `id_destinazione` int(11) NOT NULL,
  `num_bolla` int(11) NOT NULL,
  `data_scadenza` date DEFAULT NULL,
  `eseguita` tinyint(1) NOT NULL DEFAULT '0',
  `fatturata` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_destinazione` (`id_destinazione`),
  KEY `id_provenienza` (`id_provenienza`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `spedizioni`
--

INSERT INTO `spedizioni` (`id`, `data`, `id_provenienza`, `id_destinazione`, `num_bolla`, `data_scadenza`, `eseguita`, `fatturata`) VALUES
(1, '2018-06-23', 1, 2, 1, '2018-06-30', 0, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `spese`
--

DROP TABLE IF EXISTS `spese`;
CREATE TABLE IF NOT EXISTS `spese` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url_fattura` varchar(255) COLLATE utf8_bin NOT NULL,
  `pagata` tinyint(4) NOT NULL,
  `data_scadenza` date NOT NULL,
  `costo` decimal(10,2) DEFAULT NULL,
  `id_magazzino` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_magazzino` (`id_magazzino`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

DROP TABLE IF EXISTS `utenti`;
CREATE TABLE IF NOT EXISTS `utenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ruolo` int(11) NOT NULL,
  `data_login` datetime DEFAULT NULL,
  `data_creazione` datetime NOT NULL,
  `admin_creazione` int(11) NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '/uploads/avatar/db.png',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `username`, `password`, `email`, `ruolo`, `data_login`, `data_creazione`, `admin_creazione`, `foto`) VALUES
(1, 'admin', '$2a$11$onKMTvlLP5Tcy1FXHKop4OAWj.TT2h0CSm/r.FbqqkIt8hxNBoeL6', 'admin@unibo.it', 3, '2018-06-23 15:11:28', '2018-06-23 00:00:00', 1, '/uploads/avatar/db.png'),
(2, 'employee', '$2y$11$3u96sZL.siSLJwnYa4XqjenZ/oh5GkCnG0/jEt91JzWUOX8xdZfIq', 'employee@unibo.it', 1, NULL, '2018-06-23 14:39:37', 1, '/uploads/avatar/db.png'),
(3, 'client', '$2y$11$vfVTQMIrs/oQb68ilafvIOJ509XXSDvi6WU0WlU7Lklt3WOCg7zqq', 'client@unibo.it', 2, '2018-06-23 15:32:55', '2018-06-23 14:56:48', 1, '/uploads/avatar/db.png'),
(4, 'client2', '$2y$11$q.9VPQUVMxIaRX5PdKRituOB7xq8E0c3ECr9Qp3Bx/frSdD7wTvN6', 'client2@unibo.it', 2, NULL, '2018-06-23 14:58:55', 1, '/uploads/avatar/db.png');

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `amministratori`
--
ALTER TABLE `amministratori`
  ADD CONSTRAINT `amministratori_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utenti` (`id`);

--
-- Limiti per la tabella `anagrafica`
--
ALTER TABLE `anagrafica`
  ADD CONSTRAINT `anagrafica_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`);

--
-- Limiti per la tabella `causali_spedizioni`
--
ALTER TABLE `causali_spedizioni`
  ADD CONSTRAINT `causali_spedizioni_ibfk_1` FOREIGN KEY (`id_causale`) REFERENCES `causali` (`id`),
  ADD CONSTRAINT `causali_spedizioni_ibfk_2` FOREIGN KEY (`id_spedizione`) REFERENCES `spedizioni` (`id`);

--
-- Limiti per la tabella `clienti`
--
ALTER TABLE `clienti`
  ADD CONSTRAINT `clienti_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utenti` (`id`);

--
-- Limiti per la tabella `dipendenti`
--
ALTER TABLE `dipendenti`
  ADD CONSTRAINT `dipendenti_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utenti` (`id`);

--
-- Limiti per la tabella `fatture`
--
ALTER TABLE `fatture`
  ADD CONSTRAINT `fatture_ibfk_1` FOREIGN KEY (`id_cliente_esterno`) REFERENCES `clienti_esterni` (`id`),
  ADD CONSTRAINT `fatture_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `clienti` (`id`);

--
-- Limiti per la tabella `fatture_spedizioni`
--
ALTER TABLE `fatture_spedizioni`
  ADD CONSTRAINT `fatture_spedizioni_ibfk_1` FOREIGN KEY (`spedizone_id`) REFERENCES `spedizioni` (`id`),
  ADD CONSTRAINT `fatture_spedizioni_ibfk_2` FOREIGN KEY (`fattura_id`) REFERENCES `fatture` (`id`);

--
-- Limiti per la tabella `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`id_magazzino`) REFERENCES `magazzini` (`id`),
  ADD CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`id_prodotto`) REFERENCES `anagrafica` (`id`);

--
-- Limiti per la tabella `magazzini`
--
ALTER TABLE `magazzini`
  ADD CONSTRAINT `magazzini_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utenti` (`id`);

--
-- Limiti per la tabella `prodotti_in_spedizione`
--
ALTER TABLE `prodotti_in_spedizione`
  ADD CONSTRAINT `prodotti_in_spedizione_ibfk_1` FOREIGN KEY (`id_anagrafica`) REFERENCES `anagrafica` (`id`),
  ADD CONSTRAINT `prodotti_in_spedizione_ibfk_2` FOREIGN KEY (`id_spedizione`) REFERENCES `spedizioni` (`id`);

--
-- Limiti per la tabella `servizi_fattura`
--
ALTER TABLE `servizi_fattura`
  ADD CONSTRAINT `servizi_fattura_ibfk_1` FOREIGN KEY (`id_fattura`) REFERENCES `fatture` (`id`),
  ADD CONSTRAINT `servizi_fattura_ibfk_2` FOREIGN KEY (`id_dipendente`) REFERENCES `dipendenti` (`id`);

--
-- Limiti per la tabella `spedizioni`
--
ALTER TABLE `spedizioni`
  ADD CONSTRAINT `spedizioni_ibfk_1` FOREIGN KEY (`id_destinazione`) REFERENCES `magazzini` (`id`),
  ADD CONSTRAINT `spedizioni_ibfk_2` FOREIGN KEY (`id_provenienza`) REFERENCES `magazzini` (`id`);

--
-- Limiti per la tabella `spese`
--
ALTER TABLE `spese`
  ADD CONSTRAINT `spese_ibfk_1` FOREIGN KEY (`id_magazzino`) REFERENCES `magazzini` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
