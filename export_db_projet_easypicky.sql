-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 19 sep. 2022 à 12:21
-- Version du serveur :  10.4.19-MariaDB
-- Version de PHP : 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_easypicky`
--
CREATE DATABASE IF NOT EXISTS `db_easypicky` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_easypicky`;

-- --------------------------------------------------------

--
-- Structure de la table `company`
--

CREATE TABLE `company` (
                           `id` int(11) NOT NULL,
                           `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `siren` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `activity_area` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `adress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `cp` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `country` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `company`
--

INSERT INTO `company` (`id`, `name`, `siren`, `activity_area`, `adress`, `cp`, `city`, `country`) VALUES
                                                                                                      (1, 'danona', '987654321', 'Lait', 'rue de la vache', '93000', 'Paris', 'France'),
                                                                                                      (2, 'barilla', '123456785', 'Pâtes', 'Boulevard du blé', '06000', 'Nice', 'France');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
                                               `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
                                               `executed_at` datetime DEFAULT NULL,
                                               `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
                                                                                           ('DoctrineMigrations\\Version20220915090532', '2022-09-15 11:05:42', 66),
                                                                                           ('DoctrineMigrations\\Version20220915090914', '2022-09-15 11:09:25', 120);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
                        `id` int(11) NOT NULL,
                        `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
                        `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `company_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `first_name`, `last_name`, `company_id`) VALUES
                                                                                                     (1, 'admin@mail.fr', '[\"ROLE_ADMIN\"]', '$2y$13$fKYVdSVsG.pyHEfFo5PDKOiGEwadB6Cw5AI90kc6ND63MEJeNWkNm', 'Logan', 'Moriniere', NULL),
                                                                                                     (2, 'luigi@mail.fr', '[\"ROLE_CLIENT\"]', '$2y$13$iPBqjRl3OQ5KF212gbIPWeUPep2hOVsOy3go9TqBs03kjNiilvqAa', 'Luigi', 'Pasta', 2),
                                                                                                     (3, 'john@mail.fr', '[\"ROLE_CLIENT\"]', '$2y$13$CTs.VV8g/zDRQxJNEp6NpuaG7fwDJqngjS4monM.OmHtSHbeZyB7m', 'John', 'Laitier', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `company`
--
ALTER TABLE `company`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
    ADD PRIMARY KEY (`version`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  ADD KEY `IDX_8D93D649979B1AD6` (`company_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `company`
--
ALTER TABLE `company`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
    ADD CONSTRAINT `FK_8D93D649979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
