-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 22 Octobre 2025 à 19:15
-- Version du serveur :  5.6.20-log
-- Version de PHP :  7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `restocampus`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
`idArticle` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `article`
--

INSERT INTO `article` (`idArticle`, `nom`, `description`) VALUES
(4, 'Salade sandwich', 'dddd'),
(2, 'Salade Poulet', 'Poulet, salade, tomate, maïs ggg'),
(8, 'fff', 'fff');

-- --------------------------------------------------------

--
-- Structure de la table `articledisponible`
--

CREATE TABLE IF NOT EXISTS `articledisponible` (
`idDispo` int(11) NOT NULL,
  `idArticle` int(11) NOT NULL,
  `dateHeureDebut` datetime NOT NULL,
  `dateHeureFin` datetime NOT NULL,
  `quantiteMax` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `articledisponible`
--

INSERT INTO `articledisponible` (`idDispo`, `idArticle`, `dateHeureDebut`, `dateHeureFin`, `quantiteMax`) VALUES
(1, 2, '2025-10-17 11:48:00', '2025-10-20 11:25:00', 2),
(3, 4, '2025-10-17 20:00:00', '2025-10-21 14:14:00', 2),
(4, 5, '2025-10-17 20:05:00', '2025-10-21 22:04:00', 1),
(5, 2, '2025-10-21 19:18:00', '2025-10-26 18:17:00', 7);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE IF NOT EXISTS `commande` (
`idCommande` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `idDispo` int(11) NOT NULL,
  `quantite` int(11) NOT NULL DEFAULT '1',
  `statut` enum('réservée','récupérée','annulée') NOT NULL DEFAULT 'réservée',
  `dateCommande` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `commande`
--

INSERT INTO `commande` (`idCommande`, `idUtilisateur`, `idDispo`, `quantite`, `statut`, `dateCommande`) VALUES
(1, 2, 3, 1, 'récupérée', '2025-10-20 16:03:20'),
(2, 2, 3, 1, 'récupérée', '2025-10-20 16:03:37'),
(3, 2, 4, 1, 'annulée', '2025-10-20 16:03:44'),
(4, 6, 4, 1, 'annulée', '2025-10-20 16:45:25'),
(5, 2, 4, 1, 'annulée', '2025-10-20 19:39:39'),
(6, 2, 4, 1, 'annulée', '2025-10-20 19:43:24'),
(7, 2, 4, 1, 'annulée', '2025-10-20 19:43:59'),
(8, 6, 4, 1, 'annulée', '2025-10-20 19:46:42'),
(9, 6, 4, 1, 'annulée', '2025-10-20 21:44:39'),
(10, 6, 4, 1, 'annulée', '2025-10-21 00:33:10'),
(11, 2, 4, 1, 'récupérée', '2025-10-21 10:43:16'),
(12, 2, 5, 1, 'annulée', '2025-10-22 20:04:14'),
(13, 2, 5, 1, 'annulée', '2025-10-22 20:04:53'),
(14, 2, 5, 1, 'annulée', '2025-10-22 20:06:01'),
(15, 2, 5, 1, 'annulée', '2025-10-22 20:06:14'),
(16, 2, 5, 1, 'annulée', '2025-10-22 20:08:39'),
(17, 2, 5, 1, 'annulée', '2025-10-22 20:13:21'),
(18, 2, 5, 1, 'annulée', '2025-10-22 20:21:50');

-- --------------------------------------------------------

--
-- Structure de la table `ingredient`
--

CREATE TABLE IF NOT EXISTS `ingredient` (
`idIngredient` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text,
  `idArticle` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `ingredient`
--

INSERT INTO `ingredient` (`idIngredient`, `nom`, `description`, `idArticle`) VALUES
(12, '', NULL, 2),
(5, 'dddd', NULL, 4),
(13, 'ffdddd', NULL, 8);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
`idUtilisateur` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `motDePasse` varchar(255) NOT NULL,
  `role` enum('admin','etudiant') NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`idUtilisateur`, `login`, `nom`, `prenom`, `motDePasse`, `role`) VALUES
(1, 'admin', 'Durand', 'Paul', 'admin123', 'admin'),
(2, 'etudiant1', 'Martin', 'Julie', 'azerty', 'etudiant'),
(6, 'William', 'Tighlit', 'Williamsss', 'azerty', 'etudiant'),
(7, 'Arbel', '', 'ARBEL', 'arbel123', 'admin'),
(8, 'Alex', 'Guiblain', 'Alexandre', 'azerty', 'admin');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
 ADD PRIMARY KEY (`idArticle`);

--
-- Index pour la table `articledisponible`
--
ALTER TABLE `articledisponible`
 ADD PRIMARY KEY (`idDispo`), ADD KEY `idArticle` (`idArticle`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
 ADD PRIMARY KEY (`idCommande`), ADD KEY `idUtilisateur` (`idUtilisateur`), ADD KEY `idDispo` (`idDispo`);

--
-- Index pour la table `ingredient`
--
ALTER TABLE `ingredient`
 ADD PRIMARY KEY (`idIngredient`), ADD KEY `idArticle` (`idArticle`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
 ADD PRIMARY KEY (`idUtilisateur`), ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
MODIFY `idArticle` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `articledisponible`
--
ALTER TABLE `articledisponible`
MODIFY `idDispo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
MODIFY `idCommande` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `ingredient`
--
ALTER TABLE `ingredient`
MODIFY `idIngredient` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
