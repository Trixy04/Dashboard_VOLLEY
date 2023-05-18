-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Creato il: Mag 05, 2023 alle 22:16
-- Versione del server: 5.7.34
-- Versione PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Admin_Panel`
--
CREATE DATABASE IF NOT EXISTS `Admin_Panel` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `Admin_Panel`;

-- --------------------------------------------------------

--
-- Struttura della tabella `agenda`
--

DROP TABLE IF EXISTS `agenda`;
CREATE TABLE `agenda` (
  `id` int(11) NOT NULL,
  `dataIns` date NOT NULL,
  `dataScad` date NOT NULL,
  `textMess` text NOT NULL,
  `autore` text NOT NULL,
  `titolo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `agenda`
--

INSERT INTO `agenda` (`id`, `dataIns`, `dataScad`, `textMess`, `autore`, `titolo`) VALUES
(8, '2023-03-31', '2023-04-09', 'prova', 'Prova Root', 'prova'),
(9, '2023-03-31', '2023-04-09', 'dsda', 'Prova Root', 'prova 2'),
(10, '2023-03-31', '2023-04-02', 'prova 3', 'Prova Root', 'prova 3'),
(11, '2023-03-31', '2023-05-07', 'prova 4', 'Prova Root', 'prova 4'),
(12, '2023-03-31', '2023-03-02', 'ffsfds', 'Prova Root', 'fds'),
(13, '2023-03-31', '2023-04-01', 'prova 5', 'Prova Root', 'prova 5'),
(14, '2023-03-31', '2023-04-02', 'prova 6', 'Prova Root', 'prova 6'),
(15, '2023-03-31', '2023-04-04', 'prova 7', 'Prova Root', 'prova 7'),
(16, '2023-04-03', '2023-04-04', 'jbdakbjkdfask', 'Rocchini Alessia', 'Consegnare foglio'),
(17, '2023-04-03', '2023-04-03', 'Scadenza oggi', 'Rocchini Alessia', 'Scadenza oggi'),
(18, '2023-04-03', '2023-04-03', 'cca', 'Rocchini Alessia', 'Ciao a tutti'),
(19, '2023-04-03', '2023-04-05', 'kfdanfdlsfn', 'Prova Root', 'Prova scadenza'),
(20, '2023-04-11', '2023-04-11', 'Prova', 'Prova Root', 'Prova Scadenza'),
(21, '2023-04-18', '2023-04-18', 'Prova scadenza', 'Prova Root', 'Prova Scadenza'),
(22, '2023-04-19', '2023-04-19', 'ottria gay', 'Prova Root', 'Prova scadenza'),
(23, '2023-04-19', '2023-04-20', 'ottria gay', 'Prova Root', 'prova'),
(24, '2023-04-19', '2023-04-19', 'ottrria gay', 'Vinari Daniel', 'prova'),
(25, '2023-05-05', '2023-05-06', 'Prova Prova', 'Prova Root', 'Prova nuova'),
(26, '2023-05-05', '2023-05-05', 'Prova Scadenza', 'Prova Root', 'Prova Scadenza');

-- --------------------------------------------------------

--
-- Struttura della tabella `allena`
--

DROP TABLE IF EXISTS `allena`;
CREATE TABLE `allena` (
  `id_squadra` int(11) NOT NULL,
  `id_allenatore` int(11) NOT NULL,
  `id_qualifica` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `allena`
--

INSERT INTO `allena` (`id_squadra`, `id_allenatore`, `id_qualifica`) VALUES
(6, 1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `allenatore`
--

DROP TABLE IF EXISTS `allenatore`;
CREATE TABLE `allenatore` (
  `id` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_cartellino` int(11) NOT NULL,
  `smartCoach` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `allenatore`
--

INSERT INTO `allenatore` (`id`, `id_persona`, `id_cartellino`, `smartCoach`) VALUES
(1, 3, 1, 1),
(4, 14, 5, 0),
(5, 15, 6, 1),
(6, 1, 7, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `campionato`
--

DROP TABLE IF EXISTS `campionato`;
CREATE TABLE `campionato` (
  `id` int(11) NOT NULL,
  `nome` int(11) NOT NULL,
  `fascia_inizio` int(4) NOT NULL,
  `fascia_fine` int(4) NOT NULL,
  `girone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `cartellino`
--

DROP TABLE IF EXISTS `cartellino`;
CREATE TABLE `cartellino` (
  `id` int(11) NOT NULL,
  `numeroCartellino` varchar(255) NOT NULL,
  `dataScadenza` date NOT NULL,
  `dataRilascio` date NOT NULL,
  `comitatoRilascio` varchar(255) NOT NULL,
  `id_qualifica` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `cartellino`
--

INSERT INTO `cartellino` (`id`, `numeroCartellino`, `dataScadenza`, `dataRilascio`, `comitatoRilascio`, `id_qualifica`) VALUES
(1, '8493204032', '2023-06-09', '2015-07-06', 'Firenze', 4),
(5, '74287342', '2023-05-19', '2015-06-17', 'Roma', 3),
(6, '4329847329', '2023-05-27', '2010-02-11', 'Firenze', 1),
(7, '8450393', '2023-05-13', '2018-03-02', 'Firenze', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `categoria` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `categorie`
--

INSERT INTO `categorie` (`id`, `categoria`) VALUES
(1, 'GIOCATORE'),
(2, 'DIRIGENTE'),
(3, 'ALLENATORE'),
(4, 'PRESIDENTE'),
(5, 'SEGRETERIA'),
(6, 'DIRETTORE TECNICO'),
(7, 'DIRETTORE SPORTIVO'),
(8, 'MEDICO');

-- --------------------------------------------------------

--
-- Struttura della tabella `certificato`
--

DROP TABLE IF EXISTS `certificato`;
CREATE TABLE `certificato` (
  `id` int(11) NOT NULL,
  `numeroCertificato` varchar(255) NOT NULL,
  `dataEsame` date NOT NULL,
  `dataScadenza` date NOT NULL,
  `dottore` varchar(255) NOT NULL,
  `struttura` varchar(255) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `url_docum` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `certificato`
--

INSERT INTO `certificato` (`id`, `numeroCertificato`, `dataEsame`, `dataScadenza`, `dottore`, `struttura`, `id_tipo`, `url_docum`) VALUES
(1, '07625FIWE90', '2023-03-07', '2024-03-07', 'Rossi Alberto', 'Diagnosi in Tempo', 2, NULL),
(6, 'CPA876545', '2022-04-30', '2023-04-30', 'Ruggeri Massimo', 'Careggi', 2, NULL),
(7, 'CFP897391', '2022-11-25', '2023-11-25', 'Bottai', 'Diagnosi in Tempo', 2, NULL),
(8, 'CAP9039183', '2022-12-26', '2023-12-26', 'Rossi Mario', 'Villa Donatello', 2, NULL),
(11, 'CER56371982', '2022-07-06', '2023-07-06', 'Esposito', 'Meyer', 2, NULL),
(14, 'COP8492839', '2022-08-06', '2023-08-06', 'Roasi Antonio', 'Careggi', 1, NULL),
(17, '7843759283', '2021-02-03', '2023-03-11', 'Firenze', '', 1, NULL),
(18, 'OPA748391', '2023-05-04', '2024-05-04', 'Della Rosa', 'Galeotti', 1, NULL),
(19, 'OVE63426482', '2022-05-04', '2023-05-04', 'Della Rosa', 'Galeotti', 1, NULL),
(20, 'OVE63426482', '2022-05-04', '2023-05-04', 'Della Rosa', 'Galeotti', 1, NULL),
(21, 'OVE63426482', '2023-05-03', '2023-05-04', 'Della Rosa', 'Galeotti', 1, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `contatto`
--

DROP TABLE IF EXISTS `contatto`;
CREATE TABLE `contatto` (
  `id` int(11) NOT NULL,
  `prefissoCell` varchar(3) NOT NULL,
  `cellulare` varchar(10) NOT NULL,
  `fisso` varchar(10) DEFAULT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `contatto`
--

INSERT INTO `contatto` (`id`, `prefissoCell`, `cellulare`, `fisso`, `email`) VALUES
(1, '39', '3911803593', NULL, 'teriaca.mattia@gmail.com'),
(3, '39', '3567843211', NULL, 'alex.pinna@virgilio.it'),
(8, '39', '3498765432', NULL, 'sabagabri@gmail.com'),
(9, '39', '3193461673', NULL, 'carminatibern@gmail.com'),
(24, '39', '3456789082', NULL, 'mario.rossi@outlook.com'),
(25, '39', '3897654311', NULL, 'alvarobalda@gmail.com'),
(26, '39', '', NULL, '');

-- --------------------------------------------------------

--
-- Struttura della tabella `dati_fatturazione`
--

DROP TABLE IF EXISTS `dati_fatturazione`;
CREATE TABLE `dati_fatturazione` (
  `id` int(11) NOT NULL,
  `cod_fiscale` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `titolo` int(11) NOT NULL,
  `id_residenza` int(11) NOT NULL,
  `id_contatti` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `dati_fatturazione`
--

INSERT INTO `dati_fatturazione` (`id`, `cod_fiscale`, `cognome`, `nome`, `titolo`, `id_residenza`, `id_contatti`) VALUES
(1, 'TRCMTT04P13D612R', 'Teriaca', ' Mattia', 1, 1, 1),
(5, 'ALVBRD57D98A612E', 'Baldisserotto', 'Alvaro', 7, 23, 25);

-- --------------------------------------------------------

--
-- Struttura della tabella `dati_Societa`
--

DROP TABLE IF EXISTS `dati_Societa`;
CREATE TABLE `dati_Societa` (
  `partita_iva` varchar(11) NOT NULL,
  `nome_legale` varchar(255) NOT NULL,
  `id_contatti` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `dati_Societa`
--

INSERT INTO `dati_Societa` (`partita_iva`, `nome_legale`, `id_contatti`) VALUES
('59218690416', 'Savino del Bene Volley', 100);

-- --------------------------------------------------------

--
-- Struttura della tabella `dirigente`
--

DROP TABLE IF EXISTS `dirigente`;
CREATE TABLE `dirigente` (
  `id` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `codice_tesseramento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `documento`
--

DROP TABLE IF EXISTS `documento`;
CREATE TABLE `documento` (
  `id` int(11) NOT NULL,
  `numero_documento` varchar(255) NOT NULL,
  `id_tipologia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `documento`
--

INSERT INTO `documento` (`id`, `numero_documento`, `id_tipologia`) VALUES
(1, 'CA47678MU', 1),
(2, 'CU8765RI', 1),
(7, 'CI9876UL', 1),
(8, 'AV678983', 2),
(9, 'PA90817391', 3),
(17, 'FI0293810', 4),
(18, 'AU7837IU', 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `fattDatiPersona`
--

DROP TABLE IF EXISTS `fattDatiPersona`;
CREATE TABLE `fattDatiPersona` (
  `id_datiFatt` int(11) NOT NULL,
  `id_personaRiferita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `fattDatiPersona`
--

INSERT INTO `fattDatiPersona` (`id_datiFatt`, `id_personaRiferita`) VALUES
(1, 1),
(1, 3),
(1, 12),
(1, 13),
(1, 15),
(4, 11),
(5, 15);

-- --------------------------------------------------------

--
-- Struttura della tabella `genitore`
--

DROP TABLE IF EXISTS `genitore`;
CREATE TABLE `genitore` (
  `id` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `ruolo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `gioca`
--

DROP TABLE IF EXISTS `gioca`;
CREATE TABLE `gioca` (
  `id_giocatore` int(11) NOT NULL,
  `id_squadra` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `gioca`
--

INSERT INTO `gioca` (`id_giocatore`, `id_squadra`) VALUES
(1, 6),
(7, 8),
(8, 3),
(9, 8),
(15, 8),
(19, 7);

-- --------------------------------------------------------

--
-- Struttura della tabella `giocatore`
--

DROP TABLE IF EXISTS `giocatore`;
CREATE TABLE `giocatore` (
  `id` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_certificato` int(11) NOT NULL,
  `num_maglia` int(2) NOT NULL DEFAULT '0',
  `url_img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `giocatore`
--

INSERT INTO `giocatore` (`id`, `id_persona`, `id_certificato`, `num_maglia`, `url_img`) VALUES
(1, 1, 1, 16, '01'),
(7, 6, 6, 10, NULL),
(8, 7, 7, 59, NULL),
(9, 8, 8, 7, NULL),
(15, 3, 14, 8, NULL),
(19, 15, 21, 21, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `partita`
--

DROP TABLE IF EXISTS `partita`;
CREATE TABLE `partita` (
  `cod_partita` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `orario` time NOT NULL,
  `luogo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `persona`
--

DROP TABLE IF EXISTS `persona`;
CREATE TABLE `persona` (
  `cod_utente` int(11) NOT NULL,
  `cod_fiscale` varchar(16) NOT NULL,
  `cognome` text NOT NULL,
  `nome` text NOT NULL,
  `id_sesso` int(11) NOT NULL,
  `id_titolo` int(11) NOT NULL,
  `data_nascita` date NOT NULL,
  `luogo_nascita` text NOT NULL,
  `provinciaNascita` varchar(2) NOT NULL,
  `dataCreazione` date DEFAULT NULL,
  `id_contatti` int(11) NOT NULL,
  `id_residenza` int(11) NOT NULL,
  `id_documento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `persona`
--

INSERT INTO `persona` (`cod_utente`, `cod_fiscale`, `cognome`, `nome`, `id_sesso`, `id_titolo`, `data_nascita`, `luogo_nascita`, `provinciaNascita`, `dataCreazione`, `id_contatti`, `id_residenza`, `id_documento`) VALUES
(1, 'TRCMTT04P13D612R', 'Teriaca', 'Mattia', 1, 1, '2004-09-13', 'Firenze', 'FI', '2023-04-01', 1, 1, 1),
(3, 'ZLSVCN69L01B573L', 'Pinna', 'Alessandro', 1, 4, '1968-05-01', 'Cagliari', 'CA', '2023-04-14', 3, 2, 2),
(6, 'RSPDYO36C46G086H', 'Della Volpe', 'Ferdinando', 1, 4, '1996-03-19', 'Siena', 'SI', '2023-04-25', 3, 8, 7),
(7, 'HLBWHD62E19L325V', 'Sabatini', 'Gabriele', 1, 1, '2011-11-08', 'Firenze', 'FI', '2023-04-25', 8, 9, 8),
(8, 'CJWTLP82A52E928W', 'Carminati', 'Bernardo', 1, 1, '1997-01-01', 'Firenze', 'FI', '2023-04-26', 9, 10, 9),
(14, 'RSSMAR36C46G086H', 'Rossi', 'Mario', 1, 1, '1999-06-05', 'Roma', 'RM', '2023-05-03', 24, 22, 17),
(15, 'ALVBRD57D98A612E', 'Baldisserotto', 'Alvaro', 1, 7, '1957-09-04', 'Firenze', 'FI', '2023-05-04', 25, 23, 18);

-- --------------------------------------------------------

--
-- Struttura della tabella `qualifica`
--

DROP TABLE IF EXISTS `qualifica`;
CREATE TABLE `qualifica` (
  `id` int(11) NOT NULL,
  `nomeQualifica` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `qualifica`
--

INSERT INTO `qualifica` (`id`, `nomeQualifica`) VALUES
(1, 'I Allenatore'),
(2, 'II Allenatore'),
(3, 'III Allenatore');

-- --------------------------------------------------------

--
-- Struttura della tabella `qualificaFipav`
--

DROP TABLE IF EXISTS `qualificaFipav`;
CREATE TABLE `qualificaFipav` (
  `id` int(11) NOT NULL,
  `qualificaFipav` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `qualificaFipav`
--

INSERT INTO `qualificaFipav` (`id`, `qualificaFipav`) VALUES
(1, 'Allievo Allenatore'),
(2, 'Primo Grado'),
(3, 'Secondo Grado'),
(4, 'Terzo Grado');

-- --------------------------------------------------------

--
-- Struttura della tabella `residenza`
--

DROP TABLE IF EXISTS `residenza`;
CREATE TABLE `residenza` (
  `id` int(11) NOT NULL,
  `id_tipoVia` int(11) NOT NULL,
  `indirizzo` varchar(255) NOT NULL,
  `civico` int(11) NOT NULL,
  `citta` varchar(255) NOT NULL,
  `cap` int(11) NOT NULL,
  `provincia` varchar(2) NOT NULL,
  `nazione` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `residenza`
--

INSERT INTO `residenza` (`id`, `id_tipoVia`, `indirizzo`, `civico`, `citta`, `cap`, `provincia`, `nazione`) VALUES
(1, 1, 'Alfredo Contini', 7, 'Sesto Fiorentino', 50019, 'FI', 'Italia'),
(2, 1, 'Giovanni Battista', 34, 'Sesto Fiorentino', 50019, 'FI', 'Italia'),
(8, 1, 'Trieste', 56, 'Sesto Fiorentino', 50019, 'FI', 'Italia'),
(9, 1, 'Conti Contini', 1, 'Sesto Fiorentino', 50019, 'FI', 'Italia'),
(10, 1, 'Vannino Vannini', 4, 'Sesto Fiorentino', 50019, 'FI', 'Italia'),
(22, 4, 'Cavalieri', 9, 'Roma', 100, 'RM', 'Italia'),
(23, 1, 'Dei Rosi', 4, 'Sesto Fiorentino', 50019, 'FI', 'Italia');

-- --------------------------------------------------------

--
-- Struttura della tabella `sesso`
--

DROP TABLE IF EXISTS `sesso`;
CREATE TABLE `sesso` (
  `id` int(11) NOT NULL,
  `sesso` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `sesso`
--

INSERT INTO `sesso` (`id`, `sesso`) VALUES
(1, 'Maschio'),
(2, 'Femmina');

-- --------------------------------------------------------

--
-- Struttura della tabella `squadra`
--

DROP TABLE IF EXISTS `squadra`;
CREATE TABLE `squadra` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `id_stagioneSportiva` int(11) NOT NULL,
  `id_I_allenatore` int(11) NOT NULL,
  `id_II_allenatore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `squadra`
--

INSERT INTO `squadra` (`id`, `nome`, `id_stagioneSportiva`, `id_I_allenatore`, `id_II_allenatore`) VALUES
(1, 'Volley S3 I livello', 1, 1, 6),
(2, 'Volley S3 II livello', 1, 4, 5),
(3, 'Under 13', 1, 5, 4),
(4, 'Under 15', 1, 6, 1),
(5, 'Under 17', 1, 1, 6),
(6, 'Under 19', 1, 4, 5),
(7, 'Serie D', 1, 5, 4),
(8, 'Serie C', 1, 6, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `stagioniSportive`
--

DROP TABLE IF EXISTS `stagioniSportive`;
CREATE TABLE `stagioniSportive` (
  `id` int(11) NOT NULL,
  `annoInizio` int(4) NOT NULL,
  `annoFine` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `stagioniSportive`
--

INSERT INTO `stagioniSportive` (`id`, `annoInizio`, `annoFine`) VALUES
(1, 2022, 2023);

-- --------------------------------------------------------

--
-- Struttura della tabella `tipologiaDocumento`
--

DROP TABLE IF EXISTS `tipologiaDocumento`;
CREATE TABLE `tipologiaDocumento` (
  `id` int(11) NOT NULL,
  `tipologia` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `tipologiaDocumento`
--

INSERT INTO `tipologiaDocumento` (`id`, `tipologia`) VALUES
(1, 'Carta Identità Digitale'),
(2, 'Carta Identità Cartacea'),
(3, 'Passaporto'),
(4, 'Patente di Guida'),
(5, 'Altro...');

-- --------------------------------------------------------

--
-- Struttura della tabella `tipologieCertificato`
--

DROP TABLE IF EXISTS `tipologieCertificato`;
CREATE TABLE `tipologieCertificato` (
  `id` int(11) NOT NULL,
  `tipologia` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `tipologieCertificato`
--

INSERT INTO `tipologieCertificato` (`id`, `tipologia`) VALUES
(1, 'Agonistico >40'),
(2, 'Agonistico <40'),
(3, 'Non agonistico');

-- --------------------------------------------------------

--
-- Struttura della tabella `tipoVia`
--

DROP TABLE IF EXISTS `tipoVia`;
CREATE TABLE `tipoVia` (
  `id` int(11) NOT NULL,
  `tipologia` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `tipoVia`
--

INSERT INTO `tipoVia` (`id`, `tipologia`) VALUES
(1, 'Via'),
(2, 'Viale'),
(3, 'Piazza'),
(4, 'Largo'),
(5, 'Vicolo');

-- --------------------------------------------------------

--
-- Struttura della tabella `titolo`
--

DROP TABLE IF EXISTS `titolo`;
CREATE TABLE `titolo` (
  `id` int(11) NOT NULL,
  `titolo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `titolo`
--

INSERT INTO `titolo` (`id`, `titolo`) VALUES
(1, 'Sig.'),
(2, 'Sig. ra'),
(3, 'Avv.'),
(4, 'Dott.'),
(5, 'Dr.'),
(6, 'Dott. ssa'),
(7, 'Ing.'),
(8, 'Prof.'),
(9, 'Sig. na');

-- --------------------------------------------------------

--
-- Struttura della tabella `userData`
--

DROP TABLE IF EXISTS `userData`;
CREATE TABLE `userData` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `cognome` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `userData`
--

INSERT INTO `userData` (`id`, `nome`, `cognome`, `email`, `password`) VALUES
(1, 'Root', 'Prova', 'admin@root.com', 'adminRoot'),
(2, 'Daniel', 'Vinari', 'vinaridaniel@gmail.com', 'admin'),
(3, 'Alessia', 'Rocchini', 'alessia.rocchini@gmail.com', 'admin'),
(4, 'Cristiano', 'Nesti', 'nestinazionale@gmail.com', 'NestiTheBest');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `allena`
--
ALTER TABLE `allena`
  ADD PRIMARY KEY (`id_squadra`,`id_allenatore`);

--
-- Indici per le tabelle `allenatore`
--
ALTER TABLE `allenatore`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `campionato`
--
ALTER TABLE `campionato`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `cartellino`
--
ALTER TABLE `cartellino`
  ADD PRIMARY KEY (`id`,`numeroCartellino`);

--
-- Indici per le tabelle `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `certificato`
--
ALTER TABLE `certificato`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `contatto`
--
ALTER TABLE `contatto`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `dati_fatturazione`
--
ALTER TABLE `dati_fatturazione`
  ADD PRIMARY KEY (`id`,`cod_fiscale`);

--
-- Indici per le tabelle `dati_Societa`
--
ALTER TABLE `dati_Societa`
  ADD PRIMARY KEY (`partita_iva`);

--
-- Indici per le tabelle `dirigente`
--
ALTER TABLE `dirigente`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `fattDatiPersona`
--
ALTER TABLE `fattDatiPersona`
  ADD PRIMARY KEY (`id_datiFatt`,`id_personaRiferita`);

--
-- Indici per le tabelle `genitore`
--
ALTER TABLE `genitore`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `gioca`
--
ALTER TABLE `gioca`
  ADD PRIMARY KEY (`id_giocatore`,`id_squadra`);

--
-- Indici per le tabelle `giocatore`
--
ALTER TABLE `giocatore`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `partita`
--
ALTER TABLE `partita`
  ADD PRIMARY KEY (`cod_partita`);

--
-- Indici per le tabelle `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`cod_utente`,`cod_fiscale`);

--
-- Indici per le tabelle `qualifica`
--
ALTER TABLE `qualifica`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `qualificaFipav`
--
ALTER TABLE `qualificaFipav`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `residenza`
--
ALTER TABLE `residenza`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `sesso`
--
ALTER TABLE `sesso`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `squadra`
--
ALTER TABLE `squadra`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `stagioniSportive`
--
ALTER TABLE `stagioniSportive`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `tipologiaDocumento`
--
ALTER TABLE `tipologiaDocumento`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `tipologieCertificato`
--
ALTER TABLE `tipologieCertificato`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `tipoVia`
--
ALTER TABLE `tipoVia`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `titolo`
--
ALTER TABLE `titolo`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `userData`
--
ALTER TABLE `userData`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT per la tabella `allenatore`
--
ALTER TABLE `allenatore`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `campionato`
--
ALTER TABLE `campionato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `cartellino`
--
ALTER TABLE `cartellino`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `certificato`
--
ALTER TABLE `certificato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT per la tabella `contatto`
--
ALTER TABLE `contatto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT per la tabella `dati_fatturazione`
--
ALTER TABLE `dati_fatturazione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `dirigente`
--
ALTER TABLE `dirigente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `documento`
--
ALTER TABLE `documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT per la tabella `genitore`
--
ALTER TABLE `genitore`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `giocatore`
--
ALTER TABLE `giocatore`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT per la tabella `persona`
--
ALTER TABLE `persona`
  MODIFY `cod_utente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT per la tabella `qualifica`
--
ALTER TABLE `qualifica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `qualificaFipav`
--
ALTER TABLE `qualificaFipav`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `residenza`
--
ALTER TABLE `residenza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT per la tabella `sesso`
--
ALTER TABLE `sesso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `squadra`
--
ALTER TABLE `squadra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `stagioniSportive`
--
ALTER TABLE `stagioniSportive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `tipologiaDocumento`
--
ALTER TABLE `tipologiaDocumento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `tipologieCertificato`
--
ALTER TABLE `tipologieCertificato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `tipoVia`
--
ALTER TABLE `tipoVia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `titolo`
--
ALTER TABLE `titolo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `userData`
--
ALTER TABLE `userData`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
