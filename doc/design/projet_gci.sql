-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : lun. 22 nov. 2021 à 09:49
-- Version du serveur :  10.5.4-MariaDB
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_gci`
--

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(14) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `account`
--

INSERT INTO `account` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `password`) VALUES
(1, 'Charlotte', 'Lemarchand', 'charlottelemarchand.tcesolar@gmail.com', '07 67 48 81 69', ''),
(2, 'Patrick', 'Kerneis', 'kerneis.patrick@neuf.fr', '06 63 90 09 48', ''),
(3, 'Tristan', 'Combres', 'tristan.dumard@gmail.com', '', ''),
(4, 'Céline', 'Kerbiniou', 'celine.kerbiniou@gmail.com', '', ''),
(5, 'Olivier', 'Cardin', '', '', ''),
(6, 'Emmanuel', 'Guay', 'emmanuel.guay@outlook.fr', '07 67 67 95 33', '');

-- --------------------------------------------------------

--
-- Structure de la table `offer`
--

DROP TABLE IF EXISTS `offer`;
CREATE TABLE IF NOT EXISTS `offer` (
  `id` int(11) NOT NULL,
  `writer_id` int(11) NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date_creation` datetime DEFAULT NULL,
  `date_current` datetime DEFAULT NULL,
  `date_obsolescence` datetime DEFAULT NULL,
  `zone` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `offer`
--

INSERT INTO `offer` (`id`, `writer_id`, `content`, `date_creation`, `date_current`, `date_obsolescence`, `zone`, `type`) VALUES
(1, 1, 'Bonjour,\r\n\r\n			Je me permets de vous contacter car je cherche à participer à des régates. J\'ai vu sur le site de la FFV que la Solo Duo 4 est organisée le 3 octobre prochain à Brest. \r\n			Si vous pensez que certains bateaux pourraient être intéressés par une équipière, pourriez vous nous mettre en relation, ou diffuser mon message ? \r\n\r\n			Ci dessous un petit mot pour me présenter. \r\n			Je fais de la voile depuis une dizaine d\'année, pourtant j\'ai découvert le monde de la régate il y a quelques mois seulement, en Méditerranée ; 3 régates à mon actif pour l\'instant, sur différents supports ( mini 6.50, challenger scout).\r\n			Je suis monitrice croisière, et depuis mon retour de voyage - à la voile toujours - j\'aspire à en faire mon métier.  à faire de reviens d\'un voyage de 1 an en grande croisière, et je souhaite aujourd\'hui en faire mon métier. Je suis en pleine reconversion professionnelle. \r\n\r\n			Je suis licenciée FFV 2020, j\'ai un certificat médical (compétition) qui est associé à mon numéro de licence en ligne. \r\n			Dynamique et volontaire, je suis polyvalente à tous les postes. J\'attends avec impatience les prochaines courses.\r\n			Vous pouvez me contacter par téléphone au 07 67 48 81 69 ou par email charlottelemarchand.tcesolar@gmail.com pour en discuter.\r\n\r\n			En vous remerciant d\'avance.\r\n			Cordialement, \r\n\r\n			Charlotte Lemarchand', '2020-09-20 19:52:00', NULL, NULL, 'to_validate', 'crew'),
(2, 2, 'recherche au moins 2-3 équipiers avec expériences\r\n			pour la dernière régate de la saison de dimanche 14/11\r\n			pour La Trimaran, sur J92.', '2021-11-08 09:48:00', NULL, NULL, 'to_validate', 'skipper'),
(3, 2, 'recherche 3 équipiers avec licence FFV.\r\n			Pour la régate, Challenge d\'Automne, Trophée SNSM du WE prochain.\r\n			Il est possible de prendre des licences temporaires si vous n\'en avez pas.', '2021-10-27 14:18:00', NULL, NULL, 'to_validate', 'skipper'),
(4, 3, 'Bonjour, et merci pour l\'ajout.\r\n			Je suis à la recherche d\'un embarquement pour de la régate.\r\n			J\'ai régaté en J80 et Sun Fast 30 (barre, GV, embraque), en 6M Class\r\n			et en voile légère. Je suis en reprise après 3 années de pause,\r\n			consacrées au plaisir de la plaisance sur mon bateau personnel,\r\n			mais j\'ai envie de retrouver le frisson de la ligne de départ\r\n			des envois de spi !\r\n			\r\n			Un peu rouillé mais super motivé donc. Je suis joignable en MP à\r\n			toute heure.\r\n			\r\n			Bonne journée et merci d\'avance', '2021-10-19 10:06:00', NULL, NULL, 'to_validate', 'crew'),
(5, 4, 'Bonjour tout le monde, je recherche une place d\'équipière\r\n			sur un  monocoque pour naviguer cet hiver. Balade, régate et/ou\r\n			hauturier. Monitrice d\'habitable (pur produit Glénans), CRR et\r\n			permis hauturier. L\'idée serait plus de faire de l\'hauturier pour\r\n			augmenter mon expérience mais je suis partante pour tout!\r\n\r\n			A bientôt!', '2021-10-18 09:29:00', NULL, NULL, 'to_validate', 'crew'),
(6, 5, 'Bonjour, je suis à la recherche d\'un équipier pour la 4 vents Cup prévue ce week-end.\r\n\r\n			Le bateau : un surprise, \r\n			L\'équipage actuel : 3 enfants de 10 à 15 ans et moi.\r\n\r\n			Si vous êtes intéressé ...', '2021-06-17 10:00:00', NULL, NULL, 'to_validate', 'skipper'),
(7, 6, 'Bonjour,\r\n\r\n			J\'habite à Brest, j\'ai un bon niveau en voile habitable et souhaiterait participer à des entraînements et régates en habitable.\r\n\r\n			Avez-vous une bourse des équipiers pour trouver un embarquement ?\r\n\r\n			Bien cordialement\r\n\r\n			Emmanuel Guay', '2021-05-02 10:37:00', NULL, NULL, 'to_validate', 'crew');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `description`) VALUES
(1, 'admin'),
(2, 'responsable'),
(3, 'skipper'),
(4, 'crew');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
