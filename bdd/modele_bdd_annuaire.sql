-- phpMyAdmin SQL Dump
-- version 3.4.3.2
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le : Jeu 24 Mai 2012 à 22:55
-- Version du serveur: 5.5.15
-- Version de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `essai_annuaire`
--

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

CREATE TABLE IF NOT EXISTS `entreprise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_entreprise` varchar(255) NOT NULL,
  `siteweb_entreprise` varchar(255) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `entreprise_utilisateur`
--

CREATE TABLE IF NOT EXISTS `entreprise_utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `id_entreprise` int(11) NOT NULL,
  PRIMARY KEY (`id_utilisateur`, `id_entreprise`),
  KEY `ENTREPRISE_UTILISATEUR_fk1` (`id_utilisateur`),
  KEY `ENTREPRISE_UTILISATEUR_fk2` (`id_entreprise`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `etablissements`
--

CREATE TABLE IF NOT EXISTS `etablissement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_etablissement` varchar(255) NOT NULL,
  `siteweb_etablissement` varchar(255) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `etablissement_utilisateur`
--

CREATE TABLE IF NOT EXISTS `etablissement_utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `id_etablissement` int(11) NOT NULL,
  PRIMARY KEY (`id_utilisateur`, `id_etablissement`),
  KEY `ETABLISSEMENT_UTILISATEUR_fk1` (`id_utilisateur`),
  KEY `ETABLISSEMENT_UTILISATEUR_fk2` (`id_etablissement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `etudes`
--

CREATE TABLE IF NOT EXISTS `etudes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `diplome_etudes` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `etudes_utilisateur`
--

CREATE TABLE IF NOT EXISTS `etudes_utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `id_etudes` int(11) NOT NULL,
  PRIMARY KEY (`id_utilisateur`, `id_etudes`),
  KEY `ETUDES_UTILISATEUR_fk1` (`id_utilisateur`),
  KEY `ETUDES_UTILISATEUR_fk2` (`id_etudes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_role` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Structure de la table `roles_utilisateur`
--

CREATE TABLE IF NOT EXISTS `roles_utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  PRIMARY KEY (`id_utilisateur`, `id_role`),
  KEY `ROLES_UTILISATEUR_fk1` (`id_utilisateur`),
  KEY `ROLES_UTILISATEUR_fk2` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------



-- --------------------------------------------------------

--
-- Structure de la table `statut` (pour les anciens étudiants
--

CREATE TABLE IF NOT EXISTS `statut` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_statut` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Structure de la table `statut_ancien_etudiant`
--

CREATE TABLE IF NOT EXISTS `statut_ancien_etudiant` (
  `id_utilisateur` int(11) NOT NULL,
  `id_statut` int(11) NOT NULL,
  PRIMARY KEY (`id_utilisateur`, `id_statut`),
  KEY `STATUT_UTILISATEUR_fk1` (`id_utilisateur`),
  KEY `STATUT_UTILISATEUR_fk2` (`id_statut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------


-- --------------------------------------------------------

--
-- Structure de la table `poste`
--

CREATE TABLE IF NOT EXISTS `poste` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_poste` varchar(255) NOT NULL,
--  `description_poste` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `poste_dans_entreprise`
--

CREATE TABLE IF NOT EXISTS `poste_dans_entreprise` (
  `id_poste` int(11) NOT NULL,
  `id_entreprise` int(11) NOT NULL,
  PRIMARY KEY (`id_poste`, `id_entreprise`),
  KEY `POSTE_DANS_ENTREPRISE_fk1` (`id_poste`),
  KEY `POSTE_DANS_ENTREPRISE_fk2` (`id_entreprise`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `poste_utilisateur`
--

CREATE TABLE IF NOT EXISTS `poste_utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `id_poste` int(11) NOT NULL,
  PRIMARY KEY (`id_utilisateur`, `id_poste`),
  KEY `POSTE_UTILISATEUR_fk1` (`id_utilisateur`),
  KEY `POSTE_UTILISATEUR_fk2` (`id_poste`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `cle_activation` varchar(8) NOT NULL,
  `compte_active` enum('0','1') NOT NULL DEFAULT 0, -- Ce nest pas mieux BOOLEAN ? --
  `nom` varchar(255) NOT NULL,
  `nom_patronymique` varchar(255) NULL,
  `prenom` varchar(255) NOT NULL,
  `naissance` date NOT NULL,
  `annee_promo` year(4) NOT NULL,
  `date_inscription` int(10) NOT NULL DEFAULT 0,
  `date_maj_profil` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE IF NOT EXISTS `pays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_pays` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
CREATE TABLE IF NOT EXISTS `ville` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`nom` varchar(50) NOT NULL,
	`cp` varchar(5) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
CREATE TABLE IF NOT EXISTS `ville_pays` (
  `id_ville` int(11) NOT NULL,
  `id_pays` int(11) NOT NULL,
  PRIMARY KEY (`id_ville`, `id_pays`),
  KEY `VILLE_PAYS_fk1` (`id_ville`),
  KEY `VILLE_PAYS_fk2` (`id_pays`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
CREATE TABLE IF NOT EXISTS `entreprise_ville` (
  `id_ville` int(11) NOT NULL,
  `id_entreprise` int(11) NOT NULL,
  PRIMARY KEY (`id_ville`, `id_entreprise`),
  KEY `ENTREPRISE_VILLE_fk1` (`id_ville`),
  KEY `ENTREPRISE_VILLE_fk2` (`id_entreprise`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
CREATE TABLE IF NOT EXISTS `etablissement_ville` (
  `id_ville` int(11) NOT NULL,
  `id_etablissement` int(11) NOT NULL,
  PRIMARY KEY (`id_ville`, `id_etablissement`),
  KEY `ETABLISSEMENT_VILLE_fk1` (`id_ville`),
  KEY `ETABLISSEMENT_VILLE_fk2` (`id_etablissement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `entreprise_utilisateur`
--
ALTER TABLE `entreprise_utilisateur`
  ADD CONSTRAINT `ENTREPRISE_UTILISATEUR_fk1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `ENTREPRISE_UTILISATEUR_fk2` FOREIGN KEY (`id_entreprise`) REFERENCES `entreprise` (`id`);

--
-- Contraintes pour la table `etudes_utilisateur`
--
ALTER TABLE `etudes_utilisateur`
  ADD CONSTRAINT `ETUDES_UTILISATEUR_fk1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `ETUDES_UTILISATEUR_fk2` FOREIGN KEY (`id_etudes`) REFERENCES `etudes` (`id`);

--
-- Contraintes pour la table `poste_dans_entreprise`
--
ALTER TABLE `poste_dans_entreprise`
  ADD CONSTRAINT `POSTE_DANS_ENTREPRISE_fk1` FOREIGN KEY (`id_poste`) REFERENCES `poste` (`id`),
  ADD CONSTRAINT `POSTE_DANS_ENTREPRISE_fk2` FOREIGN KEY (`id_entreprise`) REFERENCES `entreprise` (`id`);

--
-- Contraintes pour la table `poste_utilisateur`
--
ALTER TABLE `poste_utilisateur`
  ADD CONSTRAINT `POSTE_UTILISATEUR_fk1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `POSTE_UTILISATEUR_fk2` FOREIGN KEY (`id_poste`) REFERENCES `poste` (`id`);

--
-- Contraintes pour la table `statut`
--
ALTER TABLE `statut_ancien_etudiant`
  ADD CONSTRAINT `STATUT_UTILISATEUR_fk1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `STATUT_UTILISATEUR_fk2` FOREIGN KEY (`id_statut`) REFERENCES `statut` (`id`);
  
-- Contraintes pour la table `etablissement_utilisateur`
--
ALTER TABLE `etablissement_utilisateur`
  ADD CONSTRAINT `ETABLISSEMENT_UTILISATEUR_fk1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `ETABLISSEMENT_UTILISATEUR_fk2` FOREIGN KEY (`id_etablissement`) REFERENCES `etablissement` (`id`);

--
-- Contraintes pour la table `roles_utilisateur`
--
ALTER TABLE `roles_utilisateur`
  ADD CONSTRAINT `ROLES_UTILISATEUR_fk1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `ROLES_UTILISATEUR_fk2` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`);

--
-- Contraintes pour la table `ville_pays`
--
ALTER TABLE `ville_pays`
  ADD CONSTRAINT `VILLE_PAYS_fk1` FOREIGN KEY (`id_ville`) REFERENCES `ville` (`id`),
  ADD CONSTRAINT `VILLE_PAYS_fk2` FOREIGN KEY (`id_pays`) REFERENCES `pays` (`id`);

--
-- Contraintes pour la table `entreprise_ville`
--
ALTER TABLE `entreprise_ville`
  ADD CONSTRAINT `ENTREPRISE_VILLE_fk1` FOREIGN KEY (`id_ville`) REFERENCES `ville` (`id`),
  ADD CONSTRAINT `ENTREPRISE_VILLE_fk2` FOREIGN KEY (`id_entreprise`) REFERENCES `entreprise` (`id`);

--
-- Contraintes pour la table `etablissement_ville`
--
ALTER TABLE `etablissement_ville`
  ADD CONSTRAINT `ETABLISSEMENT_VILLE_fk1` FOREIGN KEY (`id_ville`) REFERENCES `ville` (`id`),
  ADD CONSTRAINT `ETABLISSEMENT_VILLE_fk2` FOREIGN KEY (`id_etablissement`) REFERENCES `etablissement` (`id`);



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
