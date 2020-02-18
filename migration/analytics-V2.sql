-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  lun. 17 fév. 2020 à 20:22
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
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `last_connection` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `access`
--

INSERT INTO `access` (`id`, `access_id`, `access_level`, `account_id`, `access_email`, `access_password`, `access_name`, `access_firstname`, `auth_token`, `activated`, `last_connection`) VALUES
(24, 12345678, 2, 12345678, 'mony@monymakerz.com', '$2y$10$LzFdF8EVheMGByvL3v4ElOBJxk5tNJ58fU0mlFnEy80R57P1cQQiS', 'CHHIM', 'Mony', NULL, 1, NULL),
(67, 291977140, 0, 331859797400599, 'serey.chhim@gmail.com', '$2y$10$biojIj290P/D0xm5lakBS.KqFrpX6fhQfgLUTnkUrJAKHRyNDdhpS', 'CHHIM', 'Sérey', 'c0c0449938b4607ac206fdf58a0bf043bcf9acd7a7a00321d56da41fffc80d760bfb804c13d4389941573ee4c679df81c95722f30dd8fabf', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `account_id` bigint(11) NOT NULL,
  `account_name` text NOT NULL,
  `spend30d` decimal(10,2) NOT NULL,
  `leads30d` int(11) NOT NULL,
  `cost_per_lead30d` decimal(10,2) NOT NULL,
  `history_spend` text,
  `history_spend_test` text,
  `history_lead` text,
  `history_costperlead` text,
  `history_spend_d` text,
  `history_lead_d` text,
  `history_costperlead_d` text,
  `history_lead_14d` text NOT NULL,
  `history_spend_14d` text NOT NULL,
  `history_costperlead_14d` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `accounts`
--

INSERT INTO `accounts` (`id`, `account_id`, `account_name`, `spend30d`, `leads30d`, `cost_per_lead30d`, `history_spend`, `history_spend_test`, `history_lead`, `history_costperlead`, `history_spend_d`, `history_lead_d`, `history_costperlead_d`, `history_lead_14d`, `history_spend_14d`, `history_costperlead_14d`) VALUES
(1, 331859797400599, 'Campagne pub Actisweep', '897.59', 90, '9.97', '{\"January 2019\":{\"spend\":\"2047.05\"},\"February 2019\":{\"spend\":\"1176.45\"},\"March 2019\":{\"spend\":\"968.1\"},\"April 2019\":{\"spend\":\"1430.49\"},\"May 2019\":{\"spend\":\"863.66\"},\"June 2019\":{\"spend\":\"1543.16\"},\"July 2019\":{\"spend\":\"1258.72\"},\"August 2019\":{\"spend\":\"721.64\"},\"September 2019\":{\"spend\":\"1245.26\"},\"October 2019\":{\"spend\":\"1534.7\"},\"November 2019\":{\"spend\":\"1454.52\"},\"December 2019\":{\"spend\":\"871.48\"},\"January 2020\":{\"spend\":\"360.31\"}}', '{\"January 2019\":{\"spend\":\"2047.05\"},\"February 2019\":{\"spend\":\"1176.45\"},\"March 2019\":{\"spend\":\"968.1\"},\"April 2019\":{\"spend\":\"1430.49\"},\"May 2019\":{\"spend\":\"863.66\"},\"June 2019\":{\"spend\":\"1543.16\"},\"July 2019\":{\"spend\":\"1258.72\"},\"August 2019\":{\"spend\":\"721.64\"},\"September 2019\":{\"spend\":\"1245.26\"},\"October 2019\":{\"spend\":\"1534.7\"},\"November 2019\":{\"spend\":\"1454.52\"},\"December 2019\":{\"spend\":\"871.48\"},\"January 2020\":{\"spend\":\"360.31\"}}', '{\"January 2019\":\"91\",\"February 2019\":\"70\",\"March 2019\":\"27\",\"April 2019\":\"5\",\"May 2019\":\"20\",\"June 2019\":\"83\",\"July 2019\":\"70\",\"August 2019\":\"41\",\"September 2019\":\"55\",\"October 2019\":\"66\",\"November 2019\":\"115\",\"December 2019\":\"55\",\"January 2020\":\"26\"}', '{\"January 2019\":\"22.495055\",\"February 2019\":\"16.806429\",\"March 2019\":\"35.855556\",\"April 2019\":\"286.098\",\"May 2019\":\"43.183\",\"June 2019\":\"18.592289\",\"July 2019\":\"17.981714\",\"August 2019\":\"17.600976\",\"September 2019\":\"22.641091\",\"October 2019\":\"23.25303\",\"November 2019\":\"12.648\",\"December 2019\":\"15.845091\",\"January 2020\":\"13.858077\"}', '{\"2020-02-07\":{\"spend\":\"30.08\"},\"2020-02-08\":{\"spend\":\"30.14\"},\"2020-02-09\":{\"spend\":\"30.13\"},\"2020-02-10\":{\"spend\":\"30.24\"},\"2020-02-11\":{\"spend\":\"30.1\"},\"2020-02-12\":{\"spend\":\"29.81\"},\"2020-02-13\":{\"spend\":\"29.23\"},\"2020-02-14\":{\"spend\":\"14.71\"}}', '{\"2020-02-07\":\"2\",\"2020-02-08\":\"1\",\"2020-02-09\":\"6\",\"2020-02-10\":\"9\",\"2020-02-11\":\"4\",\"2020-02-12\":\"1\",\"2020-02-13\":\"1\",\"2020-02-14\":\"1\"}', '{\"2020-02-07\":\"15.04\",\"2020-02-08\":\"30.14\",\"2020-02-09\":\"5.021667\",\"2020-02-10\":\"3.36\",\"2020-02-11\":\"7.525\",\"2020-02-12\":\"29.81\",\"2020-02-13\":\"29.81\",\"2020-02-14\":\"29.81\"}', '{\"2020-01-31\":\"5\",\"2020-02-01\":\"4\",\"2020-02-02\":\"5\",\"2020-02-03\":\"2\",\"2020-02-04\":\"7\",\"2020-02-05\":\"4\",\"2020-02-06\":\"4\",\"2020-02-07\":\"2\",\"2020-02-08\":\"1\",\"2020-02-09\":\"6\",\"2020-02-10\":\"9\",\"2020-02-11\":\"4\",\"2020-02-12\":\"1\",\"2020-02-13\":\"1\",\"2020-02-14\":\"1\"}', '{\"2020-01-31\":{\"spend\":\"28.94\"},\"2020-02-01\":{\"spend\":\"30.26\"},\"2020-02-02\":{\"spend\":\"30.14\"},\"2020-02-03\":{\"spend\":\"29.32\"},\"2020-02-04\":{\"spend\":\"30.28\"},\"2020-02-05\":{\"spend\":\"29.49\"},\"2020-02-06\":{\"spend\":\"30.55\"},\"2020-02-07\":{\"spend\":\"30.08\"},\"2020-02-08\":{\"spend\":\"30.14\"},\"2020-02-09\":{\"spend\":\"30.13\"},\"2020-02-10\":{\"spend\":\"30.24\"},\"2020-02-11\":{\"spend\":\"30.1\"},\"2020-02-12\":{\"spend\":\"29.81\"},\"2020-02-13\":{\"spend\":\"29.23\"},\"2020-02-14\":{\"spend\":\"19.15\"}}', '{\"2020-01-31\":\"5.788\",\"2020-02-01\":\"7.565\",\"2020-02-02\":\"6.028\",\"2020-02-03\":\"14.66\",\"2020-02-04\":\"4.325714\",\"2020-02-05\":\"7.3725\",\"2020-02-06\":\"7.6375\",\"2020-02-07\":\"15.04\",\"2020-02-08\":\"30.14\",\"2020-02-09\":\"5.021667\",\"2020-02-10\":\"3.36\",\"2020-02-11\":\"7.525\",\"2020-02-12\":\"29.81\",\"2020-02-13\":\"29.81\",\"2020-02-14\":\"29.81\"}'),
(2, 363462593822925, 'Esther Keller', '2623.40', -1, '-1.00', NULL, NULL, 'null', '0', 'null', NULL, NULL, '', '', ''),
(3, 10152389737899390, 'Pichat Michael', '0.00', 0, '0.00', NULL, NULL, 'null', '0', 'null', NULL, NULL, '', '', '');

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
  `spend30d` decimal(10,2) NOT NULL,
  `cpm30d` int(11) NOT NULL,
  `clicks30d` int(11) NOT NULL,
  `cost_per_click30d` float NOT NULL,
  `leads30d` int(11) NOT NULL,
  `cost_per_lead30d` decimal(10,2) NOT NULL,
  `sell_rate30d` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ads`
--

INSERT INTO `ads` (`id`, `account_id`, `adset_id`, `ad_id`, `optimization_goal`, `ad_name`, `spend30d`, `cpm30d`, `clicks30d`, `cost_per_click30d`, `leads30d`, `cost_per_lead30d`, `sell_rate30d`) VALUES
(1, 331859797400599, 23843854426790061, 23843854426800061, 'LEAD_GENERATION', 'Eleveurs vidéo', '9.00', 2, 119, 0.073445, 1, '9.00', '1.00'),
(2, 331859797400599, 23843854426790061, 23843854426810061, 'LEAD_GENERATION', 'Agriculteurs vidéo', '11.00', 2, 196, 0.058418, 1, '11.00', '1.00'),
(3, 331859797400599, 23843844112200061, 23843844112290061, 'THRUPLAY', 'Actisweep - Video views', '262.00', 1, 10128, 0.025848, 90388, '0.00', '1.00'),
(4, 331859797400599, 23843692114540061, 23843692120830061, 'LEAD_GENERATION', 'Agriculteurs vidéo', '331.00', 3, 5054, 0.065576, 31, '11.00', '1.00'),
(5, 331859797400599, 23843692114540061, 23843692114800061, 'LEAD_GENERATION', 'Eleveurs vidéo', '248.00', 3, 3429, 0.072316, 20, '12.00', '1.00'),
(6, 331859797400599, 23843792651570061, 23843792651590061, 'LEAD_GENERATION', 'Agriculteurs vidéo', '163.00', 3, 1990, 0.081724, 21, '8.00', '1.00'),
(7, 331859797400599, 23843792651570061, 23843792651600061, 'LEAD_GENERATION', 'Eleveurs vidéo', '240.00', 3, 3060, 0.078516, 27, '9.00', '1.00');

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
  `spend30d` decimal(10,2) NOT NULL,
  `cpm30d` int(11) NOT NULL,
  `clicks30d` int(11) NOT NULL,
  `cost_per_click30d` float NOT NULL,
  `leads30d` int(11) NOT NULL,
  `cost_per_lead30d` decimal(10,2) NOT NULL,
  `sell_rate30d` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `adsets`
--

INSERT INTO `adsets` (`id`, `account_id`, `adset_id`, `optimization_goal`, `adset_name`, `spend30d`, `cpm30d`, `clicks30d`, `cost_per_click30d`, `leads30d`, `cost_per_lead30d`, `sell_rate30d`) VALUES
(11, 331859797400599, 23843854426790061, 'LEAD_GENERATION', 'RTG - VV nettoyage routes', '5.00', 2, 104, 0.04375, 2, '2.00', '1.00'),
(12, 331859797400599, 23843844112200061, 'THRUPLAY', 'FR - 18+', '161.00', 1, 2763, 0.058205, 63955, '0.00', '1.00'),
(17, 331859797400599, 23843692114540061, 'LEAD_GENERATION', 'INT - tractors (old audience, replace it later by a bigger one)', '325.00', 2, 5716, 0.056912, 42, '8.00', '1.00'),
(18, 331859797400599, 23843792651570061, 'LEAD_GENERATION', 'Lookalike (FR, 1%) - Opened form Agriculteurs V1 - 7d', '403.00', 3, 5050, 0.07978, 48, '8.00', '1.00');

-- --------------------------------------------------------

--
-- Structure de la table `glossary`
--

CREATE TABLE `glossary` (
  `id` int(11) NOT NULL,
  `first_letter` varchar(1) NOT NULL,
  `word` text NOT NULL,
  `definition` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `glossary`
--

INSERT INTO `glossary` (`id`, `first_letter`, `word`, `definition`) VALUES
(1, 'A', 'Adresse IP', 'Adresse qui permet au serveur de savoir où envoyer les fichiers. S\'affiche sous la forme de chiffre.\r\nExemple : 123.45.67.890'),
(2, 'A', 'Anonymiser l\'information', 'L’anonymisation des informations est un processus qui transforme les données personnelles de telle sorte que ces dernières ne puissent pas être ré-identifiées après traitement. Ce procédé doit être irréversible, on ne doit pas pouvoir désanonymiser des informations.\r\n\r\n'),
(3, 'A', 'Audience', 'L’audience est constituée de l’ensemble des personnes touchées par un média ou support de communication. Il peut donc s’agir aussi bien de téléspectateurs, que d’auditeurs ou visiteurs d’un site web.L’audience publicitaire désigne l’ensemble des personnes exposées à un message publicitaire diffusé sur un support.\r\n\r\n'),
(4, 'A', 'Article', 'Ou billet de blog, est un message posté sur un blog par son auteur.\r\n'),
(5, 'A', 'Application mobile\r\n', 'Une application mobile est un programme téléchargeable de façon gratuite ou payante et exécutable à partir du système d’exploitation du téléphone.\r\n\r\n'),
(6, 'A', 'Attribut ALT\r\n', 'Parfois appelé balise ALT désigne le texte alternatif d\'une image sur un site web. Il permet à l\'utilisateur de voir la définition de l\'image au passage de la souris. Il indique aussi aux moteurs de recherches ce que contient l\'image.'),
(7, 'A', 'A/B Testing', 'Campagne de test sur deux versions différentes d\'une landing page afin de déterminer la plus performante. Une moitié du trafic est dirigé vers la version A, l\'autre moitié vers la version B. Les résultats de chaque version sont alors comparés.\r\n\r\n'),
(8, 'B', 'B.A.N.T', 'Acronyme anglais pour : Budget, Authority, Need et Time.\r\nMethologie utilisée pour qualifier ou scorer des prospects ou contacts commerciaux B to B.'),
(9, 'B', 'Balise Meta description\r\n', 'Fournit un bref résumé (pas plus de 160 caractères) du contenu d\'une page web. Ce résumé, placé sur les moteurs de recherches, doit être optimisé afin d\'inciter les internautes à visiter votre page page.\r\n\r\nRenseigner cette balise de meta description est indispensable car, elle joue un grand rôle dans le référencement naturel de la page.'),
(10, 'B', 'Blockchain', 'La blockchain est une technologie de stockage et de transmission d’informations, transparente, sécurisée, et fonctionnant sans organe central de contrôle. Il s\'agit d\'une base de données distribuée qui gère une liste d\'enregistrements protégés contre la falsification ou la modification par les nœuds de stockage. Une blockchain est donc une chronologie décentralisée et sécurisée de toutes les transactions effectuées depuis le démarrage du système réparti.\r\n\r\n'),
(11, 'B', 'Blog', 'Une page personnelle ou d’entreprise comportant des avis, des liens ou des chroniques périodiquement créés par son ou ses auteurs sous forme de posts.\r\n\r\n'),
(12, 'B', 'Buyer Journey\r\n', 'Processus actif  de recherche par lequel passe un prospect avant de conclure un achat. Il permet d’appréhender les étapes clés par lesquelles passe un consommateur potentiel avant de conclure son achat.'),
(13, 'B', 'Buyer Persona\r\n', 'Représentation semi-fictive du client idéal basée sur des études du marché, des données réelles de vos clients existants et une certaine spéculation (démographie, comportements, motivations et objectifs). Il s\'agit en quelque sorte de dresser le profil de votre acheteur type.\r\n\r\n'),
(14, 'C', 'Calendrier éditorial\r\n', 'Le calendrier éditorial est un outil très pratique (et puissant) pour simplifier la gestion de communauté. C\'est un guide permettant de planifier ce qui sera publié sur vos différentes plateformes sociales ainsi que de prévoir les évènements majeurs qui auront un impact sur votre gestion de contenu. Téléchargez un modèle ici\r\n\r\n'),
(15, 'C', 'Call-To-Action (CTA)\r\n', 'Formulation (souvent sous forme de bouton) incitant le lecteur à entreprendre plus ou moins immédiatement une action recherchée par l’annonceur.\r\n\r\n'),
(16, 'C', 'Campagne adwords\r\n', 'Il s\'agit de mettre en place une campagne de publicité digitale en utilisant la plateforme Google adwords. Ce programme permet aux annonceurs de poster leurs liens sponsorisés sur Google ainsi que sur d\'autres domaines web.\r\n'),
(17, 'C', 'Click & Collect\r\n', 'Désigne un service permettant aux consommateurs de commander en ligne pour ensuite retirer leur article dans un magasin de proximité.\r\n\r\n'),
(18, 'C', 'CRM (Customer RelationShip Management)\r\n', 'Ensemble des outils et techniques destinés à capter, traiter, analyser les informations relatives aux clients et aux prospects, dans le but de les fidéliser en leur offrant le meilleur service.\r\n'),
(19, 'C', 'Coût par clic\r\n', 'Modèle publicitaire reposant sur la facturation d’un espace publicitaire en fonction du nombre de clics des internautes sur la publicité. Le clic se traduit normalement par une visite sur un site.\r\n'),
(20, 'C', 'Coût par impression\r\n', 'Unité de mesure permettant de déterminer le coût d’achat d’espace sur un site internet. Ce coût est fonction du nombre d’affichages de la publicité.\r\n'),
(21, 'D', 'Device', ' Se réfère aux différents périphériques utilisés dans le domaine de l‘informatique (téléphone, PC, Scanner etc.)\r\n\r\n'),
(22, 'D', 'Digital natives\r\n', 'C’est une expression américaine qui désigne la génération ayant grandi en même temps que le développement d’Internet. On considère généralement que les \"digital natives\" sont nées entre 1980 et 2000. Ce sont donc des utilisateurs naturels et intensifs d’Internet et des téléphones portables. L’utilisation du webmarketing sur cette cible est donc relativement intensive. \r\n\r\n'),
(23, 'D', 'Display', 'Désigne l’affichage de publicité sur Internet avec achat d’espace utilisant des éléments graphiques ou visuels. Différents formats publicitaires sont disponibles avec le display.\r\n\r\n'),
(24, 'E', 'E-book\r\n', 'Contraction de « electronic book » en anglais, appelé en français Livre électronique désigne un livre, un manuel, un guide ou toutes autres publications que l’on peut consulter, distribuer ou conserver sous forme de fichiers numériques.\r\n'),
(25, 'E', 'Ecosystème digital\r\n', 'C\'est un complexe dynamique composé de site web, de publicité par mot-clé, de bannières, de réseaux sociaux, d\'engins de recherche, de courriels, de vidéo, de son, de texte, d\'images et d\'usagers agissant en interaction en tant qu\'unité fonctionnelle.\r\n'),
(26, 'E', 'E-mail marketing\r\n', 'Ensemble des utilisations de l’e-mail faites à des fins marketing. \r\n'),
(27, 'E', 'Etude de cas (Case study)\r\n', 'Étude approfondie sur un cas en particulier, principalement utilisée dans le cadre du marketing, visant à montrer aux prospects les bénéfices tirés de l’usage du produit ou service.\r\n'),
(28, 'F', 'Finetech\r\n', 'L’expression FinTech combine les termes « finance » et « technologie » et désigne une start-up innovante qui utilise la technologie pour repenser les services financiers et bancaires.\r\n\r\n'),
(29, 'F', 'Follower', 'Désigne un abonné sur vos pages sociales ou blog.\r\n\r\n'),
(30, 'F', 'Formulaire', 'Les formulaires servent à capturer l\'information de vos prospects. Ils sont donc le point charnière entre une conversion et la perte d\'une opportunité pour votre entreprise. \r\n\r\n'),
(31, 'F', 'Funnel', 'L\'entonnoir de conversion est le processus par lequel un visiteur est amené à visiter votre site et à saisir puis valider le formulaire de votre landing page.\r\n\r\n'),
(32, 'G', 'Ghost Code\r\n', 'C’est une application Snapchat qui permet de découvrir de nouveaux comptes Snapchat qui sont susceptibles de vous intérésser.\r\n\r\n'),
(33, 'G', 'Ghostwriting', 'Processus d\'embauche d\'une personne pour rédiger des livres, des manuscrits, des scénarios, des discours, des articles,des rapports, des livres blancs, ou d\'autres textes qui sont officiellement crédités à une autre personne.\r\n\r\n'),
(34, 'H', 'Hard bounce\r\n', 'Désigne le fait qu\'un email n\'a pas été délivré pour une raison permanente. Une raison permanente est par exemple un email de destinataire qui n\'existe plus. \r\n\r\n'),
(35, 'H', 'Hash tag\r\n', 'Un hashtag est mot ou groupe de mot suivant le caractère # dans un tweet. Créé à l’initiative du concepteur du message, un hashtag est cliquable et permet au lecteur d’être redirigé vers des tweet traitant du même sujet.\r\n'),
(36, 'H', 'Hébergeur', 'Un hébergeur web est une entité ayant pour vocation de mettre à disposition des internautes des sites web conçus et gérés par des tiers.\r\n'),
(37, 'H', 'HTTP', 'HyperText Transfer Protocol est le protocole de transfert sur internet le plus courant. C\'est par l\'intermédiaire de celui-ci que sont transmises les pages Web (au langage HTML) et que votre navigateur Web vous présente de façon structurée.\r\n'),
(38, 'H', 'HTTPS', 'HyperText Transfer Protocol Secure est  un Protocole de communication utilisé pour l\'accès à un serveur Web sécurisé.\r\n\r\n'),
(39, 'I', 'Inbound Marketing\r\n', 'Le Inbound marketing est la stratégie marketing qui vise à faire venir le client vers soi plutôt que d’aller le chercher avec les techniques de marketing traditionnelles de type outbound marketing.\r\n\r\n'),
(40, 'I', 'Internaute', 'Désigne donc une personne qui utilise un navigateur web pour visiter des sites web et, par extension, toute personne employant une application informatique permettant d\'obtenir sur Internet des informations, ou de l\'interactivité avec d\'autres personnes.\r\n\r\n'),
(41, 'I', 'IoT\r\n', 'Raccourci utilisé pour désigner l’Internet Of Things ou en français l’Internet des objets connectés.\r\nLe terme d’IoT fait généralement référence à l’écosystème des objets connectés qui comprend le marché de ces objets, mais également tous les modèles économiques et marketing issus de leur développement.'),
(42, 'L', 'Landing Page (LP)\r\n', 'Désigne la page sur laquelle arrive un internaute après avoir cliqué sur un lien (lien d’un article, lien email, lien bandeau publicitaire, etc..).\r\n'),
(43, 'L', 'Lead', 'Traduction de prospect en anglais\r\n\r\n'),
(44, 'L', 'Lead nurturing\r\n', 'Procédure qui consiste à maintenir ou renforcer une relation marketing avec des prospects qui ne sont pas encore mûrs pour une action de vente.\r\n\r\n'),
(45, 'L', 'Lead scoring\r\n', 'Anglicisme qui désigne la pratique de calcul et d’affectation d’un score aux prospects de l’entreprise. Le but de cette opération est de mieux comprendre potentiel du prospect, son degré d’appétence pour le produit / service ou sa position dans le cycle d’achat. Le score permet de sélectionner les cibles, d’établir des priorités de contact et de personnaliser l’action marketing.\r\n'),
(46, 'L', 'Liens entrants (Inbound links)\r\n', 'Lien situé sur un autre site qui pointe vers une page du site de référence.\r\n'),
(47, 'L', 'Link Building\r\n', 'C’est l’activité de recherche et de création de liens externes (backlinks) destinée à favoriser le classement d’un site web dans les pages de résultats des moteurs de recherche et surtout dans les résultats de Google. \r\n'),
(48, 'L', 'Livre blanc\r\n', 'Guide pratique de quelques pages consacré à un produit ou une technique et destiné à des prospects.\r\n'),
(49, 'M', 'Marketing Qualified Leads (MQL)\r\n', 'Prosprets qui ont manifesté un intérêt pour les produits ou services de votre entreprise en faisant une action comme  télécharger une ressource, assister à un webinaire, etc. Cependant malgré cet intérêt, vous ne savez pas vraiment si ils sont qualifiés pour acheter vos produits ou services.\r\n\r\nEn d\'autres termes, ils sont pas encore prêts à être transmis à l\'équipe commerciale jusqu\'à ce qu\'ils soient mieux qualifiés.'),
(50, 'M', 'Médias sociaux\r\n', 'Plateforme sur Internet qui permet aux gens de créer du contenu.\r\n'),
(51, 'M', 'Mention', 'C\'est l’arobase (@) qui est utilisé sur Twitter pour mentionner un autre utilisateur.\r\n\r\n'),
(52, 'M', 'Mobinautes', 'Désigne toutes personnes ayant recours à un appareil mobile pour accéder à internet.\r\n\r\n'),
(53, 'M', 'Mot clé\r\n', 'Désigne généralement le mot ou l’ensemble de mots (expression) saisis par un internaute pour effectuer une recherche d’information sur un moteur ou pour chercher un produit ou un contenu sur un site marchand ou éditorial.\r\n'),
(54, 'M', 'Moteur de recherche\r\n', 'C\'est un outil qui référence automatiquement les pages web se trouvant sur le réseau Internet à l’aide d’un programme appelé spider ou robot.\r\n'),
(55, 'N', 'Nom de domaine\r\n', 'Un nom de domaine est une adresse saisie par un internaute dans la barre d’adresse d’un navigateur pour se connecter à la page d’accueil d’un site (exemple : Yahoo.fr) ou de plus en plus souvent directement saisie dans la barre de recherche d’un moteur.L’adresse se compose du nom du site (Yahoo) et d’une extension (fr) séparés par un point. L’extension peut indiquer la nationalité (fr,uk) ou le type d’activité (com., gov). \r\n'),
(56, 'C', 'CPM', 'Le CPM (coût pour mille) correspond au principal mode de facturation des espaces publicitaires en display. L\'annonceur paie un prix pour un espace publicitaire, exprimé pour mille affichages de la campagne publicitaire (bannière, vidéo, etc.) de l\'annonceur.'),
(57, 'C', 'CPC', 'Le CPC est un sigle qui désigne l\'expression coût par clic, aussi appelé paiement par clic. Il correspond au mode de tarification auquel est confronté l\'annonceur souhaitant acheter un espace publicitaire sur Internet, à une entreprise lui permettant de diffuser sa campagne publicitaire (texte, image, vidéo...) sur le web.');

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
-- Index pour la table `glossary`
--
ALTER TABLE `glossary`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `access`
--
ALTER TABLE `access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT pour la table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `adsets`
--
ALTER TABLE `adsets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `glossary`
--
ALTER TABLE `glossary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
