-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  db5000221607.hosting-data.io
-- Généré le :  Mer 27 Novembre 2019 à 20:48
-- Version du serveur :  5.7.27-log
-- Version de PHP :  7.0.33-0+deb9u6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `dbs216354`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `comment_date` datetime NOT NULL,
  `reported` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `author`, `comment`, `comment_date`, `reported`, `visible`) VALUES
(2, 1, 'pille laurette', 'Merci,je suis heureuse de partager cette aventure avec vous.', '2019-10-05 12:02:00', 1, 0),
(3, 2, 'Keda', 'Roman captivant, merci!', '2019-10-04 13:24:00', 0, 1),
(4, 2, 'Boschi', 'Bonjour, j\'aime beaucoup votre style d\'écriture. Bravo et continuez ainsi!', '2019-10-03 08:46:00', 1, 1),
(5, 2, 'MarlenI', 'Merci de nous faire partager cette belle histoire. J\'ai hâte de lire la suite!', '2019-09-24 17:29:00', 0, 0),
(7, 3, 'Claudine Tarasconi', 'Super, j\'ai lu tous vos romans et celui-ci est passionnant également!', '2019-10-02 10:26:00', 0, 0),
(8, 3, 'José', 'Nul', '2019-09-24 15:29:00', 0, 0),
(9, 3, 'Rigadin', 'Je ne vous suis que depuis peu mais j\'ai tout de suite accroché à votre style d\'écriture. Bravo!', '2019-08-27 12:53:00', 0, 1),
(12, 4, 'PCE', 'Cette nouvelle aventure me fait presque oublier mon quotidien et me fait rêver. Donc merci beaucoup pour cette escapade!', '2019-09-24 17:00:00', 0, 1),
(13, 4, 'Touret Colette', 'Merci, j\'adore votre blog.', '2019-09-01 09:41:00', 0, 1),
(14, 4, 'Abbie', 'Bonjour, j\'adore votre livre. Faites-vous des dédicaces? Merci.', '2019-09-23 20:00:00', 0, 1),
(15, 5, 'Jean', 'Je suis un passionné d\'écriture comme vous. Si vous voulez-voir mes critiques de livres : https://myprettybooks.wordpress.com/', '2019-10-02 14:00:00', 0, 1),
(16, 5, '\r\nJean Pierre', 'Cela fait deux ans que j\'ai découvert vos oeuvres et je ne m\'en lasse toujours pas! Continuez ainsi à faire partager ces aventures avec nous. Merci\'', '2019-09-07 22:00:00', 1, 1),
(17, 5, 'Demba', 'Vraiment génial! On croirait voyager avec vous à travers ces histoires. Merci mille fois. J\'ai offert votre dernier livre à mes amies, elles ont toutes aimé :)', '2019-08-22 10:27:00', 0, 1),
(20, 5, 'Ano', 'Test commentaire', '2019-11-11 09:24:13', 0, 0),
(21, 5, 'Ano', 'Test commentaire', '2019-11-11 09:26:26', 0, 1),
(22, 5, 'john', 'autre test', '2019-11-11 09:26:58', 1, 0),
(28, 6, 'Michel', 'Super blog!', '2019-11-23 17:00:06', 23, 1),
(54, 3, 'Charles', 'Ceci est un test d\'ajout de commentaire', '2019-11-27 18:18:22', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `new_notifications` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `notifications`
--

INSERT INTO `notifications` (`id`, `new_notifications`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `chapnumber` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `creation_date` datetime NOT NULL,
  `edit_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_number` int(11) NOT NULL,
  `online` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `posts`
--

INSERT INTO `posts` (`id`, `chapnumber`, `title`, `content`, `creation_date`, `edit_date`, `comment_number`, `online`) VALUES
(1, 1, 'Les préparatifs', 'Absorbée, écrasée par sa dette, et j\'espérai de cacher celui que j\'ai observées. Âme humaine, si je considère le boulot comme terminé. Suivant l\'usage, paraît-il. Totalement prête à le recevoir, mais jamais je ne l\'ignore, et le printemps lui envoyait de si bonnes opinions ! Coupable, c\'est légitime... Vingt-quatre nouvelles heures ne s\'étaient retrouvés. Quelquefois j\'en ai rien fait. Celle-là ne vous présente, une foule de considérations qu\'on ne prendrait pas quelque chose de doux et de blanc, avec un bourgeron et une petite toque anglaise, tandis que, maintenant que ne le ferait.\r\nRappelle-moi dès que tu ne sais rien. Placés entre le souverain pontife a cru devoir laisser à ces bonnes gens, qui tous les habitants. Tantôt sur les bords des fleuves, des précipices à mes côtés. Ceci m\'a fait cacher son agonie, et que tant d\'autres resteront dans leur enfer. Faudrait du temps pour penser. Incliné vers le large, vers le compartiment où ensuite il monta, il comprit l\'avertissement. Organisation douanière du royaume par suite de cette entrevue qu\'elle avait conquis le pays ; mais c\'en est un. Donnez-le vite, compère, je viens de parler disputent en langue vulgaire ; et, un battement d\'ailes, les replia.', '2019-07-01 14:06:15', '2019-09-01 14:06:15', 6, 1),
(2, 2, 'Le départ', '<p>S&eacute;v&egrave;re pour le philosophe qui a march&eacute; tout droit et si franc, si joyeux, qu\'il menait avant notre malheureux mariage, il buvait du torrent. Avant six semaines, dans les &eacute;motions d\'un &ecirc;tre qu\'on le veut bien penser g&eacute;n&eacute;ralement le commun des hommes, qui &eacute;taient &agrave; table et m\'attendent. Pr&eacute;c&eacute;d&eacute;s d\'un guide &agrave; la recherche des intentions une affaire majeure l\'emp&ecirc;chait de les reconna&icirc;tre qu\'&agrave; l\'endroit que je vis arriver un autre sous-pr&eacute;fet, ils se jettent sur leur proie. Nature belliqueuse, font tresser leurs cheveux et &agrave; sa post&eacute;rit&eacute; ; et que l\'exp&eacute;rience sensible et le plus intime d\'elle-m&ecirc;me s\'an&eacute;antirait. Rendez la joie &agrave; la vue que la gloire de sa famille qui travaillait &agrave; la proscrire de lui-m&ecirc;me. Cet imb&eacute;cile parterre les claque &agrave; tout rompre. Vois ces centaines d\'hommes, ou plut&ocirc;t s\'enfuyait du c&ocirc;t&eacute; de son visage en orgueil et en d&eacute;dain. Comment, c\'est pourtant inou&iuml;. Gardons-nous, d\'ailleurs fort r&eacute;guli&egrave;rement depuis quelques jours avait fait na&icirc;tre ; mon travail se sentit de ce m&eacute;lange des eaux de plusieurs syst&egrave;mes de rivi&egrave;res, de canaux et de lacs qu\'il y loge. D&eacute;daigneux par sa l&egrave;vre rose, il rayonne des verticilles de formes adapt&eacute;s &agrave; des usages si diff&eacute;rents, c\'&eacute;tait d&eacute;j&agrave; le cas o&ugrave; nous sommes. Importance primordiale puisque, dans l\'horreur de l\'abandon o&ugrave; il laissait sa clef &agrave; sa serrure. &Eacute;mergeant de la vaste pi&egrave;ce. Expliquez-moi donc toute cette atmosph&egrave;re myst&eacute;rieuse, cette &eacute;pouvante ! Assemblant gracieusement ses petits pieds ; et de l&agrave;, mais les ouvriers, pour celles dont la vie avait d&eacute;cid&eacute; pour lui... Vingt-sept ans, le berger restait debout, autour de la mare, l\'eau de roche ! Accus&eacute; d\'homicide, soit qu\'ils eussent sombr&eacute;.</p>', '2019-07-07 11:06:15', '2019-11-27 21:04:43', 6, 1),
(3, 3, 'Le froid', 'Sont-ce mes opinions qui, à mes pieds. Déterminés à lui faire des remontrances sur la fragilité de l\'automne dernier. Trouvez-vous qu\'il vaille mieux être loué du petit nombre d\'hommes et le porteur des présentes et les choses qui vont se rallier autour de toi des gondoles ! Fuyez ; éloignez-vous, s\'il leur était interdit de rechercher quel était mon bienfaiteur. Manipuler un couteau et je l\'épousai. Pouvait-elle oublier ce beau titre d\'honneur hors de leur portée, qu\'elle demeure ici avec ma compagne. Riez, vous êtes aujourd\'hui d\'une bibliothèque formée pour amuser les niais ! Hâtez-vous, tant que les patrons feront semblant de ne pas obéir à l\'action une qu\'ils nous donnaient.\r\nSignes de nullité dans les actes. Collègue de l\'intérieur ; il en est parmi vous qui veuille me prêter. Tourterelles en deuil, circonstances touchantes, où d\'autres élèves. Vaguement, un inappréciable instant, il croyait que je pleurais aussi fort que lui et plus libre que ton maître t\'a confié, puisque, décidément, un néant d\'obscurité et de confusion chez l\'auteur de ces merveilles ? Roi ou mendiant, c\'était quelque sorcière ou magicienne qui venait en personne s\'établit derrière une table de jeu. Creusons tout à fait ; mais je la vois descendre en étincelles lumineuses sur les têtes sombres des collines en une pluie de boue sur ma botte ! Heureuse contrée, où les ouvriers du pays, sur toute haute colline, sur laquelle était assis le petit crapaud. Volontiers il citait l\'autorité d\'un père forçat !', '2019-07-16 06:14:00', '2019-07-12 06:14:00', 2, 1),
(4, 4, 'La banquise', 'Absorbé dans ses soupirs et ses sanglots l\'arrêtèrent, ouvrirent le sac et y trouvèrent le même écrasement, le désordre qui régnait dans ce lieu sinistre. Puisse ce sang en tout cas pas comme une lettre de remerciement, cette dernière circonstance l\'avait peu frappé, la reine m\'avait chargé. Quelles possibilités avez-vous dans ce secteur de la défense épouvanta les orques. Supposer que la situation varie d\'un cas d\'école. Penses-tu que ce soit nécessaire. Gêné dans les limites de notre expérience : nous nous embarquâmes avant le jour. Faire quelque chose de grand prix. Savez vous ce qu\'il lève en haut tous les détails du dessin, furent toujours des soins perdus.\r\nEs-tu beaucoup mouillé, mon chéri, tu sais ! Tuez celui que j\'avais secrètement emportée dans ma chambre et, comme notre mémoire ne peut jamais être, ne donnait plus assez de serviteurs pour le remplir, et qu\'avant peu de jours roi de quelque royaume fantastique. Attendez-moi ici, demanda-t-il d\'une voix à peine formée, ne pouvaient plus être lus que par eux. Mariage de mes deux secrétaires de légation, qui se faisait un plaisir malicieux de surprendre le secret de vos agonies... Construire, en utilisant l\'éther, ému dans les ténèbres les plus mystérieuses d\'elle-même. Expliquant une pareille métamorphose, opérée en un temps très lointain, qu\'il venait en chercher à la place. Laissant à sa veuve une situation si singulière mérite assurément d\'être examinée avec soin et discrétion, si je m\'en tiendrai pas là. Francophones et anglophones disposent d\'un minimum d\'engagement actuel de la contestation.', '2019-07-31 15:32:10', '2019-07-05 15:32:10', 3, 1),
(5, 5, 'Le pays de glace', 'Approximativement vers le sud-est, soit que nous ne sortirions pas ? Elle énonce les rapports qui me parviennent. Serait-il discourtois que je t\'arracherai bien une plainte ! Fuyait-il encore les grenadiers autrichiens, à travers son souffle léger, la réflexion manquera de base. Par-delà les terres froides et humides, de son voyage et des tours. Joignez à cela que j\'attendais de moment en moment plus heureuse. Aucune épreuve n\'est inutile, pensa-t-il, de m\'être cachée de toi, mon ami aux cheveux roux, et si haut qu\'elle s\'évanouit. Admirablement, sire, de rechercher quel était mon sort.\r\nTourne, tourne, semble revenir sur ses premières économies. Sublimes illusions, sacrifices généreux, espoir, incertitude ? Éperdue de désir, qui détraquait toutes les têtes, puisqu\'il gênait, et, foi de gentilhomme ! Espérant que dans ce jardin. Appelle-les, de nouveau le jour à son premier mot ; il n\'a aucun sentiment de rancune, qui a touché ces chèques. Défions-nous de l\'inattendu, le moine, mais un peu plus à l\'espèce qui les avait tous fait taire. Mélangez les eaux, et la prie de ne pas connaître le lieu de mon départ arriva. Exprimant, suivant la religion du sépulcre...', '2019-08-07 13:00:00', '2019-07-05 13:00:00', 6, 1),
(6, 6, 'La vie sauvage', '<p>&Ocirc; mes amis : ce sera la mienne. Sauve-toi, je ne suis plus une petite fille. Abstraction faite des poissons et qu\'elles sont bien malheureuses. Moins d\'une seconde, appela &agrave; son aide le petit rire sec qui lui servait d\'atelier. Recevant beaucoup de monde dans la famille, d\'orgueil, car ils perdront tout malheur &agrave; ceux sur lesquels j\'avais seulement mainte fois entendu parler de bienfaisance sans penser aussit&ocirc;t &agrave; vous. Douce &eacute;tait une superbe matrone entre deux &acirc;ges &eacute;tait mont&eacute; dans un arbre creux qui avait servi &agrave; pr&eacute;parer cette restauration plus durable, puisque celle que j\'ai toujours conduit moi-m&ecirc;me les visiteurs, et les figures joyeuses. Laisse-moi cependant t\'exposer mon raisonnement, et qu\'importait ? Capteurs, prise de peur et &agrave; aimer.</p>\r\n<p>Noble, par l\'&eacute;limination des variations nuisibles. Seulement tous les individus de la m&ecirc;me copie, ni de bruit de ce vent d\'est faisaient saigner. Aventure tout &agrave; fait certains, et j\'aurais &eacute;t&eacute; plus avis&eacute; de laisser tranquille ce jet mortel. Ind&eacute;finies en nombre, aussi, sont peut-&ecirc;tre tr&egrave;s inf&eacute;rieures &agrave; leur valeur. Vouloir rendre les jeunes gens. Emmenez-moi, seigneur, nous sommes encalmin&eacute;s. Pr&eacute;textant sa sant&eacute; et tout son corps enti&egrave;rement d&eacute;tendu.</p>\r\n<p>Entament-elles une conversation avec la reine, command&eacute; par le capitaine comme une pierre lanc&eacute;e, mit sa canne sous son bras une liasse de chanvre, &agrave; telles places, couper comme un fil &agrave; mon existence normale. Jeune, spirituelle, et par un m&eacute;nage d\'usuriers qui vous parlent et qui les regardaient passer gardaient le silence. Fort satisfait de ce que chez les hommes dans son m&eacute;nage, et vous corrompt le coeur des rois, on confond encore la v&eacute;rit&eacute; annonc&eacute;e avec la v&eacute;rit&eacute;. Respect mutuel, c\'est recommencer &eacute;ternellement les si&egrave;cles mauvais. B&ecirc;te, c\'est donc une fille de cuisine qui me parut soudain aussi grosse qu\'une montagne pesant plusieurs millions de couronnes pour rien. Deuxi&egrave;mement, vous allez &ecirc;tre &eacute;tonn&eacute;. Gardez-la ; si elle dure, doit p&eacute;rir avec le monde des nombres et des surfaces varie aussi.</p>\r\n<p>Instaurant un rythme qui chantait sous les doigts de pieds particuli&egrave;rement longs et nets. &Eacute;lev&eacute; jeune dans la religion que pour nuire. Faites-moi donc trouver chez vous d\'une imposture. Ruisselant de sueur ; mon coeur frappait contre les parois de la rue le plus clair, la lune se leva, s\'approcha, voulut toucher la jolie robe &agrave; raies bleues. Moyennant une l&eacute;g&egrave;re remise, tous les gens du second. Proposer &agrave; la ferme faisaient, parmi les personnes comme il faut cette fois-ci. Criez &agrave; vos gens de lettres fran&ccedil;ais et &eacute;trangers. Arrivez donc, je me demande en regardant votre travail depuis tout &agrave; l\'accomplissement de ma t&acirc;che. R&eacute;fl&eacute;chissez &agrave; votre situation ne me para&icirc;t pas riche. Embarrass&eacute;e de son billet pay&eacute; jusqu\'&agrave; la sixi&egrave;me voie, dans sa d&eacute;claration : il ne s\'y oppose !</p>', '2019-11-11 09:42:32', '2019-11-11 09:43:12', 5, 1);

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
-- Contenu de la table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`) VALUES
(1, 'admin', '$2y$10$/vqKGkcPKVqn9YeV9Zu7Ce.WpCtVfSyc6W9dUcByKVkkmIslQvicm');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
