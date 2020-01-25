-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  sam. 25 jan. 2020 à 12:14
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `dbs273161`
--

-- --------------------------------------------------------

--
-- Structure de la table `access`
--

CREATE TABLE `access` (
  `id` int(11) NOT NULL,
  `access_id` int(11) NOT NULL,
  `access_level` int(11) NOT NULL DEFAULT '0',
  `account_id` bigint(20) NOT NULL,
  `access_email` varchar(320) CHARACTER SET ascii DEFAULT NULL,
  `access_password` varchar(255) DEFAULT NULL,
  `access_name` varchar(100) DEFAULT NULL,
  `access_firstname` varchar(100) DEFAULT NULL,
  `auth_token` varchar(255) DEFAULT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `access`
--

INSERT INTO `access` (`id`, `access_id`, `access_level`, `account_id`, `access_email`, `access_password`, `access_name`, `access_firstname`, `auth_token`, `activated`) VALUES
(24, 12345678, 2, 12345678, 'mony.chhim@gmail.com', '$2y$10$LzFdF8EVheMGByvL3v4ElOBJxk5tNJ58fU0mlFnEy80R57P1cQQiS', 'CHHIM', 'Mony', NULL, 1),
(59, 742534527, 0, 331859797400599, 'serey.chhim@gmail.com', '$2y$10$UYokYWU5hcm3Sy/8tqxeJ.oRIvAA8ThBUJiTBqElZiuq5cZBDfjwe', 'CHHIM', 'Sérey', '5f6e5d563d07374c0cc3915513d2cd06b711c4a9a6799ca112e3e4af6fdcb3efad52fd8cd31af5d47e156c3d33c249c311ee2f4fb03c14f7', 1);

-- --------------------------------------------------------

--
-- Structure de la table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `account_id` bigint(11) NOT NULL,
  `account_name` text NOT NULL,
  `spend30d` decimal(10,0) NOT NULL,
  `leads30d` int(11) NOT NULL,
  `cost_per_lead30d` decimal(10,0) NOT NULL,
  `history_spend` json DEFAULT NULL,
  `history_lead` json DEFAULT NULL,
  `history_costperlead` json DEFAULT NULL,
  `history_spend_d` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `accounts`
--

INSERT INTO `accounts` (`id`, `account_id`, `account_name`, `spend30d`, `leads30d`, `cost_per_lead30d`, `history_spend`, `history_lead`, `history_costperlead`, `history_spend_d`) VALUES
(1, 331859797400599, 'Campagne pub Actisweep', '894', 56, '16', '{\"2019-01-01\": {\"spend\": \"2047.05\"}, \"2019-02-01\": {\"spend\": \"1176.45\"}, \"2019-03-01\": {\"spend\": \"968.1\"}, \"2019-04-01\": {\"spend\": \"1430.49\"}, \"2019-05-01\": {\"spend\": \"863.66\"}, \"2019-06-01\": {\"spend\": \"1543.16\"}, \"2019-07-01\": {\"spend\": \"1258.72\"}, \"2019-08-01\": {\"spend\": \"721.64\"}, \"2019-09-01\": {\"spend\": \"1245.26\"}, \"2019-10-01\": {\"spend\": \"1534.7\"}, \"2019-11-01\": {\"spend\": \"1454.52\"}, \"2019-12-01\": {\"spend\": \"871.48\"}, \"2020-01-01\": {\"spend\": \"360.31\"}}', '{\"2019-01-01\": \"91\", \"2019-02-01\": \"70\", \"2019-03-01\": \"27\", \"2019-04-01\": \"5\", \"2019-05-01\": \"20\", \"2019-06-01\": \"83\", \"2019-07-01\": \"70\", \"2019-08-01\": \"41\", \"2019-09-01\": \"55\", \"2019-10-01\": \"66\", \"2019-11-01\": \"115\", \"2019-12-01\": \"55\", \"2020-01-01\": \"26\"}', '{\"2019-01-01\": \"21.375055\", \"2019-02-01\": \"21.375055\", \"2019-03-01\": \"21.375055\", \"2019-04-01\": \"21.375055\", \"2019-05-01\": \"21.375055\", \"2019-06-01\": \"21.375055\", \"2019-07-01\": \"21.375055\", \"2019-08-01\": \"21.375055\", \"2019-09-01\": \"21.375055\", \"2019-10-01\": \"21.375055\", \"2019-11-01\": \"21.375055\", \"2019-12-01\": \"21.375055\", \"2020-01-01\": \"21.375055\"}', 'null'),
(2, 363462593822925, 'Esther Keller', '0', 0, '0', NULL, 'null', '0', 'null'),
(3, 10152389737899390, 'Pichat Michael', '0', 0, '0', NULL, 'null', '0', 'null');

-- --------------------------------------------------------

--
-- Structure de la table `ads`
--

CREATE TABLE `ads` (
  `id` int(11) NOT NULL,
  `account_id` bigint(20) NOT NULL,
  `adset_id` bigint(20) NOT NULL,
  `ad_id` bigint(20) NOT NULL,
  `optimization_goal` text NOT NULL,
  `ad_name` varchar(100) NOT NULL,
  `spend30d` decimal(10,0) NOT NULL,
  `cpm30d` int(11) NOT NULL,
  `clicks30d` int(11) NOT NULL,
  `cost_per_click30d` float NOT NULL,
  `leads30d` int(11) NOT NULL,
  `cost_per_lead30d` decimal(10,0) NOT NULL,
  `sell_rate30d` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ads`
--

INSERT INTO `ads` (`id`, `account_id`, `adset_id`, `ad_id`, `optimization_goal`, `ad_name`, `spend30d`, `cpm30d`, `clicks30d`, `cost_per_click30d`, `leads30d`, `cost_per_lead30d`, `sell_rate30d`) VALUES
(1, 331859797400599, 23843854426790061, 23843854426800061, 'LEAD_GENERATION', 'Eleveurs vidéo', '9', 2, 119, 0.073445, 1, '9', '1'),
(2, 331859797400599, 23843854426790061, 23843854426810061, 'LEAD_GENERATION', 'Agriculteurs vidéo', '11', 2, 196, 0.058418, 1, '11', '1'),
(3, 331859797400599, 23843844112200061, 23843844112290061, 'THRUPLAY', 'Actisweep - Video views', '262', 1, 10128, 0.025848, 90388, '0', '1'),
(4, 331859797400599, 23843692114540061, 23843692120830061, 'LEAD_GENERATION', 'Agriculteurs vidéo', '331', 3, 5054, 0.065576, 31, '11', '1'),
(5, 331859797400599, 23843692114540061, 23843692114800061, 'LEAD_GENERATION', 'Eleveurs vidéo', '248', 3, 3429, 0.072316, 20, '12', '1');

-- --------------------------------------------------------

--
-- Structure de la table `adsets`
--

CREATE TABLE `adsets` (
  `id` int(11) NOT NULL,
  `account_id` bigint(20) NOT NULL,
  `adset_id` bigint(20) NOT NULL,
  `optimization_goal` text NOT NULL,
  `adset_name` varchar(100) NOT NULL,
  `spend30d` decimal(10,0) NOT NULL,
  `cpm30d` int(11) NOT NULL,
  `clicks30d` int(11) NOT NULL,
  `cost_per_click30d` float NOT NULL,
  `leads30d` int(11) NOT NULL,
  `cost_per_lead30d` decimal(10,0) NOT NULL,
  `sell_rate30d` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `adsets`
--

INSERT INTO `adsets` (`id`, `account_id`, `adset_id`, `optimization_goal`, `adset_name`, `spend30d`, `cpm30d`, `clicks30d`, `cost_per_click30d`, `leads30d`, `cost_per_lead30d`, `sell_rate30d`) VALUES
(11, 331859797400599, 23843854426790061, 'LEAD_GENERATION', 'RTG - VV nettoyage routes', '25', 2, 430, 0.057814, 2, '12', '1'),
(12, 331859797400599, 23843844112200061, 'THRUPLAY', 'FR - 18+', '300', 1, 13155, 0.022783, 108094, '0', '1'),
(17, 331859797400599, 23843692114540061, 'LEAD_GENERATION', 'INT - tractors', '574', 2, 8982, 0.06395, 60, '10', '1');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` text NOT NULL,
  `user_password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`) VALUES
(1, 'admin', '$2y$10$/vqKGkcPKVqn9YeV9Zu7Ce.WpCtVfSyc6W9dUcByKVkkmIslQvicm');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `adsets`
--
ALTER TABLE `adsets`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `access`
--
ALTER TABLE `access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT pour la table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `adsets`
--
ALTER TABLE `adsets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
