-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Dim 03 Juin 2012 à 16:50
-- Version du serveur: 5.1.61
-- Version de PHP: 5.3.3-7+squeeze9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `annuaire_defi`
--

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

CREATE TABLE IF NOT EXISTS `entreprise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_entreprise` varchar(255) NOT NULL,
  `siteweb_entreprise` varchar(255) DEFAULT NULL,
  `secteur_activite` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `entreprise`
--


-- --------------------------------------------------------

--
-- Structure de la table `entreprise_utilisateur`
--

CREATE TABLE IF NOT EXISTS `entreprise_utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `id_entreprise` int(11) NOT NULL,
  PRIMARY KEY (`id_utilisateur`,`id_entreprise`),
  KEY `ENTREPRISE_UTILISATEUR_fk1` (`id_utilisateur`),
  KEY `ENTREPRISE_UTILISATEUR_fk2` (`id_entreprise`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `entreprise_utilisateur`
--


-- --------------------------------------------------------

--
-- Structure de la table `entreprise_ville`
--

CREATE TABLE IF NOT EXISTS `entreprise_ville` (
  `id_ville` int(11) NOT NULL,
  `id_entreprise` int(11) NOT NULL,
  PRIMARY KEY (`id_ville`,`id_entreprise`),
  KEY `ENTREPRISE_VILLE_fk1` (`id_ville`),
  KEY `ENTREPRISE_VILLE_fk2` (`id_entreprise`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `entreprise_ville`
--


-- --------------------------------------------------------

--
-- Structure de la table `etablissement`
--

CREATE TABLE IF NOT EXISTS `etablissement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_etablissement` varchar(255) NOT NULL,
  `siteweb_etablissement` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `etablissement`
--

INSERT INTO `etablissement` (`id`, `nom_etablissement`, `siteweb_etablissement`) VALUES
(1, 'Université Paris Ouest Nanterre La Défense', 'www.u-paris10.fr');

-- --------------------------------------------------------

--
-- Structure de la table `etablissement_utilisateur`
--

CREATE TABLE IF NOT EXISTS `etablissement_utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `id_etablissement` int(11) NOT NULL,
  PRIMARY KEY (`id_utilisateur`,`id_etablissement`),
  KEY `ETABLISSEMENT_UTILISATEUR_fk1` (`id_utilisateur`),
  KEY `ETABLISSEMENT_UTILISATEUR_fk2` (`id_etablissement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `etablissement_utilisateur`
--


-- --------------------------------------------------------

--
-- Structure de la table `etablissement_ville`
--

CREATE TABLE IF NOT EXISTS `etablissement_ville` (
  `id_ville` int(11) NOT NULL,
  `id_etablissement` int(11) NOT NULL,
  PRIMARY KEY (`id_ville`,`id_etablissement`),
  KEY `ETABLISSEMENT_VILLE_fk1` (`id_ville`),
  KEY `ETABLISSEMENT_VILLE_fk2` (`id_etablissement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `etablissement_ville`
--

INSERT INTO `etablissement_ville` (`id_ville`, `id_etablissement`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `etudes`
--

CREATE TABLE IF NOT EXISTS `etudes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `diplome_etudes` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `etudes`
--


-- --------------------------------------------------------

--
-- Structure de la table `etudes_utilisateur`
--

CREATE TABLE IF NOT EXISTS `etudes_utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `id_etudes` int(11) NOT NULL,
  PRIMARY KEY (`id_utilisateur`,`id_etudes`),
  KEY `ETUDES_UTILISATEUR_fk1` (`id_utilisateur`),
  KEY `ETUDES_UTILISATEUR_fk2` (`id_etudes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `etudes_utilisateur`
--


-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE IF NOT EXISTS `pays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_pays` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `pays`
--

INSERT INTO `pays` (`id`, `nom_pays`) VALUES
(1, 'France');

-- --------------------------------------------------------

--
-- Structure de la table `poste`
--

CREATE TABLE IF NOT EXISTS `poste` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_poste` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `poste`
--


-- --------------------------------------------------------

--
-- Structure de la table `poste_dans_entreprise`
--

CREATE TABLE IF NOT EXISTS `poste_dans_entreprise` (
  `id_poste` int(11) NOT NULL,
  `id_entreprise` int(11) NOT NULL,
  PRIMARY KEY (`id_poste`,`id_entreprise`),
  KEY `POSTE_DANS_ENTREPRISE_fk1` (`id_poste`),
  KEY `POSTE_DANS_ENTREPRISE_fk2` (`id_entreprise`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `poste_dans_entreprise`
--


-- --------------------------------------------------------

--
-- Structure de la table `poste_utilisateur`
--

CREATE TABLE IF NOT EXISTS `poste_utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `id_poste` int(11) NOT NULL,
  PRIMARY KEY (`id_utilisateur`,`id_poste`),
  KEY `POSTE_UTILISATEUR_fk1` (`id_utilisateur`),
  KEY `POSTE_UTILISATEUR_fk2` (`id_poste`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `poste_utilisateur`
--


-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_role` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `role`
--

INSERT INTO `role` (`id`, `nom_role`) VALUES
(1, 'Ancien étudiant'),
(2, 'Étudiant actuel'),
(3, 'Enseignant'),
(4, 'Administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `roles_utilisateur`
--

CREATE TABLE IF NOT EXISTS `roles_utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  PRIMARY KEY (`id_utilisateur`,`id_role`),
  KEY `ROLES_UTILISATEUR_fk1` (`id_utilisateur`),
  KEY `ROLES_UTILISATEUR_fk2` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `roles_utilisateur`
--

INSERT INTO `roles_utilisateur` (`id_utilisateur`, `id_role`) VALUES
(14, 2),
(19, 1);

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

CREATE TABLE IF NOT EXISTS `statut` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_statut` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `statut`
--

INSERT INTO `statut` (`id`, `nom_statut`) VALUES
(1, 'Profil à remplir'),
(2, 'En poste'),
(3, 'En formation'),
(4, 'En recherche d''emploi');

-- --------------------------------------------------------

--
-- Structure de la table `statut_ancien_etudiant`
--

CREATE TABLE IF NOT EXISTS `statut_ancien_etudiant` (
  `id_utilisateur` int(11) NOT NULL,
  `id_statut` int(11) NOT NULL,
  PRIMARY KEY (`id_utilisateur`,`id_statut`),
  KEY `STATUT_UTILISATEUR_fk1` (`id_utilisateur`),
  KEY `STATUT_UTILISATEUR_fk2` (`id_statut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `statut_ancien_etudiant`
--

INSERT INTO `statut_ancien_etudiant` (`id_utilisateur`, `id_statut`) VALUES
(19, 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) NOT NULL,
  `mail_pro` varchar(255) DEFAULT NULL,
  `pass` varchar(255) NOT NULL,
  `cle_activation` varchar(8) NOT NULL,
  `compte_active` tinyint(1) NOT NULL DEFAULT '0',
  `nom` varchar(255) NOT NULL,
  `nom_patronymique` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) NOT NULL,
  `naissance` date NOT NULL,
  `annee_promo` year(4) DEFAULT NULL,
  `date_inscription` date DEFAULT NULL,
  `date_maj_profil` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `mail`, `mail_pro`, `pass`, `cle_activation`, `compte_active`, `nom`, `nom_patronymique`, `prenom`, `naissance`, `annee_promo`, `date_inscription`, `date_maj_profil`) VALUES
(14, 'aanitah@gmail.com', '', 'asD5QWBvWZuV.', '', 0, 'mazur', '', 'anita', '1984-05-25', 2011, '2012-06-02', '2012-06-02'),
(19, 'penelope.lanoie@gmail.com', '', 'asD5QWBvWZuV.', '', 0, 'lanoie', '', 'penelope', '1980-02-26', 2000, '2012-06-02', '2012-06-02');

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE IF NOT EXISTS `ville` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `cp` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `ville`
--

INSERT INTO `ville` (`id`, `nom`, `cp`) VALUES
(1, 'Nanterre', '92000'),
(2, 'Nanterre', '92001');

-- --------------------------------------------------------

--
-- Structure de la table `ville_pays`
--

CREATE TABLE IF NOT EXISTS `ville_pays` (
  `id_ville` int(11) NOT NULL,
  `id_pays` int(11) NOT NULL,
  PRIMARY KEY (`id_ville`,`id_pays`),
  KEY `VILLE_PAYS_fk1` (`id_ville`),
  KEY `VILLE_PAYS_fk2` (`id_pays`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `ville_pays`
--

INSERT INTO `ville_pays` (`id_ville`, `id_pays`) VALUES
(2, 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `entreprise_utilisateur`
--
ALTER TABLE `entreprise_utilisateur`
  ADD CONSTRAINT `ENTREPRISE_UTILISATEUR_fk1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `ENTREPRISE_UTILISATEUR_fk2` FOREIGN KEY (`id_entreprise`) REFERENCES `entreprise` (`id`);

--
-- Contraintes pour la table `entreprise_ville`
--
ALTER TABLE `entreprise_ville`
  ADD CONSTRAINT `ENTREPRISE_VILLE_fk1` FOREIGN KEY (`id_ville`) REFERENCES `ville` (`id`),
  ADD CONSTRAINT `ENTREPRISE_VILLE_fk2` FOREIGN KEY (`id_entreprise`) REFERENCES `entreprise` (`id`);

--
-- Contraintes pour la table `etablissement_utilisateur`
--
ALTER TABLE `etablissement_utilisateur`
  ADD CONSTRAINT `ETABLISSEMENT_UTILISATEUR_fk1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `ETABLISSEMENT_UTILISATEUR_fk2` FOREIGN KEY (`id_etablissement`) REFERENCES `etablissement` (`id`);

--
-- Contraintes pour la table `etablissement_ville`
--
ALTER TABLE `etablissement_ville`
  ADD CONSTRAINT `ETABLISSEMENT_VILLE_fk1` FOREIGN KEY (`id_ville`) REFERENCES `ville` (`id`),
  ADD CONSTRAINT `ETABLISSEMENT_VILLE_fk2` FOREIGN KEY (`id_etablissement`) REFERENCES `etablissement` (`id`);

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
-- Contraintes pour la table `roles_utilisateur`
--
ALTER TABLE `roles_utilisateur`
  ADD CONSTRAINT `ROLES_UTILISATEUR_fk1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `ROLES_UTILISATEUR_fk2` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`);

--
-- Contraintes pour la table `statut_ancien_etudiant`
--
ALTER TABLE `statut_ancien_etudiant`
  ADD CONSTRAINT `STATUT_UTILISATEUR_fk1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `STATUT_UTILISATEUR_fk2` FOREIGN KEY (`id_statut`) REFERENCES `statut` (`id`);

--
-- Contraintes pour la table `ville_pays`
--
ALTER TABLE `ville_pays`
  ADD CONSTRAINT `VILLE_PAYS_fk1` FOREIGN KEY (`id_ville`) REFERENCES `ville` (`id`),
  ADD CONSTRAINT `VILLE_PAYS_fk2` FOREIGN KEY (`id_pays`) REFERENCES `pays` (`id`);
