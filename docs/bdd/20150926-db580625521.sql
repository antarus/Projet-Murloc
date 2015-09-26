-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 26 Septembre 2015 à 14:37
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
-- Structure de la table `donjon`
--

CREATE TABLE IF NOT EXISTS `donjon` (
  `idDonjon` int(11) NOT NULL,
  `nom` varchar(45) NOT NULL,
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
  `nom` varchar(45) NOT NULL,
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
  `nom` varchar(45) NOT NULL,
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
  `nom` varchar(45) NOT NULL,
  `idJeux` int(11) DEFAULT NULL,
  `data` text
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `guildes`
--

INSERT INTO `guildes` (`idGuildes`, `nom`, `idJeux`, `data`) VALUES
(1, 'Mystra', 1, '{"wow":{"royaume":"Garona","battlegroup":"Embuscade / Hinterhalt","niveau":25,"faction":0,"miniature":null,"hf":2180}}');

-- --------------------------------------------------------

--
-- Structure de la table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `idItem` int(10) unsigned NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `valeur` float(10,2) DEFAULT NULL,
  `date` int(11) NOT NULL DEFAULT '0',
  `ajouterPar` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `majPar` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `idItemJeu` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `couleur` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `idPersonnage` int(11) DEFAULT NULL,
  `idEvenements` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `jeux`
--

CREATE TABLE IF NOT EXISTS `jeux` (
  `idJeux` int(11) NOT NULL,
  `nom` varchar(45) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `jeux`
--

INSERT INTO `jeux` (`idJeux`, `nom`, `logo`, `active`) VALUES
(1, 'World Of Warcraft', 'wow.jpg', 0),
(2, 'FF14', 'logoff14', 0);

-- --------------------------------------------------------

--
-- Structure de la table `personnages`
--

CREATE TABLE IF NOT EXISTS `personnages` (
  `idPersonnage` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `niveau` mediumint(9) DEFAULT NULL,
  `idUsers` int(11) DEFAULT NULL,
  `idJeux` int(11) NOT NULL,
  `idGuildes` int(11) DEFAULT NULL,
  `data` text
) ENGINE=InnoDB AUTO_INCREMENT=186 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `personnages`
--

INSERT INTO `personnages` (`idPersonnage`, `nom`, `niveau`, `idUsers`, `idJeux`, `idGuildes`, `data`) VALUES
(1, 'Mordrède', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":1,"genre":0,"ptHf":13965,"miniature":"garona\\/30\\/2636318-avatar.jpg","rang":8}}'),
(2, 'Alekssandra', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":4,"genre":1,"ptHf":10055,"miniature":"garona\\/109\\/2721389-avatar.jpg","rang":7}}'),
(3, 'Prony', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":4,"genre":0,"ptHf":13325,"miniature":"garona\\/83\\/2803795-avatar.jpg","rang":3}}'),
(4, 'Irisia', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":4,"genre":1,"ptHf":12300,"miniature":"garona\\/26\\/5482266-avatar.jpg","rang":9}}'),
(5, 'Tréféros', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":22,"genre":0,"ptHf":5615,"miniature":"garona\\/34\\/9006370-avatar.jpg","rang":8}}'),
(6, 'Capikaze', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":11,"genre":0,"ptHf":14290,"miniature":"garona\\/170\\/9321898-avatar.jpg","rang":3}}'),
(7, 'Sadday', 100, NULL, 1, 1, '{"wow":{"classe":5,"race":1,"genre":1,"ptHf":8795,"miniature":"garona\\/46\\/9553198-avatar.jpg","rang":7}}'),
(8, 'Falinns', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":4,"genre":0,"ptHf":20995,"miniature":"garona\\/234\\/9607402-avatar.jpg","rang":4}}'),
(9, 'Myna', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":1,"genre":1,"ptHf":9660,"miniature":"garona\\/161\\/9657249-avatar.jpg","rang":7}}'),
(10, 'Reve', 100, NULL, 1, 1, '{"wow":{"classe":9,"race":7,"genre":1,"ptHf":9660,"miniature":"garona\\/148\\/9673876-avatar.jpg","rang":8}}'),
(11, 'Cely', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":1,"genre":1,"ptHf":10305,"miniature":"garona\\/113\\/9790833-avatar.jpg","rang":5}}'),
(12, 'Parlama', 100, NULL, 1, 1, '{"wow":{"classe":9,"race":1,"genre":1,"ptHf":15820,"miniature":"garona\\/143\\/10635151-avatar.jpg","rang":2}}'),
(13, 'Acronomicon', 100, NULL, 1, 1, '{"wow":{"classe":9,"race":1,"genre":0,"ptHf":21495,"miniature":"garona\\/76\\/12192588-avatar.jpg","rang":6}}'),
(14, 'Lhilhi', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":4,"genre":1,"ptHf":15820,"miniature":"garona\\/209\\/12288465-avatar.jpg","rang":2}}'),
(15, 'Karabistouil', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":4,"genre":1,"ptHf":15505,"miniature":"garona\\/66\\/13559106-avatar.jpg","rang":1}}'),
(16, 'Ptitepoucett', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":4,"genre":1,"ptHf":14065,"miniature":"garona\\/237\\/13613805-avatar.jpg","rang":1}}'),
(17, 'Healsangel', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":4,"genre":1,"ptHf":7680,"miniature":"garona\\/226\\/14281954-avatar.jpg","rang":4}}'),
(18, 'Nisya', 100, NULL, 1, 1, '{"wow":{"classe":9,"race":1,"genre":1,"ptHf":20995,"miniature":"garona\\/34\\/15257378-avatar.jpg","rang":4}}'),
(19, 'Kaarapital', 100, NULL, 1, 1, '{"wow":{"classe":7,"race":11,"genre":1,"ptHf":15505,"miniature":"garona\\/134\\/16132486-avatar.jpg","rang":1}}'),
(20, 'Poupoucetire', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":11,"genre":1,"ptHf":14080,"miniature":"garona\\/234\\/16132842-avatar.jpg","rang":1}}'),
(21, 'Arcalyne', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":1,"genre":1,"ptHf":15820,"miniature":"garona\\/244\\/17042164-avatar.jpg","rang":2}}'),
(22, 'Kaarabine', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":4,"genre":1,"ptHf":15505,"miniature":"garona\\/170\\/17945514-avatar.jpg","rang":1}}'),
(23, 'Lisys', 100, NULL, 1, 1, '{"wow":{"classe":5,"race":1,"genre":1,"ptHf":20995,"miniature":"garona\\/178\\/18159538-avatar.jpg","rang":4}}'),
(24, 'Bogossa', 100, NULL, 1, 1, '{"wow":{"classe":7,"race":11,"genre":1,"ptHf":13275,"miniature":"garona\\/71\\/19291463-avatar.jpg","rang":8}}'),
(25, 'Nostalgie', 100, NULL, 1, 1, '{"wow":{"classe":5,"race":11,"genre":1,"ptHf":9660,"miniature":"garona\\/25\\/19346713-avatar.jpg","rang":8}}'),
(26, 'Rurú', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":1,"genre":1,"ptHf":7490,"miniature":"garona\\/200\\/19821000-avatar.jpg","rang":7}}'),
(27, 'Poulich', 100, NULL, 1, 1, '{"wow":{"classe":6,"race":1,"genre":1,"ptHf":14080,"miniature":"garona\\/109\\/23709549-avatar.jpg","rang":1}}'),
(28, 'Prozzak', 100, NULL, 1, 1, '{"wow":{"classe":5,"race":3,"genre":0,"ptHf":14385,"miniature":"garona\\/42\\/26734122-avatar.jpg","rang":3}}'),
(29, 'Redoot', 100, NULL, 1, 1, '{"wow":{"classe":6,"race":1,"genre":1,"ptHf":5850,"miniature":"garona\\/254\\/29159934-avatar.jpg","rang":7}}'),
(30, 'Zängetsü', 100, NULL, 1, 1, '{"wow":{"classe":5,"race":3,"genre":1,"ptHf":7700,"miniature":"garona\\/103\\/30505063-avatar.jpg","rang":7}}'),
(31, 'Tÿra', 100, NULL, 1, 1, '{"wow":{"classe":6,"race":1,"genre":0,"ptHf":19610,"miniature":"garona\\/57\\/35029305-avatar.jpg","rang":5}}'),
(32, 'Auron', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":1,"genre":0,"ptHf":20140,"miniature":"garona\\/61\\/35204669-avatar.jpg","rang":7}}'),
(33, 'Tikchbila', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":22,"genre":0,"ptHf":13275,"miniature":"garona\\/154\\/36140954-avatar.jpg","rang":8}}'),
(34, 'Aeoline', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":4,"genre":1,"ptHf":7535,"miniature":"garona\\/61\\/37618237-avatar.jpg","rang":5}}'),
(35, 'Zhavina', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":22,"genre":1,"ptHf":9365,"miniature":"garona\\/234\\/38668522-avatar.jpg","rang":6}}'),
(36, 'Bachantes', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":3,"genre":0,"ptHf":12085,"miniature":"garona\\/49\\/39400497-avatar.jpg","rang":8}}'),
(37, 'Cavalerie', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":3,"genre":0,"ptHf":9645,"miniature":"garona\\/88\\/39615576-avatar.jpg","rang":8}}'),
(38, 'Capï', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":4,"genre":0,"ptHf":14385,"miniature":"garona\\/40\\/40891944-avatar.jpg","rang":3}}'),
(39, 'Amaltée', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":1,"genre":1,"ptHf":10900,"miniature":"garona\\/105\\/41161833-avatar.jpg","rang":8}}'),
(40, 'Dootty', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":1,"genre":1,"ptHf":6000,"miniature":"garona\\/247\\/43145207-avatar.jpg","rang":7}}'),
(41, 'Laugan', 100, NULL, 1, 1, '{"wow":{"classe":5,"race":3,"genre":0,"ptHf":20130,"miniature":"garona\\/23\\/45220631-avatar.jpg","rang":8}}'),
(42, 'Ptitelouve', 100, NULL, 1, 1, '{"wow":{"classe":4,"race":22,"genre":1,"ptHf":14080,"miniature":"garona\\/123\\/45595259-avatar.jpg","rang":1}}'),
(43, 'Jakhal', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":1,"genre":0,"ptHf":3810,"miniature":"garona\\/47\\/45638959-avatar.jpg","rang":7}}'),
(44, 'Castyhell', 100, NULL, 1, 1, '{"wow":{"classe":5,"race":7,"genre":0,"ptHf":10115,"miniature":"garona\\/119\\/47108983-avatar.jpg","rang":8}}'),
(45, 'Kalamïty', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":1,"genre":1,"ptHf":14080,"miniature":"garona\\/195\\/48465859-avatar.jpg","rang":1}}'),
(46, 'Aelyne', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":4,"genre":1,"ptHf":9660,"miniature":"garona\\/116\\/48794484-avatar.jpg","rang":8}}'),
(47, 'Félicias', 100, NULL, 1, 1, '{"wow":{"classe":9,"race":1,"genre":1,"ptHf":12275,"miniature":"garona\\/137\\/49561225-avatar.jpg","rang":8}}'),
(48, 'Rapiou', 100, NULL, 1, 1, '{"wow":{"classe":4,"race":22,"genre":0,"ptHf":12085,"miniature":"garona\\/76\\/50125388-avatar.jpg","rang":8}}'),
(49, 'Thusùxx', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":22,"genre":0,"ptHf":12275,"miniature":"garona\\/97\\/50817121-avatar.jpg","rang":8}}'),
(50, 'Ette', 100, NULL, 1, 1, '{"wow":{"classe":4,"race":1,"genre":1,"ptHf":8640,"miniature":"garona\\/224\\/51217888-avatar.jpg","rang":8}}'),
(51, 'Mâjuscule', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":11,"genre":1,"ptHf":14080,"miniature":"garona\\/85\\/51698517-avatar.jpg","rang":1}}'),
(52, 'Alicette', 100, NULL, 1, 1, '{"wow":{"classe":5,"race":1,"genre":1,"ptHf":15430,"miniature":"garona\\/71\\/52426823-avatar.jpg","rang":8}}'),
(53, 'Deathinition', 100, NULL, 1, 1, '{"wow":{"classe":6,"race":11,"genre":0,"ptHf":7680,"miniature":"garona\\/206\\/52678862-avatar.jpg","rang":1}}'),
(54, 'Gøuminette', 100, NULL, 1, 1, '{"wow":{"classe":7,"race":3,"genre":1,"ptHf":8670,"miniature":"garona\\/120\\/54341240-avatar.jpg","rang":5}}'),
(55, 'Ðharmå', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":4,"genre":1,"ptHf":13310,"miniature":"garona\\/206\\/54710222-avatar.jpg","rang":3}}'),
(56, 'Nydelia', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":4,"genre":1,"ptHf":9640,"miniature":"garona\\/51\\/55169843-avatar.jpg","rang":8}}'),
(57, 'Valyanas', 100, NULL, 1, 1, '{"wow":{"classe":7,"race":11,"genre":1,"ptHf":15820,"miniature":"garona\\/30\\/55325214-avatar.jpg","rang":2}}'),
(58, 'Zozett', 100, NULL, 1, 1, '{"wow":{"classe":9,"race":7,"genre":1,"ptHf":11850,"miniature":"garona\\/185\\/55712953-avatar.jpg","rang":5}}'),
(59, 'Drasnil', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":4,"genre":0,"ptHf":12185,"miniature":"garona\\/205\\/55836621-avatar.jpg","rang":8}}'),
(60, 'Tchitoss', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":1,"genre":0,"ptHf":10625,"miniature":"garona\\/127\\/55861631-avatar.jpg","rang":8}}'),
(61, 'Swanya', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":22,"genre":1,"ptHf":15820,"miniature":"garona\\/7\\/56419335-avatar.jpg","rang":2}}'),
(62, 'Nayka', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":1,"genre":1,"ptHf":12700,"miniature":"garona\\/75\\/56993099-avatar.jpg","rang":7}}'),
(63, 'Samsun', 100, NULL, 1, 1, '{"wow":{"classe":10,"race":25,"genre":0,"ptHf":10135,"miniature":"garona\\/42\\/57908522-avatar.jpg","rang":8}}'),
(64, 'Yanarbo', 100, NULL, 1, 1, '{"wow":{"classe":5,"race":7,"genre":0,"ptHf":13565,"miniature":"garona\\/147\\/58810259-avatar.jpg","rang":5}}'),
(65, 'Coonta', 100, NULL, 1, 1, '{"wow":{"classe":9,"race":1,"genre":1,"ptHf":19610,"miniature":"garona\\/127\\/59596159-avatar.jpg","rang":7}}'),
(66, 'Kâlia', 100, NULL, 1, 1, '{"wow":{"classe":10,"race":25,"genre":1,"ptHf":19610,"miniature":"garona\\/223\\/59663071-avatar.jpg","rang":7}}'),
(67, 'Drethz', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":1,"genre":0,"ptHf":20915,"miniature":"garona\\/61\\/60030013-avatar.jpg","rang":4}}'),
(68, 'Amnésiâ', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":4,"genre":1,"ptHf":5280,"miniature":"garona\\/24\\/60044568-avatar.jpg","rang":8}}'),
(69, 'Aryaa', 100, NULL, 1, 1, '{"wow":{"classe":7,"race":11,"genre":1,"ptHf":20995,"miniature":"garona\\/119\\/60073847-avatar.jpg","rang":4}}'),
(70, 'Happý', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":1,"genre":1,"ptHf":14160,"miniature":"garona\\/117\\/60939637-avatar.jpg","rang":4}}'),
(71, 'Sysuka', 100, NULL, 1, 1, '{"wow":{"classe":4,"race":1,"genre":1,"ptHf":2745,"miniature":"garona\\/198\\/61132486-avatar.jpg","rang":8}}'),
(72, 'Arfananwel', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":1,"genre":0,"ptHf":5360,"miniature":"garona\\/130\\/61251714-avatar.jpg","rang":8}}'),
(73, 'Deathss', 100, NULL, 1, 1, '{"wow":{"classe":6,"race":22,"genre":0,"ptHf":20915,"miniature":"garona\\/187\\/61502395-avatar.jpg","rang":7}}'),
(74, 'Angelÿn', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":25,"genre":1,"ptHf":9660,"miniature":"garona\\/15\\/61609999-avatar.jpg","rang":6}}'),
(75, 'Yoshino', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":4,"genre":1,"ptHf":2870,"miniature":"garona\\/60\\/61798972-avatar.jpg","rang":7}}'),
(76, 'Yukinø', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":1,"genre":1,"ptHf":9080,"miniature":"garona\\/69\\/61798981-avatar.jpg","rang":8}}'),
(77, 'Baêlle', 100, NULL, 1, 1, '{"wow":{"classe":9,"race":1,"genre":1,"ptHf":6105,"miniature":"garona\\/214\\/62194646-avatar.jpg","rang":8}}'),
(78, 'Suyon', 100, NULL, 1, 1, '{"wow":{"classe":7,"race":11,"genre":1,"ptHf":11435,"miniature":"garona\\/141\\/62668429-avatar.jpg","rang":6}}'),
(79, 'Yukïno', 100, NULL, 1, 1, '{"wow":{"classe":6,"race":11,"genre":1,"ptHf":9080,"miniature":"garona\\/164\\/62752932-avatar.jpg","rang":7}}'),
(80, 'Samisa', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":4,"genre":1,"ptHf":5440,"miniature":"garona\\/43\\/62753835-avatar.jpg","rang":7}}'),
(81, 'Jisun', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":1,"genre":1,"ptHf":3725,"miniature":"garona\\/42\\/63894058-avatar.jpg","rang":7}}'),
(82, 'Ayumu', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":11,"genre":1,"ptHf":5745,"miniature":"garona\\/202\\/63920074-avatar.jpg","rang":7}}'),
(83, 'Jevi', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":4,"genre":0,"ptHf":11170,"miniature":"garona\\/188\\/64233916-avatar.jpg","rang":6}}'),
(84, 'Mickie', 100, NULL, 1, 1, '{"wow":{"classe":9,"race":1,"genre":1,"ptHf":4310,"miniature":"garona\\/119\\/65614711-avatar.jpg","rang":7}}'),
(85, 'Minji', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":4,"genre":1,"ptHf":4580,"miniature":"garona\\/115\\/65681011-avatar.jpg","rang":7}}'),
(86, 'Liefing', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":4,"genre":1,"ptHf":9870,"miniature":"garona\\/70\\/65804870-avatar.jpg","rang":6}}'),
(87, 'Elfefeunoire', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":4,"genre":1,"ptHf":10440,"miniature":"garona\\/44\\/65805100-avatar.jpg","rang":7}}'),
(88, 'Minervä', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":4,"genre":1,"ptHf":7380,"miniature":"garona\\/91\\/65860187-avatar.jpg","rang":8}}'),
(89, 'Décapsuleuse', 100, NULL, 1, 1, '{"wow":{"classe":6,"race":4,"genre":1,"ptHf":15750,"miniature":"garona\\/3\\/66000131-avatar.jpg","rang":8}}'),
(90, 'Emac', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":22,"genre":1,"ptHf":6910,"miniature":"garona\\/218\\/66211802-avatar.jpg","rang":8}}'),
(91, 'Lnaudru', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":22,"genre":1,"ptHf":8615,"miniature":"garona\\/232\\/66251496-avatar.jpg","rang":8}}'),
(92, 'Alwynn', 100, NULL, 1, 1, '{"wow":{"classe":5,"race":4,"genre":0,"ptHf":14095,"miniature":"garona\\/253\\/66481661-avatar.jpg","rang":5}}'),
(93, 'Xylomi', 100, NULL, 1, 1, '{"wow":{"classe":7,"race":11,"genre":1,"ptHf":11940,"miniature":"garona\\/185\\/66549177-avatar.jpg","rang":8}}'),
(94, 'Paradozaline', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":4,"genre":1,"ptHf":12235,"miniature":"garona\\/143\\/66553231-avatar.jpg","rang":8}}'),
(95, 'Bellame', 100, NULL, 1, 1, '{"wow":{"classe":7,"race":11,"genre":1,"ptHf":14095,"miniature":"garona\\/86\\/67268182-avatar.jpg","rang":7}}'),
(96, 'Kaaraoké', 100, NULL, 1, 1, '{"wow":{"classe":9,"race":7,"genre":1,"ptHf":15505,"miniature":"garona\\/89\\/67511385-avatar.jpg","rang":1}}'),
(97, 'Kaara', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":7,"genre":1,"ptHf":15505,"miniature":"garona\\/152\\/67514776-avatar.jpg","rang":0}}'),
(98, 'Cøcalight', 100, NULL, 1, 1, '{"wow":{"classe":7,"race":11,"genre":1,"ptHf":9080,"miniature":"garona\\/69\\/67702597-avatar.jpg","rang":7}}'),
(99, 'Karaoutai', 100, NULL, 1, 1, '{"wow":{"classe":5,"race":7,"genre":1,"ptHf":15505,"miniature":"garona\\/10\\/67769098-avatar.jpg","rang":1}}'),
(100, 'Zygore', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":1,"genre":0,"ptHf":9255,"miniature":"garona\\/94\\/67822686-avatar.jpg","rang":7}}'),
(101, 'Jiwon', 100, NULL, 1, 1, '{"wow":{"classe":6,"race":4,"genre":1,"ptHf":4305,"miniature":"garona\\/83\\/68678739-avatar.jpg","rang":7}}'),
(102, 'Okarin', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":4,"genre":0,"ptHf":15925,"miniature":"garona\\/37\\/69615909-avatar.jpg","rang":7}}'),
(103, 'Mûrmûr', 100, NULL, 1, 1, '{"wow":{"classe":9,"race":22,"genre":1,"ptHf":14080,"miniature":"garona\\/95\\/69866079-avatar.jpg","rang":7}}'),
(104, 'Cøcazerø', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":1,"genre":0,"ptHf":9080,"miniature":"garona\\/86\\/70524502-avatar.jpg","rang":7}}'),
(105, 'Mizutani', 100, NULL, 1, 1, '{"wow":{"classe":10,"race":1,"genre":1,"ptHf":4345,"miniature":"garona\\/21\\/72120085-avatar.jpg","rang":7}}'),
(106, 'Hàppÿ', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":1,"genre":1,"ptHf":14055,"miniature":"garona\\/48\\/73542960-avatar.jpg","rang":4}}'),
(107, 'Jevo', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":7,"genre":0,"ptHf":1255,"miniature":"garona\\/124\\/73588092-avatar.jpg","rang":7}}'),
(108, 'Yùkinà', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":4,"genre":1,"ptHf":9080,"miniature":"garona\\/1\\/73646593-avatar.jpg","rang":7}}'),
(109, 'Hayes', 100, NULL, 1, 1, '{"wow":{"classe":6,"race":1,"genre":1,"ptHf":20140,"miniature":"garona\\/99\\/73668963-avatar.jpg","rang":7}}'),
(110, 'Yùkinø', 100, NULL, 1, 1, '{"wow":{"classe":5,"race":1,"genre":1,"ptHf":9080,"miniature":"garona\\/144\\/73912720-avatar.jpg","rang":7}}'),
(111, 'Antaruss', 100, NULL, 1, 1, '{"wow":{"classe":10,"race":1,"genre":1,"ptHf":7775,"miniature":"garona\\/10\\/74018058-avatar.jpg","rang":4}}'),
(112, 'Christange', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":1,"genre":1,"ptHf":7750,"miniature":"garona\\/87\\/74051159-avatar.jpg","rang":7}}'),
(113, 'Bloodynight', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":11,"genre":1,"ptHf":10830,"miniature":"garona\\/213\\/74478293-avatar.jpg","rang":7}}'),
(114, 'Jevy', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":1,"genre":0,"ptHf":3175,"miniature":"garona\\/192\\/78349504-avatar.jpg","rang":7}}'),
(115, 'Anøla', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":25,"genre":1,"ptHf":7550,"miniature":"garona\\/249\\/84005625-avatar.jpg","rang":8}}'),
(116, 'Miks', 100, NULL, 1, 1, '{"wow":{"classe":9,"race":1,"genre":1,"ptHf":9995,"miniature":"garona\\/106\\/89038442-avatar.jpg","rang":8}}'),
(117, 'Drakeman', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":1,"genre":0,"ptHf":14290,"miniature":"garona\\/37\\/89039653-avatar.jpg","rang":6}}'),
(118, 'Dogua', 100, NULL, 1, 1, '{"wow":{"classe":9,"race":1,"genre":0,"ptHf":1460,"miniature":"garona\\/166\\/89086886-avatar.jpg","rang":8}}'),
(119, 'Ildriar', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":1,"genre":0,"ptHf":9685,"miniature":"garona\\/166\\/89091494-avatar.jpg","rang":8}}'),
(120, 'Démonîos', 100, NULL, 1, 1, '{"wow":{"classe":9,"race":1,"genre":0,"ptHf":11050,"miniature":"garona\\/150\\/89172886-avatar.jpg","rang":8}}'),
(121, 'Palaouff', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":3,"genre":0,"ptHf":11235,"miniature":"garona\\/52\\/89191988-avatar.jpg","rang":5}}'),
(122, 'Drahas', 100, NULL, 1, 1, '{"wow":{"classe":6,"race":11,"genre":0,"ptHf":9995,"miniature":"garona\\/63\\/89275455-avatar.jpg","rang":8}}'),
(123, 'Phalaenöpsïs', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":1,"genre":1,"ptHf":8945,"miniature":"garona\\/121\\/89627001-avatar.jpg","rang":8}}'),
(124, 'Slowkiller', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":4,"genre":0,"ptHf":4965,"miniature":"garona\\/195\\/89651139-avatar.jpg","rang":8}}'),
(125, 'Riddick', 100, NULL, 1, 1, '{"wow":{"classe":4,"race":1,"genre":0,"ptHf":10595,"miniature":"garona\\/193\\/89665985-avatar.jpg","rang":8}}'),
(126, 'Spartìate', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":4,"genre":1,"ptHf":1880,"miniature":"garona\\/25\\/92064537-avatar.jpg","rang":8}}'),
(127, 'Nebutron', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":7,"genre":0,"ptHf":12185,"miniature":"garona\\/80\\/93613392-avatar.jpg","rang":8}}'),
(128, 'Prédictrice', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":3,"genre":1,"ptHf":12185,"miniature":"garona\\/236\\/93673708-avatar.jpg","rang":8}}'),
(129, 'Màndarîne', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":7,"genre":1,"ptHf":10675,"miniature":"garona\\/180\\/93930420-avatar.jpg","rang":8}}'),
(130, 'Kåterina', 100, NULL, 1, 1, '{"wow":{"classe":6,"race":1,"genre":1,"ptHf":14055,"miniature":"garona\\/20\\/94268948-avatar.jpg","rang":4}}'),
(131, 'Mawjoz', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":11,"genre":1,"ptHf":7445,"miniature":"garona\\/185\\/94273465-avatar.jpg","rang":8}}'),
(132, 'Seyer', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":1,"genre":0,"ptHf":10440,"miniature":"garona\\/86\\/94837334-avatar.jpg","rang":8}}'),
(133, 'Hällï', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":1,"genre":1,"ptHf":8840,"miniature":"garona\\/145\\/94954641-avatar.jpg","rang":9}}'),
(134, 'Gamakichy', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":1,"genre":0,"ptHf":7630,"miniature":"garona\\/48\\/94954800-avatar.jpg","rang":5}}'),
(135, 'Kàdyl', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":1,"genre":1,"ptHf":11825,"miniature":"garona\\/110\\/95004270-avatar.jpg","rang":7}}'),
(136, 'Raenis', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":4,"genre":0,"ptHf":9800,"miniature":"garona\\/229\\/95116261-avatar.jpg","rang":8}}'),
(137, 'Anyra', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":1,"genre":1,"ptHf":4150,"miniature":"garona\\/232\\/95432936-avatar.jpg","rang":8}}'),
(138, 'Kâdyl', 100, NULL, 1, 1, '{"wow":{"classe":9,"race":1,"genre":1,"ptHf":11825,"miniature":"garona\\/25\\/96249369-avatar.jpg","rang":5}}'),
(139, 'Hâllï', 100, NULL, 1, 1, '{"wow":{"classe":10,"race":11,"genre":1,"ptHf":8930,"miniature":"garona\\/208\\/96260560-avatar.jpg","rang":9}}'),
(140, 'Seriäth', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":3,"genre":0,"ptHf":6325,"miniature":"garona\\/36\\/96261412-avatar.jpg","rang":8}}'),
(141, 'Elyä', 100, NULL, 1, 1, '{"wow":{"classe":9,"race":1,"genre":1,"ptHf":9955,"miniature":"garona\\/84\\/96272212-avatar.jpg","rang":8}}'),
(142, 'Galérius', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":22,"genre":0,"ptHf":8670,"miniature":"garona\\/235\\/96323819-avatar.jpg","rang":5}}'),
(143, 'Lèvy', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":11,"genre":1,"ptHf":13500,"miniature":"garona\\/246\\/96557046-avatar.jpg","rang":3}}'),
(144, 'Märgâlärds', 100, NULL, 1, 1, '{"wow":{"classe":7,"race":11,"genre":0,"ptHf":11600,"miniature":"garona\\/13\\/96674829-avatar.jpg","rang":6}}'),
(145, 'Myllenia', 100, NULL, 1, 1, '{"wow":{"classe":5,"race":1,"genre":1,"ptHf":12090,"miniature":"garona\\/149\\/96820373-avatar.jpg","rang":8}}'),
(146, 'Ida', 100, NULL, 1, 1, '{"wow":{"classe":4,"race":3,"genre":1,"ptHf":13500,"miniature":"garona\\/80\\/96981584-avatar.jpg","rang":6}}'),
(147, 'Anÿ', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":4,"genre":1,"ptHf":9955,"miniature":"garona\\/13\\/96982797-avatar.jpg","rang":8}}'),
(148, 'Fandehappy', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":25,"genre":1,"ptHf":12590,"miniature":"garona\\/120\\/97083000-avatar.jpg","rang":7}}'),
(149, 'Belanima', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":1,"genre":1,"ptHf":14095,"miniature":"garona\\/41\\/97195305-avatar.jpg","rang":7}}'),
(150, 'Myllé', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":1,"genre":1,"ptHf":12180,"miniature":"garona\\/75\\/97468747-avatar.jpg","rang":8}}'),
(151, 'Colamana', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":1,"genre":1,"ptHf":16555,"miniature":"garona\\/129\\/97538689-avatar.jpg","rang":7}}'),
(152, 'Madania', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":1,"genre":0,"ptHf":15015,"miniature":"garona\\/125\\/97921917-avatar.jpg","rang":5}}'),
(153, 'Cëly', 100, NULL, 1, 1, '{"wow":{"classe":5,"race":1,"genre":1,"ptHf":10305,"miniature":"garona\\/12\\/98057228-avatar.jpg","rang":7}}'),
(154, 'Hatsuri', 100, NULL, 1, 1, '{"wow":{"classe":7,"race":11,"genre":1,"ptHf":2900,"miniature":"garona\\/166\\/98214566-avatar.jpg","rang":6}}'),
(155, 'Kazathwin', 100, NULL, 1, 1, '{"wow":{"classe":7,"race":3,"genre":0,"ptHf":8095,"miniature":"garona\\/77\\/98251853-avatar.jpg","rang":8}}'),
(156, 'Yamaraja', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":4,"genre":0,"ptHf":7610,"miniature":"garona\\/69\\/98374469-avatar.jpg","rang":7}}'),
(157, 'Zigfirt', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":7,"genre":0,"ptHf":6975,"miniature":"garona\\/125\\/98422141-avatar.jpg","rang":8}}'),
(158, 'Lowni', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":1,"genre":0,"ptHf":660,"miniature":"garona\\/230\\/98846438-avatar.jpg","rang":8}}'),
(159, 'Shaölin', 100, NULL, 1, 1, '{"wow":{"classe":10,"race":1,"genre":0,"ptHf":12275,"miniature":"garona\\/158\\/98933406-avatar.jpg","rang":8}}'),
(160, 'Rabbinovich', 100, NULL, 1, 1, '{"wow":{"classe":7,"race":25,"genre":0,"ptHf":10460,"miniature":"garona\\/186\\/98935738-avatar.jpg","rang":8}}'),
(161, 'Oriane', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":4,"genre":1,"ptHf":12185,"miniature":"garona\\/53\\/99038261-avatar.jpg","rang":8}}'),
(162, 'Protectrice', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":1,"genre":1,"ptHf":12185,"miniature":"garona\\/68\\/99038276-avatar.jpg","rang":8}}'),
(163, 'Frizzy', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":11,"genre":1,"ptHf":5470,"miniature":"garona\\/151\\/99375255-avatar.jpg","rang":8}}'),
(164, 'Acry', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":4,"genre":0,"ptHf":7630,"miniature":"garona\\/139\\/99398539-avatar.jpg","rang":8}}'),
(165, 'Abareth', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":11,"genre":0,"ptHf":9720,"miniature":"garona\\/74\\/99439178-avatar.jpg","rang":8}}'),
(166, 'Ashéron', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":4,"genre":0,"ptHf":9880,"miniature":"garona\\/8\\/99442440-avatar.jpg","rang":8}}'),
(167, 'Gàdock', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":3,"genre":0,"ptHf":7490,"miniature":"garona\\/67\\/99504451-avatar.jpg","rang":5}}'),
(168, 'Zeihn', 100, NULL, 1, 1, '{"wow":{"classe":7,"race":3,"genre":0,"ptHf":8230,"miniature":"garona\\/96\\/99505504-avatar.jpg","rang":6}}'),
(169, 'ßyxx', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":4,"genre":1,"ptHf":8655,"miniature":"garona\\/161\\/99535521-avatar.jpg","rang":8}}'),
(170, 'Kïkï', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":11,"genre":1,"ptHf":5470,"miniature":"garona\\/18\\/99551250-avatar.jpg","rang":8}}'),
(171, 'Nobu', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":1,"genre":1,"ptHf":12700,"miniature":"garona\\/162\\/99572642-avatar.jpg","rang":6}}'),
(172, 'Kadyll', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":1,"genre":0,"ptHf":1670,"miniature":"garona\\/208\\/99687376-avatar.jpg","rang":7}}'),
(173, 'Daxou', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":3,"genre":0,"ptHf":11175,"miniature":"garona\\/164\\/99707812-avatar.jpg","rang":6}}'),
(174, 'Jolarson', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":1,"genre":0,"ptHf":13025,"miniature":"garona\\/15\\/99708175-avatar.jpg","rang":6}}'),
(175, 'Dameos', 100, NULL, 1, 1, '{"wow":{"classe":1,"race":4,"genre":0,"ptHf":10930,"miniature":"garona\\/170\\/99708330-avatar.jpg","rang":6}}'),
(176, 'Nawamoon', 100, NULL, 1, 1, '{"wow":{"classe":7,"race":11,"genre":1,"ptHf":12410,"miniature":"garona\\/146\\/99708562-avatar.jpg","rang":6}}'),
(177, 'Isyama', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":4,"genre":1,"ptHf":11005,"miniature":"garona\\/185\\/99710649-avatar.jpg","rang":6}}'),
(178, 'Syriana', 100, NULL, 1, 1, '{"wow":{"classe":7,"race":11,"genre":1,"ptHf":6000,"miniature":"garona\\/215\\/99710935-avatar.jpg","rang":6}}'),
(179, 'Noouvak', 100, NULL, 1, 1, '{"wow":{"classe":9,"race":1,"genre":0,"ptHf":5670,"miniature":"garona\\/218\\/99780570-avatar.jpg","rang":8}}'),
(180, 'Chëësycrüst', 100, NULL, 1, 1, '{"wow":{"classe":8,"race":1,"genre":1,"ptHf":12395,"miniature":"garona\\/59\\/99807035-avatar.jpg","rang":8}}'),
(181, 'Grullite', 100, NULL, 1, 1, '{"wow":{"classe":6,"race":1,"genre":0,"ptHf":6015,"miniature":"garona\\/126\\/99824766-avatar.jpg","rang":8}}'),
(182, 'Kälïndrä', 100, NULL, 1, 1, '{"wow":{"classe":11,"race":4,"genre":1,"ptHf":8535,"miniature":"garona\\/126\\/99853694-avatar.jpg","rang":8}}'),
(183, 'Macewindou', 100, NULL, 1, 1, '{"wow":{"classe":2,"race":1,"genre":0,"ptHf":15430,"miniature":"garona\\/200\\/2185928-avatar.jpg","rang":8}}'),
(184, 'Xiaøyøu', 100, NULL, 1, 1, '{"wow":{"classe":3,"race":1,"genre":1,"ptHf":15430,"miniature":"garona\\/5\\/1838085-avatar.jpg","rang":8}}'),
(185, 'Dürkor', 100, NULL, 1, 1, '{"wow":{"classe":7,"race":11,"genre":0,"ptHf":0,"miniature":"garona\\/3\\/100087043-avatar.jpg","rang":8}}');

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
  `login` varchar(15) NOT NULL,
  `pwd` varchar(150) NOT NULL,
  `pseudo` varchar(150) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `avatar` varchar(150) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `forgetPass` varchar(500) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`idUsers`, `login`, `pwd`, `pseudo`, `email`, `avatar`, `admin`, `forgetPass`) VALUES
(1, 'capi', 'd1c036a377f80b3b624e87721caa5dc6', 'Capi', 'simoncreationweb@gmail.com', '', 1, NULL),
(2, 'kadyll', '283f56982bc7124adc6dd23c52561d9b', 'Kadyll', 'kevin.morieux@gmail.com ', 'eu/garona/25/96249369-avatar.jpg', 1, NULL),
(3, 'cely', '66ebc959e3c7345f0d68fb47db4a48ab', 'Cely', '33celine33@wanadoo.fr', 'eu/garona/113/9790833-avatar.jpg', 0, NULL),
(4, 'antarus', '283f56982bc7124adc6dd23c52561d9b', 'antarus', 'antarus74@gmail.com', NULL, 1, '55ddd033988419.88655411');

--
-- Index pour les tables exportées
--

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
  ADD KEY `fk_evenements_roles_evenements1_idx` (`idEvenements`);

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
  ADD KEY `fk_evenements_template_roles_evenements_template1_idx` (`idEvenements_template`);

--
-- Index pour la table `guildes`
--
ALTER TABLE `guildes`
  ADD PRIMARY KEY (`idGuildes`),
  ADD KEY `fk_guildes_jeux1_idx` (`idJeux`);

--
-- Index pour la table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`idItem`),
  ADD KEY `fk_items_personnages1_idx` (`idPersonnage`),
  ADD KEY `fk_items_evenements1_idx` (`idEvenements`);

--
-- Index pour la table `jeux`
--
ALTER TABLE `jeux`
  ADD PRIMARY KEY (`idJeux`),
  ADD UNIQUE KEY `nom_UNIQUE` (`nom`);

--
-- Index pour la table `personnages`
--
ALTER TABLE `personnages`
  ADD PRIMARY KEY (`idPersonnage`),
  ADD KEY `fk_personnage_users1_idx` (`idUsers`),
  ADD KEY `fk_personnage_jeux1_idx` (`idJeux`),
  ADD KEY `fk_personnage_guildes1_idx` (`idGuildes`);

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
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `donjon`
--
ALTER TABLE `donjon`
  MODIFY `idDonjon` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `evenements`
--
ALTER TABLE `evenements`
  MODIFY `idEvenements` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `evenements_personnage`
--
ALTER TABLE `evenements_personnage`
  MODIFY `idEvenement_personnage` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `evenements_roles`
--
ALTER TABLE `evenements_roles`
  MODIFY `idEvenements_roles` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `evenements_template`
--
ALTER TABLE `evenements_template`
  MODIFY `idEvenements_template` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `evenements_template_roles`
--
ALTER TABLE `evenements_template_roles`
  MODIFY `idEvenements_template_roles` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `guildes`
--
ALTER TABLE `guildes`
  MODIFY `idGuildes` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `items`
--
ALTER TABLE `items`
  MODIFY `idItem` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `jeux`
--
ALTER TABLE `jeux`
  MODIFY `idJeux` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `personnages`
--
ALTER TABLE `personnages`
  MODIFY `idPersonnage` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=186;
--
-- AUTO_INCREMENT pour la table `roster`
--
ALTER TABLE `roster`
  MODIFY `idRoster` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `idUsers` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

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
  ADD CONSTRAINT `fk_evenement_personnage_personnage1` FOREIGN KEY (`idPersonnage`) REFERENCES `personnages` (`idPersonnage`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `evenements_roles`
--
ALTER TABLE `evenements_roles`
  ADD CONSTRAINT `fk_evenements_roles_evenements1` FOREIGN KEY (`idEvenements`) REFERENCES `evenements` (`idEvenements`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_evenements_template_roles_evenements_template1` FOREIGN KEY (`idEvenements_template`) REFERENCES `evenements_template` (`idEvenements_template`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `guildes`
--
ALTER TABLE `guildes`
  ADD CONSTRAINT `fk_guildes_jeux1` FOREIGN KEY (`idJeux`) REFERENCES `jeux` (`idJeux`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `fk_items_evenements1` FOREIGN KEY (`idEvenements`) REFERENCES `evenements` (`idEvenements`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_items_personnages1` FOREIGN KEY (`idPersonnage`) REFERENCES `personnages` (`idPersonnage`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `personnages`
--
ALTER TABLE `personnages`
  ADD CONSTRAINT `fk_personnage_guildes1` FOREIGN KEY (`idGuildes`) REFERENCES `guildes` (`idGuildes`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_personnage_jeux1` FOREIGN KEY (`idJeux`) REFERENCES `jeux` (`idJeux`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_personnage_users1` FOREIGN KEY (`idUsers`) REFERENCES `users` (`idUsers`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `roster_has_personnage`
--
ALTER TABLE `roster_has_personnage`
  ADD CONSTRAINT `fk_roster_has_personnage_personnage1` FOREIGN KEY (`idPersonnage`) REFERENCES `personnages` (`idPersonnage`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_roster_has_personnage_roster1` FOREIGN KEY (`idRoster`) REFERENCES `roster` (`idRoster`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
