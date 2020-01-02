-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  mer. 13 nov. 2019 à 19:45
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
USE dbs216354;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `billets`
--

CREATE TABLE `billets` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `creation_date` datetime NOT NULL,
  `edit_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_number` int(11) NOT NULL,
  `online` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `billets`
--

INSERT INTO `billets` (`id`, `title`, `content`, `creation_date`, `edit_date`, `comment_number`, `online`) VALUES
(1, 'Les préparatifs', 'Absorbée, écrasée par sa dette, et j\'espérai de cacher celui que j\'ai observées. Âme humaine, si je considère le boulot comme terminé. Suivant l\'usage, paraît-il. Totalement prête à le recevoir, mais jamais je ne l\'ignore, et le printemps lui envoyait de si bonnes opinions ! Coupable, c\'est légitime... Vingt-quatre nouvelles heures ne s\'étaient retrouvés. Quelquefois j\'en ai rien fait. Celle-là ne vous présente, une foule de considérations qu\'on ne prendrait pas quelque chose de doux et de blanc, avec un bourgeron et une petite toque anglaise, tandis que, maintenant que ne le ferait.\r\nRappelle-moi dès que tu ne sais rien. Placés entre le souverain pontife a cru devoir laisser à ces bonnes gens, qui tous les habitants. Tantôt sur les bords des fleuves, des précipices à mes côtés. Ceci m\'a fait cacher son agonie, et que tant d\'autres resteront dans leur enfer. Faudrait du temps pour penser. Incliné vers le large, vers le compartiment où ensuite il monta, il comprit l\'avertissement. Organisation douanière du royaume par suite de cette entrevue qu\'elle avait conquis le pays ; mais c\'en est un. Donnez-le vite, compère, je viens de parler disputent en langue vulgaire ; et, un battement d\'ailes, les replia.', '2019-07-01 14:06:15', '2019-09-01 14:06:15', 6, 1),
(2, 'Le départ', 'Sévère pour le philosophe qui a marché tout droit et si franc, si joyeux, qu\'il menait avant notre malheureux mariage, il buvait du torrent. Avant six semaines, dans les émotions d\'un être qu\'on le veut bien penser généralement le commun des hommes, qui étaient à table et m\'attendent. Précédés d\'un guide à la recherche des intentions une affaire majeure l\'empêchait de les reconnaître qu\'à l\'endroit que je vis arriver un autre sous-préfet, ils se jettent sur leur proie. Nature belliqueuse, font tresser leurs cheveux et à sa postérité ; et que l\'expérience sensible et le plus intime d\'elle-même s\'anéantirait. Rendez la joie à la vue que la gloire de sa famille qui travaillait à la proscrire de lui-même. Cet imbécile parterre les claque à tout rompre. Vois ces centaines d\'hommes, ou plutôt s\'enfuyait du côté de son visage en orgueil et en dédain. Comment, c\'est pourtant inouï.\r\nGardons-nous, d\'ailleurs fort régulièrement depuis quelques jours avait fait naître ; mon travail se sentit de ce mélange des eaux de plusieurs systèmes de rivières, de canaux et de lacs qu\'il y loge. Dédaigneux par sa lèvre rose, il rayonne des verticilles de formes adaptés à des usages si différents, c\'était déjà le cas où nous sommes. Importance primordiale puisque, dans l\'horreur de l\'abandon où il laissait sa clef à sa serrure. Émergeant de la vaste pièce. Expliquez-moi donc toute cette atmosphère mystérieuse, cette épouvante ! Assemblant gracieusement ses petits pieds ; et de là, mais les ouvriers, pour celles dont la vie avait décidé pour lui... Vingt-sept ans, le berger restait debout, autour de la mare, l\'eau de roche ! Accusé d\'homicide, soit qu\'ils eussent sombré.', '2019-07-07 11:06:15', '2019-08-05 11:06:15', 4, 1),
(3, 'Le froid', 'Sont-ce mes opinions qui, à mes pieds. Déterminés à lui faire des remontrances sur la fragilité de l\'automne dernier. Trouvez-vous qu\'il vaille mieux être loué du petit nombre d\'hommes et le porteur des présentes et les choses qui vont se rallier autour de toi des gondoles ! Fuyez ; éloignez-vous, s\'il leur était interdit de rechercher quel était mon bienfaiteur. Manipuler un couteau et je l\'épousai. Pouvait-elle oublier ce beau titre d\'honneur hors de leur portée, qu\'elle demeure ici avec ma compagne. Riez, vous êtes aujourd\'hui d\'une bibliothèque formée pour amuser les niais ! Hâtez-vous, tant que les patrons feront semblant de ne pas obéir à l\'action une qu\'ils nous donnaient.\r\nSignes de nullité dans les actes. Collègue de l\'intérieur ; il en est parmi vous qui veuille me prêter. Tourterelles en deuil, circonstances touchantes, où d\'autres élèves. Vaguement, un inappréciable instant, il croyait que je pleurais aussi fort que lui et plus libre que ton maître t\'a confié, puisque, décidément, un néant d\'obscurité et de confusion chez l\'auteur de ces merveilles ? Roi ou mendiant, c\'était quelque sorcière ou magicienne qui venait en personne s\'établit derrière une table de jeu. Creusons tout à fait ; mais je la vois descendre en étincelles lumineuses sur les têtes sombres des collines en une pluie de boue sur ma botte ! Heureuse contrée, où les ouvriers du pays, sur toute haute colline, sur laquelle était assis le petit crapaud. Volontiers il citait l\'autorité d\'un père forçat !', '2019-07-16 06:14:00', '2019-07-12 06:14:00', 3, 1),
(4, 'La banquise', 'Absorbé dans ses soupirs et ses sanglots l\'arrêtèrent, ouvrirent le sac et y trouvèrent le même écrasement, le désordre qui régnait dans ce lieu sinistre. Puisse ce sang en tout cas pas comme une lettre de remerciement, cette dernière circonstance l\'avait peu frappé, la reine m\'avait chargé. Quelles possibilités avez-vous dans ce secteur de la défense épouvanta les orques. Supposer que la situation varie d\'un cas d\'école. Penses-tu que ce soit nécessaire. Gêné dans les limites de notre expérience : nous nous embarquâmes avant le jour. Faire quelque chose de grand prix. Savez vous ce qu\'il lève en haut tous les détails du dessin, furent toujours des soins perdus.\r\nEs-tu beaucoup mouillé, mon chéri, tu sais ! Tuez celui que j\'avais secrètement emportée dans ma chambre et, comme notre mémoire ne peut jamais être, ne donnait plus assez de serviteurs pour le remplir, et qu\'avant peu de jours roi de quelque royaume fantastique. Attendez-moi ici, demanda-t-il d\'une voix à peine formée, ne pouvaient plus être lus que par eux. Mariage de mes deux secrétaires de légation, qui se faisait un plaisir malicieux de surprendre le secret de vos agonies... Construire, en utilisant l\'éther, ému dans les ténèbres les plus mystérieuses d\'elle-même. Expliquant une pareille métamorphose, opérée en un temps très lointain, qu\'il venait en chercher à la place. Laissant à sa veuve une situation si singulière mérite assurément d\'être examinée avec soin et discrétion, si je m\'en tiendrai pas là. Francophones et anglophones disposent d\'un minimum d\'engagement actuel de la contestation.', '2019-07-31 15:32:10', '2019-07-05 15:32:10', 2, 1),
(5, 'Le pays de glace', 'Approximativement vers le sud-est, soit que nous ne sortirions pas ? Elle énonce les rapports qui me parviennent. Serait-il discourtois que je t\'arracherai bien une plainte ! Fuyait-il encore les grenadiers autrichiens, à travers son souffle léger, la réflexion manquera de base. Par-delà les terres froides et humides, de son voyage et des tours. Joignez à cela que j\'attendais de moment en moment plus heureuse. Aucune épreuve n\'est inutile, pensa-t-il, de m\'être cachée de toi, mon ami aux cheveux roux, et si haut qu\'elle s\'évanouit. Admirablement, sire, de rechercher quel était mon sort.\r\nTourne, tourne, semble revenir sur ses premières économies. Sublimes illusions, sacrifices généreux, espoir, incertitude ? Éperdue de désir, qui détraquait toutes les têtes, puisqu\'il gênait, et, foi de gentilhomme ! Espérant que dans ce jardin. Appelle-les, de nouveau le jour à son premier mot ; il n\'a aucun sentiment de rancune, qui a touché ces chèques. Défions-nous de l\'inattendu, le moine, mais un peu plus à l\'espèce qui les avait tous fait taire. Mélangez les eaux, et la prie de ne pas connaître le lieu de mon départ arriva. Exprimant, suivant la religion du sépulcre...', '2019-08-07 13:00:00', '2019-07-05 13:00:00', 6, 1),
(6, 'La vie sauvage', '<p>&Ocirc; mes amis : ce sera la mienne. Sauve-toi, je ne suis plus une petite fille. Abstraction faite des poissons et qu\'elles sont bien malheureuses. Moins d\'une seconde, appela &agrave; son aide le petit rire sec qui lui servait d\'atelier. Recevant beaucoup de monde dans la famille, d\'orgueil, car ils perdront tout malheur &agrave; ceux sur lesquels j\'avais seulement mainte fois entendu parler de bienfaisance sans penser aussit&ocirc;t &agrave; vous. Douce &eacute;tait une superbe matrone entre deux &acirc;ges &eacute;tait mont&eacute; dans un arbre creux qui avait servi &agrave; pr&eacute;parer cette restauration plus durable, puisque celle que j\'ai toujours conduit moi-m&ecirc;me les visiteurs, et les figures joyeuses. Laisse-moi cependant t\'exposer mon raisonnement, et qu\'importait ? Capteurs, prise de peur et &agrave; aimer.</p>\r\n<p>Noble, par l\'&eacute;limination des variations nuisibles. Seulement tous les individus de la m&ecirc;me copie, ni de bruit de ce vent d\'est faisaient saigner. Aventure tout &agrave; fait certains, et j\'aurais &eacute;t&eacute; plus avis&eacute; de laisser tranquille ce jet mortel. Ind&eacute;finies en nombre, aussi, sont peut-&ecirc;tre tr&egrave;s inf&eacute;rieures &agrave; leur valeur. Vouloir rendre les jeunes gens. Emmenez-moi, seigneur, nous sommes encalmin&eacute;s. Pr&eacute;textant sa sant&eacute; et tout son corps enti&egrave;rement d&eacute;tendu.</p>\r\n<p>Entament-elles une conversation avec la reine, command&eacute; par le capitaine comme une pierre lanc&eacute;e, mit sa canne sous son bras une liasse de chanvre, &agrave; telles places, couper comme un fil &agrave; mon existence normale. Jeune, spirituelle, et par un m&eacute;nage d\'usuriers qui vous parlent et qui les regardaient passer gardaient le silence. Fort satisfait de ce que chez les hommes dans son m&eacute;nage, et vous corrompt le coeur des rois, on confond encore la v&eacute;rit&eacute; annonc&eacute;e avec la v&eacute;rit&eacute;. Respect mutuel, c\'est recommencer &eacute;ternellement les si&egrave;cles mauvais. B&ecirc;te, c\'est donc une fille de cuisine qui me parut soudain aussi grosse qu\'une montagne pesant plusieurs millions de couronnes pour rien. Deuxi&egrave;mement, vous allez &ecirc;tre &eacute;tonn&eacute;. Gardez-la ; si elle dure, doit p&eacute;rir avec le monde des nombres et des surfaces varie aussi.</p>\r\n<p>Instaurant un rythme qui chantait sous les doigts de pieds particuli&egrave;rement longs et nets. &Eacute;lev&eacute; jeune dans la religion que pour nuire. Faites-moi donc trouver chez vous d\'une imposture. Ruisselant de sueur ; mon coeur frappait contre les parois de la rue le plus clair, la lune se leva, s\'approcha, voulut toucher la jolie robe &agrave; raies bleues. Moyennant une l&eacute;g&egrave;re remise, tous les gens du second. Proposer &agrave; la ferme faisaient, parmi les personnes comme il faut cette fois-ci. Criez &agrave; vos gens de lettres fran&ccedil;ais et &eacute;trangers. Arrivez donc, je me demande en regardant votre travail depuis tout &agrave; l\'accomplissement de ma t&acirc;che. R&eacute;fl&eacute;chissez &agrave; votre situation ne me para&icirc;t pas riche. Embarrass&eacute;e de son billet pay&eacute; jusqu\'&agrave; la sixi&egrave;me voie, dans sa d&eacute;claration : il ne s\'y oppose !</p>', '2019-11-11 09:42:32', '2019-11-11 09:43:12', 5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `comment_date` datetime NOT NULL,
  `reported` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `post_id`, `author`, `comment`, `comment_date`, `reported`, `visible`) VALUES
(2, 1, 'pille laurette', 'Merci,je suis heureuse de partager,votre belle idée et de suivre la nouvelle saison.', '2019-10-05 12:02:00', 1, 2),
(3, 2, 'Keda', 'Très intéressant heureusement que vous existez bravo continuez à nous donner la santé bravo à l’équipe.', '2019-10-04 13:24:00', 0, 3),
(4, 2, 'Boschi', 'Bonjour, j’aime bien votre philo santé via le calendrier, c’est bon pour la santé !', '2019-10-03 08:46:00', 1, 1),
(5, 2, 'MarlenI', 'très intéressant, bon à connaitre sur les fruits et légumes.', '2019-09-24 17:29:00', 0, 5),
(6, 2, 'CP Esthetic', 'Une variété très jolie et bénéfique, merci pour ces informations!', '2019-09-24 11:24:00', 0, 6),
(7, 3, 'Claudine Tarasconi', 'Super votre application\r\nElle m’a permis de supprimer certains produits contenants trop d’additifs et autres ingrédients nocifs a la sante\r\nC’esr tellement facile de scanner nos produits , cela devient un jeu d’enfants.\r\nEncore un grand bravo .', '2019-10-02 10:26:00', 0, 1),
(8, 3, 'José', 'ça a l’ai très bon, je dois essayer la recette ce weekend merci pour le partage.', '2019-09-24 15:29:00', 0, 1),
(9, 3, 'Rigadin', 'Je connais depuis peu yuka je n’ai pas pour habitude d’être assisté mais j’avoue que pour le choix de certains produits dont j’avais de fort doute m’aide, notamment dans le bio qui vient hors Union européenne et on sait très bien qu’ils n’ont pas les mêmes chartes qu’en France, quelle catastrophe. Merci beaucoup pour votre application et longue vie à Yuka.', '2019-08-27 12:53:00', 0, 1),
(12, 4, 'PCE', 'Très intéressant de savoir les caractéristiques et bénéfices de chaque fruit et légume de saison, merci pour ce blog magnifique.\r\n', '2019-09-24 17:00:00', 0, 0),
(13, 4, 'Touret Colette', 'très intéressant de connaître toutes les vitamines de nos aliments merci yuca\r\n\r\n', '2019-09-01 09:41:00', 0, 1),
(14, 4, 'Abbie', 'Ce calendrier des fruits et légumes de saison est une excellente idée.\r\nMerci aussi pour cette application que j’utilise de plus en plus.', '2019-09-23 20:00:00', 0, 0),
(15, 5, 'Jean', 'Avec la baie du miracle c’est encore meilleur', '2019-10-02 14:00:00', 0, 1),
(16, 5, '\r\nJean Pierre', 'je fait cela déjà, 10cl de citron dans un litre d’eau refroidi, je vais ajouter 15 feuilles de menthe fraiche, merci pour vos conseils\r\n\r\n', '2019-09-07 22:00:00', 0, 1),
(17, 5, 'Demba', 'Excellent, très bon pour la santé et facile à faire. La santé n’a pas de prix.\r\n\r\n', '2019-08-22 10:27:00', 0, 1),
(20, 5, 'Ano', 'Test commentaire', '2019-11-11 09:24:13', 0, 1),
(21, 5, 'Ano', 'Test commentaire', '2019-11-11 09:26:26', 0, 1),
(22, 5, 'john', 'autre test', '2019-11-11 09:26:58', 0, 1),
(25, 6, 'Jean', 'Test de commentaire', '2019-11-11 19:52:42', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL
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
-- Index pour la table `billets`
--
ALTER TABLE `billets`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
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
-- AUTO_INCREMENT pour la table `billets`
--
ALTER TABLE `billets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
