-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 25 Août 2015 à 16:57
-- Version du serveur :  5.6.25
-- Version de PHP :  5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `db580625521`
--

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

CREATE TABLE IF NOT EXISTS `classe` (
  `idClasse` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `couleur` varchar(25) DEFAULT NULL,
  `idjeux` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `classe`
--

INSERT INTO `classe` (`idClasse`, `nom`, `icon`, `couleur`, `idjeux`) VALUES
(1, 'Guerrier', NULL, NULL, 1),
(2, 'Chasseur', NULL, NULL, 1),
(3, 'Prêtre', NULL, NULL, 1),
(4, 'Chaman', NULL, NULL, 1),
(5, 'Démoniste', NULL, NULL, 1),
(6, 'Druide', NULL, NULL, 1),
(7, 'Paladin', NULL, NULL, 1),
(8, 'Voleur', NULL, NULL, 1),
(9, 'Chevalier de la mort', NULL, NULL, 1),
(10, 'Mage', NULL, NULL, 1),
(11, 'Moine', NULL, NULL, 1),
(12, 'Chasseur de démons', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `donjon`
--

CREATE TABLE IF NOT EXISTS `donjon` (
  `idDonjon` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `lvlMin` mediumint(9) DEFAULT NULL,
  `tailleMax` mediumint(9) DEFAULT NULL,
  `idjeux` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `evenements`
--

CREATE TABLE IF NOT EXISTS `evenements` (
  `idEvenements` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `dateHeureDebutInvitation` datetime DEFAULT NULL,
  `dateHeureDebutEvenement` datetime DEFAULT NULL,
  `dateHeureFinInscription` datetime NOT NULL,
  `lvlMin` mediumint(9) DEFAULT NULL,
  `ouvertATous` tinyint(1) DEFAULT NULL,
  `dateCreation` datetime DEFAULT NULL,
  `dateModification` datetime DEFAULT NULL,
  `idDonjon` int(11) NOT NULL,
  `idUsers` int(11) NOT NULL,
  `idGuildes` int(11) DEFAULT NULL,
  `idRoster` int(11) DEFAULT NULL,
  `idEvenements_template` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `evenements_personnage`
--

CREATE TABLE IF NOT EXISTS `evenements_personnage` (
  `idEvenement_personnage` int(11) NOT NULL,
  `status` varchar(45) DEFAULT NULL COMMENT 'abs\nvalide\nconfirme\npresent',
  `dateCreation` datetime DEFAULT NULL,
  `dateModification` datetime DEFAULT NULL,
  `idEvenements` int(11) NOT NULL,
  `idPersonnage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `evenements_roles`
--

CREATE TABLE IF NOT EXISTS `evenements_roles` (
  `idEvenements_roles` int(11) NOT NULL,
  `nombre` mediumint(9) DEFAULT NULL,
  `ordre` mediumint(9) DEFAULT NULL,
  `idEvenements` int(11) NOT NULL,
  `idRoles` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `evenements_template`
--

CREATE TABLE IF NOT EXISTS `evenements_template` (
  `idEvenements_template` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `dateHeureDebutInvitation` datetime DEFAULT NULL,
  `dateHeureDebutEvenement` datetime DEFAULT NULL,
  `dateHeureFinInscription` datetime NOT NULL,
  `lvlMin` mediumint(9) DEFAULT NULL,
  `ouvertATous` tinyint(1) DEFAULT NULL,
  `dateCreation` datetime DEFAULT NULL,
  `dateModification` datetime DEFAULT NULL,
  `idDonjon` int(11) NOT NULL,
  `idGuildes` int(11) DEFAULT NULL,
  `idRoster` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `evenements_template_roles`
--

CREATE TABLE IF NOT EXISTS `evenements_template_roles` (
  `idEvenements_template_roles` int(11) NOT NULL,
  `nombre` mediumint(9) DEFAULT NULL,
  `ordre` mediumint(9) DEFAULT NULL,
  `idEvenements_template` int(11) NOT NULL,
  `idRoles` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `guildes`
--

CREATE TABLE IF NOT EXISTS `guildes` (
  `idGuildes` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `serveur` varchar(100) DEFAULT NULL,
  `idJeux` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `guildes`
--

INSERT INTO `guildes` (`idGuildes`, `nom`, `serveur`, `idJeux`) VALUES
(0, 'aaa', 'aaaa', 1);

-- --------------------------------------------------------

--
-- Structure de la table `jeux`
--

CREATE TABLE IF NOT EXISTS `jeux` (
  `idJeux` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `jeux`
--

INSERT INTO `jeux` (`idJeux`, `nom`, `logo`) VALUES
(1, 'WOW', 'logoWOW');

-- --------------------------------------------------------

--
-- Structure de la table `personnage`
--

CREATE TABLE IF NOT EXISTS `personnage` (
  `idPersonnage` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `niveau` mediumint(9) DEFAULT NULL,
  `idUsers` int(11) NOT NULL,
  `idJeux` int(11) NOT NULL,
  `idGuildes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `race`
--

CREATE TABLE IF NOT EXISTS `race` (
  `idRace` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `idJeux` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `race`
--

INSERT INTO `race` (`idRace`, `nom`, `idJeux`) VALUES
(1, 'Humain', 1),
(2, 'Elfe de la nuit', 1),
(3, 'Nain', 1),
(4, 'Worgen', 1),
(5, 'Orc', 1),
(6, 'Tauren', 1),
(7, 'Mort-vivant', 1),
(8, 'Pandaren', 1),
(9, 'Draeneï', 1),
(10, 'Gnome', 1),
(11, 'Gobelin', 1),
(12, 'Elfe de sang', 1),
(13, 'Troll', 1);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `idRoles` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `idjeux` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `roster`
--

CREATE TABLE IF NOT EXISTS `roster` (
  `idRoster` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `roster_has_personnage`
--

CREATE TABLE IF NOT EXISTS `roster_has_personnage` (
  `idRoster` int(11) NOT NULL,
  `idPersonnage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `idUsers` int(11) NOT NULL,
  `login` varchar(15) DEFAULT NULL,
  `pwd` varchar(150) DEFAULT NULL,
  `pseudo` varchar(150) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `avatar` varchar(150) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `forgetPass` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`idUsers`, `login`, `pwd`, `pseudo`, `email`, `avatar`, `admin`, `forgetPass`) VALUES
(1, 'capi', 'd1c036a377f80b3b624e87721caa5dc6', 'Capi', 'simoncreationweb@gmail.com', '', 1, NULL),
(2, 'kadyll', '283f56982bc7124adc6dd23c52561d9b', 'Kadyll', 'kevin.morieux@gmail.com ', 'eu/garona/25/96249369-avatar.jpg', 1, NULL),
(3, 'cely', '66ebc959e3c7345f0d68fb47db4a48ab', 'Cely', '33celine33@wanadoo.fr', 'eu/garona/113/9790833-avatar.jpg', 0, NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `classe`
--
ALTER TABLE `classe`
  ADD PRIMARY KEY (`idClasse`),
  ADD UNIQUE KEY `nom_UNIQUE` (`nom`),
  ADD KEY `fk_classe_jeux1_idx` (`idjeux`);

--
-- Index pour la table `donjon`
--
ALTER TABLE `donjon`
  ADD PRIMARY KEY (`idDonjon`),
  ADD UNIQUE KEY `nom_UNIQUE` (`nom`),
  ADD KEY `fk_donjon_jeux1_idx` (`idjeux`);

--
-- Index pour la table `evenements`
--
ALTER TABLE `evenements`
  ADD PRIMARY KEY (`idEvenements`),
  ADD KEY `fk_evenements_donjon1_idx` (`idDonjon`),
  ADD KEY `fk_evenements_users1_idx` (`idUsers`),
  ADD KEY `fk_evenements_guildes1_idx` (`idGuildes`),
  ADD KEY `fk_evenements_roster1_idx` (`idRoster`),
  ADD KEY `fk_evenements_evenements_template1_idx` (`idEvenements_template`);

--
-- Index pour la table `evenements_personnage`
--
ALTER TABLE `evenements_personnage`
  ADD PRIMARY KEY (`idEvenement_personnage`),
  ADD KEY `fk_evenement_personnage_evenements1_idx` (`idEvenements`),
  ADD KEY `fk_evenement_personnage_personnage1_idx` (`idPersonnage`);

--
-- Index pour la table `evenements_roles`
--
ALTER TABLE `evenements_roles`
  ADD PRIMARY KEY (`idEvenements_roles`),
  ADD KEY `fk_evenements_roles_evenements1_idx` (`idEvenements`),
  ADD KEY `fk_evenements_roles_roles1_idx` (`idRoles`);

--
-- Index pour la table `evenements_template`
--
ALTER TABLE `evenements_template`
  ADD PRIMARY KEY (`idEvenements_template`),
  ADD KEY `fk_evenements_donjon1_idx` (`idDonjon`),
  ADD KEY `fk_evenements_template_guildes1_idx` (`idGuildes`),
  ADD KEY `fk_evenements_template_roster1_idx` (`idRoster`);

--
-- Index pour la table `evenements_template_roles`
--
ALTER TABLE `evenements_template_roles`
  ADD PRIMARY KEY (`idEvenements_template_roles`),
  ADD KEY `fk_evenements_roles_roles1_idx` (`idRoles`),
  ADD KEY `fk_evenements_template_roles_evenements_template1_idx` (`idEvenements_template`);

--
-- Index pour la table `guildes`
--
ALTER TABLE `guildes`
  ADD PRIMARY KEY (`idGuildes`),
  ADD KEY `fk_guildes_jeux1_idx` (`idJeux`);

--
-- Index pour la table `jeux`
--
ALTER TABLE `jeux`
  ADD PRIMARY KEY (`idJeux`),
  ADD UNIQUE KEY `nom_UNIQUE` (`nom`);

--
-- Index pour la table `personnage`
--
ALTER TABLE `personnage`
  ADD PRIMARY KEY (`idPersonnage`),
  ADD KEY `fk_personnage_users1_idx` (`idUsers`),
  ADD KEY `fk_personnage_jeux1_idx` (`idJeux`),
  ADD KEY `fk_personnage_guildes1_idx` (`idGuildes`);

--
-- Index pour la table `race`
--
ALTER TABLE `race`
  ADD PRIMARY KEY (`idRace`),
  ADD UNIQUE KEY `nom_UNIQUE` (`nom`),
  ADD KEY `fk_race_jeux1_idx` (`idJeux`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRoles`),
  ADD UNIQUE KEY `nom_UNIQUE` (`nom`),
  ADD KEY `fk_roles_jeux1_idx` (`idjeux`);

--
-- Index pour la table `roster`
--
ALTER TABLE `roster`
  ADD PRIMARY KEY (`idRoster`);

--
-- Index pour la table `roster_has_personnage`
--
ALTER TABLE `roster_has_personnage`
  ADD PRIMARY KEY (`idRoster`,`idPersonnage`),
  ADD KEY `fk_roster_has_personnage_personnage1_idx` (`idPersonnage`),
  ADD KEY `fk_roster_has_personnage_roster1_idx` (`idRoster`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUsers`);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `classe`
--
ALTER TABLE `classe`
  ADD CONSTRAINT `fk_classe_jeux1` FOREIGN KEY (`idjeux`) REFERENCES `jeux` (`idJeux`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `donjon`
--
ALTER TABLE `donjon`
  ADD CONSTRAINT `fk_donjon_jeux1` FOREIGN KEY (`idjeux`) REFERENCES `jeux` (`idJeux`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `evenements`
--
ALTER TABLE `evenements`
  ADD CONSTRAINT `fk_evenements_donjon1` FOREIGN KEY (`idDonjon`) REFERENCES `donjon` (`idDonjon`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_evenements_evenements_template1` FOREIGN KEY (`idEvenements_template`) REFERENCES `evenements_template` (`idEvenements_template`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_evenements_guildes1` FOREIGN KEY (`idGuildes`) REFERENCES `guildes` (`idGuildes`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_evenements_roster1` FOREIGN KEY (`idRoster`) REFERENCES `roster` (`idRoster`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_evenements_users1` FOREIGN KEY (`idUsers`) REFERENCES `users` (`idUsers`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `evenements_personnage`
--
ALTER TABLE `evenements_personnage`
  ADD CONSTRAINT `fk_evenement_personnage_evenements1` FOREIGN KEY (`idEvenements`) REFERENCES `evenements` (`idEvenements`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_evenement_personnage_personnage1` FOREIGN KEY (`idPersonnage`) REFERENCES `personnage` (`idPersonnage`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `evenements_roles`
--
ALTER TABLE `evenements_roles`
  ADD CONSTRAINT `fk_evenements_roles_evenements1` FOREIGN KEY (`idEvenements`) REFERENCES `evenements` (`idEvenements`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_evenements_roles_roles1` FOREIGN KEY (`idRoles`) REFERENCES `roles` (`idRoles`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `evenements_template`
--
ALTER TABLE `evenements_template`
  ADD CONSTRAINT `fk_evenements_donjon10` FOREIGN KEY (`idDonjon`) REFERENCES `donjon` (`idDonjon`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_evenements_template_guildes1` FOREIGN KEY (`idGuildes`) REFERENCES `guildes` (`idGuildes`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_evenements_template_roster1` FOREIGN KEY (`idRoster`) REFERENCES `roster` (`idRoster`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `evenements_template_roles`
--
ALTER TABLE `evenements_template_roles`
  ADD CONSTRAINT `fk_evenements_roles_roles10` FOREIGN KEY (`idRoles`) REFERENCES `roles` (`idRoles`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_evenements_template_roles_evenements_template1` FOREIGN KEY (`idEvenements_template`) REFERENCES `evenements_template` (`idEvenements_template`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `guildes`
--
ALTER TABLE `guildes`
  ADD CONSTRAINT `fk_guildes_jeux1` FOREIGN KEY (`idJeux`) REFERENCES `jeux` (`idJeux`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `personnage`
--
ALTER TABLE `personnage`
  ADD CONSTRAINT `fk_personnage_guildes1` FOREIGN KEY (`idGuildes`) REFERENCES `guildes` (`idGuildes`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_personnage_jeux1` FOREIGN KEY (`idJeux`) REFERENCES `jeux` (`idJeux`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_personnage_users1` FOREIGN KEY (`idUsers`) REFERENCES `users` (`idUsers`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `race`
--
ALTER TABLE `race`
  ADD CONSTRAINT `fk_race_jeux1` FOREIGN KEY (`idJeux`) REFERENCES `jeux` (`idJeux`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `fk_roles_jeux1` FOREIGN KEY (`idjeux`) REFERENCES `jeux` (`idJeux`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `roster_has_personnage`
--
ALTER TABLE `roster_has_personnage`
  ADD CONSTRAINT `fk_roster_has_personnage_personnage1` FOREIGN KEY (`idPersonnage`) REFERENCES `personnage` (`idPersonnage`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_roster_has_personnage_roster1` FOREIGN KEY (`idRoster`) REFERENCES `roster` (`idRoster`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
