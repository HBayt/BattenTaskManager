-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:4306
-- Généré le : mer. 02 oct. 2024 à 10:35
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `taskmanager`
--

-- --------------------------------------------------------

--
-- Structure de la table `addressee`
--

CREATE TABLE `addressee` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `addressee`
--

INSERT INTO `addressee` (`id`, `name`, `email`) VALUES
(2, 'Robin GOTTARDO', 'robin.gottardo@battenberg.ch'),
(3, 'Andy LINDER', 'andy.linder@battenberg.ch'),
(4, 'Richard GRANDGIRAD', 'richard.gandgirard@battenberg.ch'),
(5, 'Adriana ANLIELLO', 'adriana.aniello@battenberg.ch'),
(6, 'Mohamed IBRAHIM', 'mohamed.ibrahim@battenberg.ch'),
(7, 'Quentin KELLER', 'quentin.keller@battenberg.ch'),
(8, 'Corinne STOTZER', 'corinne.stotzer@battenberg.ch'),
(9, 'Stefanie HOSTETTLER', 'stefanie.hostettler@battenberg.ch'),
(10, 'Sylvia BAELLI', 'sylvia.baelli@battenberg.ch'),
(11, 'Monika VON AESCH', 'monika.vonaesch@battenberg.ch'),
(12, 'Elisabeth RUCKSTUHL', 'elisabeth.ruckstuhl@battenberg.ch'),
(13, 'Frank KRUMM', 'frank.krumm@battenberg.ch'),
(14, 'Dalai WENGER', 'dalai.wenger@battenberg.ch'),
(15, 'Chloe KESSI', 'chloe.kessi@battenberg.ch'),
(16, 'H. BAYT', 'halide.baytar@battenberg.ch'),
(35, 'Janine SIEGENTHALER', 'janine.siegenthaler@battenberg.ch');

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`) VALUES
(1, 'admin', '$2y$10$qF8aCBhIJ8lu/Yn4l2NO5uenTLMl4catol552h/Wqxedp.jQXx3PK'),
(4, 'mediadesign', '$2y$10$TsxwYf4jDxUoXBc0vRVEPuqISt54xmN8UyIiyddYdI/OnjLATX8QO');

-- --------------------------------------------------------

--
-- Structure de la table `group`
--

CREATE TABLE `group` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `libelle` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `group`
--

INSERT INTO `group` (`id`, `name`, `libelle`) VALUES
(1, 'NOT ASSIGNED GROUP', 'NONE'),
(4, 'Informatik', 'INF'),
(6, 'MediaDesign', 'MDE'),
(7, 'Verwaltung', 'VER'),
(8, 'Administration', 'ADM');

-- --------------------------------------------------------

--
-- Structure de la table `group_task`
--

CREATE TABLE `group_task` (
  `id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED DEFAULT NULL,
  `task_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `group_task`
--

INSERT INTO `group_task` (`id`, `group_id`, `task_id`) VALUES
(103, 4, 16),
(70, 4, 17),
(74, 4, 21),
(104, 6, 16),
(75, 6, 18),
(76, 6, 22),
(86, 6, 23),
(105, 7, 16),
(131, 7, 19),
(114, 7, 20),
(87, 7, 23),
(124, 7, 26),
(106, 8, 16);

-- --------------------------------------------------------

--
-- Structure de la table `mail`
--

CREATE TABLE `mail` (
  `id` int(11) UNSIGNED NOT NULL,
  `text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mail`
--

INSERT INTO `mail` (`id`, `text`) VALUES
(1, '<p><span style=\"color: #169179;\">Bonjour </span></p>\r\n<p><span style=\"color: #169179;\">Aujourd\'hui, le <strong>/date</strong> , vous &ecirc;tes pri&eacute;s de r&eacute;aliser la t&acirc;che suivante: <strong>/name</strong></span></p>\r\n<p><span style=\"color: #169179;\">Visitez<span style=\"text-decoration: underline;\"> http://task-manager</span> pour avoir acc&egrave;s &agrave; la planification compl&egrave;te.</span></p>\r\n<p><span style=\"color: #169179;\">Merci beaucoup et meilleures salutations</span></p>\r\n<p>-----------------------------------------------------------------------------------------------------------------</p>\r\n<p><span style=\"color: #236fa1;\">Guten Tag </span></p>\r\n<p><span style=\"color: #236fa1;\">Heute am <strong>/date </strong>sind mit der Aufgabe <strong>/name</strong> an der Reihe</span></p>\r\n<p><span style=\"color: #236fa1;\">Die Planung koennen Sie unter <span style=\"text-decoration: underline;\">http://task-manager</span> einsehen.</span></p>\r\n<p><span style=\"color: #236fa1;\">Vielen Dank und freundliche Gruesse</span></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>');

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

CREATE TABLE `task` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `weekdays` varchar(191) DEFAULT NULL,
  `color` varchar(191) DEFAULT NULL,
  `libelle` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `task`
--

INSERT INTO `task` (`id`, `name`, `weekdays`, `color`, `libelle`) VALUES
(16, 'Cafeteria + Mikrowelle / Micro-onde', '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\"]', '#1015e3ff', 'CAFE_ALL'),
(17, 'Staubsauger / Aspirateur INF', '[\"Wednesday\"]', '#15d0ffff', 'STAUB_INF'),
(18, 'Müll / Déchets MDE', '[\"Friday\"]', '#ff0000ff', 'MUELL_MDE'),
(19, 'Müll, Shredder, Altpapier / Déchets, Déchiqueteuse, Vieux papier VER', '[\"Thursday\"]', '#34613aff', 'MUELL_VER'),
(20, 'Staubsauger / Aspirateur VER', '[\"Wednesday\"]', '#20ed2aff', 'Stauber VER'),
(21, 'Müll / Déchets INF', '[\"Wednesday\"]', '#ff00ecff', 'MUELL_INF'),
(22, 'Staubsauger / Aspirateur MDE', '[\"Friday\"]', '#ffaa00ff', 'STAUB_MDE'),
(23, 'Kühlschrank / Frigo MDE&VER', '[\"Friday\"]', '#7600ffff', 'KUEL_MDE&VER'),
(26, 'Fensterschließung Sitzungszimmern / Fermer les fenêtres (salles-réunion) VER', '[\"Friday\"]', '#5f1507ff', 'Fenster VER');

-- --------------------------------------------------------

--
-- Structure de la table `tasked`
--

CREATE TABLE `tasked` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `task_id` int(11) UNSIGNED DEFAULT NULL,
  `contacted` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tasked`
--

INSERT INTO `tasked` (`id`, `title`, `start`, `user_id`, `task_id`, `contacted`) VALUES
(1, 'Keenan Thurnes MED', '2024-10-02 00:00:00', 65, 16, 'NO'),
(2, 'Aaron BLESS / INF', '2024-10-02 00:00:00', 120, 17, 'NO'),
(3, 'Joel RUBIN LENNY  / INF', '2024-10-02 00:00:00', 165, 21, 'NO'),
(4, 'Livio Nicola VOGT / VER', '2024-10-02 00:00:00', 87, 20, 'NO'),
(5, 'Bruno ZUCCHETTI / MED', '2024-10-03 00:00:00', 101, 16, 'NO'),
(6, 'Julian SCHWAAR / VER', '2024-10-03 00:00:00', 80, 19, 'NO'),
(7, 'Joel RUBIN LENNY  / INF', '2024-10-04 00:00:00', 165, 16, 'NO'),
(8, 'Gabriel DUARTE /MED', '2024-10-04 00:00:00', 96, 18, 'NO'),
(9, 'Keenan Thurnes MED', '2024-10-04 00:00:00', 65, 22, 'NO'),
(10, 'Rahel BALMER / VER', '2024-10-04 00:00:00', 148, 23, 'NO'),
(11, 'Jessica PEREIRA / VER', '2024-10-04 00:00:00', 127, 26, 'NO'),
(12, 'Nevio ROMANO INF', '2024-10-07 00:00:00', 123, 16, 'NO'),
(13, 'Andrija DRACA / INF', '2024-10-08 00:00:00', 121, 16, 'NO'),
(14, 'Alex SALESSE / MED', '2024-10-09 00:00:00', 51, 16, 'NO'),
(15, 'Amin ARSLANI / INF', '2024-10-09 00:00:00', 3, 17, 'NO'),
(16, 'Grittideth WATANAKULA / INF', '2024-10-09 00:00:00', 125, 21, 'NO'),
(17, 'Inaz FALAKI / VER', '2024-10-09 00:00:00', 128, 20, 'NO'),
(18, 'Davide De Marco / MED', '2024-10-10 00:00:00', 178, 16, 'NO'),
(19, 'Jessica PEREIRA / VER', '2024-10-10 00:00:00', 127, 19, 'NO'),
(20, 'Gabriel DUARTE /MED', '2024-10-11 00:00:00', 96, 16, 'NO'),
(21, 'Noé SERRAVEZZA / MED', '2024-10-11 00:00:00', 62, 18, 'NO'),
(22, 'Killian VALLAT / MED', '2024-10-11 00:00:00', 110, 22, 'NO'),
(23, 'Liora FUCHS / MED', '2024-10-11 00:00:00', 179, 23, 'NO'),
(24, 'Julian SCHWAAR / VER', '2024-10-11 00:00:00', 80, 26, 'NO'),
(25, 'Diogo DASILVA / MED', '2024-10-14 00:00:00', 95, 16, 'NO'),
(26, 'Grittideth WATANAKULA / INF', '2024-10-15 00:00:00', 125, 16, 'NO'),
(27, 'Amin ARSLANI / INF', '2024-10-16 00:00:00', 3, 16, 'NO'),
(28, 'Grittideth WATANAKULA / INF', '2024-10-16 00:00:00', 125, 17, 'NO'),
(29, 'Joel RUBIN LENNY  / INF', '2024-10-16 00:00:00', 165, 21, 'NO'),
(30, 'Jessica PEREIRA / VER', '2024-10-16 00:00:00', 127, 20, 'NO'),
(31, 'Aaron BLESS / INF', '2024-10-17 00:00:00', 120, 16, 'NO'),
(32, 'Joel MICHEL / VER', '2024-10-17 00:00:00', 153, 19, 'NO'),
(33, 'Lionel HOFER / MED', '2024-10-18 00:00:00', 76, 16, 'NO'),
(34, 'Noé SERRAVEZZA / MED', '2024-10-18 00:00:00', 62, 18, 'NO'),
(35, 'Sam MPENDUBUNDI / MED', '2024-10-18 00:00:00', 100, 22, 'NO'),
(36, 'Nicolas SAVOY / MED', '2024-10-18 00:00:00', 64, 23, 'NO'),
(37, 'Joel MICHEL / VER', '2024-10-18 00:00:00', 153, 26, 'NO'),
(38, 'Immanuel Studer / MED', '2024-10-21 00:00:00', 114, 16, 'NO'),
(39, 'Zuzanna GRZYB / VER', '2024-10-22 00:00:00', 102, 16, 'NO'),
(40, 'Noé SERRAVEZZA / MED', '2024-10-23 00:00:00', 62, 16, 'NO'),
(41, 'Aaron BLESS / INF', '2024-10-23 00:00:00', 120, 17, 'NO'),
(42, 'Amin ARSLANI / INF', '2024-10-23 00:00:00', 3, 21, 'NO'),
(43, 'Joel MICHEL / VER', '2024-10-23 00:00:00', 153, 20, 'NO'),
(44, 'Livio Nicola VOGT / VER', '2024-10-24 00:00:00', 87, 16, 'NO'),
(45, 'Inaz FALAKI / VER', '2024-10-24 00:00:00', 128, 19, 'NO'),
(46, 'Assia SAFRI / MED', '2024-10-25 00:00:00', 158, 16, 'NO'),
(47, 'Bruno ZUCCHETTI / MED', '2024-10-25 00:00:00', 101, 18, 'NO'),
(48, 'Keenan Thurnes MED', '2024-10-25 00:00:00', 65, 22, 'NO'),
(49, 'Killian VALLAT / MED', '2024-10-25 00:00:00', 110, 23, 'NO'),
(50, 'Rahel BALMER / VER', '2024-10-25 00:00:00', 148, 26, 'NO'),
(51, 'Cindy DOSSANTOS / MED', '2024-10-28 00:00:00', 103, 16, 'NO'),
(52, 'Inaz FALAKI / VER', '2024-10-29 00:00:00', 128, 16, 'NO'),
(53, 'Sam MPENDUBUNDI / MED', '2024-10-30 00:00:00', 100, 16, 'NO'),
(54, 'Aaron BLESS / INF', '2024-10-30 00:00:00', 120, 17, 'NO'),
(55, 'Joel RUBIN LENNY  / INF', '2024-10-30 00:00:00', 165, 21, 'NO'),
(56, 'Jessica PEREIRA / VER', '2024-10-30 00:00:00', 127, 20, 'NO'),
(57, 'Malte AISENBREY / INF', '2024-10-31 00:00:00', 167, 16, 'NO'),
(58, 'Julian SCHWAAR / VER', '2024-10-31 00:00:00', 80, 19, 'NO'),
(59, 'Julian SCHWAAR / VER', '2024-11-01 00:00:00', 80, 16, 'NO'),
(60, 'Liora FUCHS / MED', '2024-11-01 00:00:00', 179, 18, 'NO'),
(61, 'Sam MPENDUBUNDI / MED', '2024-11-01 00:00:00', 100, 22, 'NO'),
(62, 'Kevin BONGARD / VER', '2024-11-01 00:00:00', 133, 23, 'NO'),
(63, 'Jessica PEREIRA / VER', '2024-11-01 00:00:00', 127, 26, 'NO');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `group_id` int(11) UNSIGNED DEFAULT NULL,
  `weekdays` varchar(191) DEFAULT NULL,
  `done_task` tinyint(1) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `group_id`, `weekdays`, `done_task`) VALUES
(3, 'Amin ARSLANI / INF', 'amin.arslani@battenberg.ch', 4, '[\"Monday\",\"Wednesday\",\"Thursday\",\"Friday\"]', NULL),
(4, 'Halide BAYTAR / NONE', 'halide.baytar@battenberg.ch', 1, '[\"Monday\",\"Tuesday\",\"Wednesday\"]', NULL),
(51, 'Alex SALESSE / MED', 'myriam.salesse@battenberg.ch', 6, '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Friday\"]', NULL),
(62, 'Noé SERRAVEZZA / MED', 'noe.serravezza@battenberg.ch', 6, '[\"Monday\",\"Wednesday\",\"Thursday\",\"Friday\"]', NULL),
(64, 'Nicolas SAVOY / MED', 'nicolas.savoy@battenberg.ch', 6, '[\"Monday\",\"Wednesday\",\"Thursday\",\"Friday\"]', NULL),
(65, 'Keenan Thurnes MED', 'keenan.thurnes@battenberg.ch', 6, '[\"Monday\",\"Wednesday\",\"Thursday\",\"Friday\"]', NULL),
(76, 'Lionel HOFER / MED', 'Lionel.Hofer@battenberg.ch', 6, '[\"Monday\",\"Thursday\",\"Friday\"]', NULL),
(80, 'Julian SCHWAAR / VER', 'julian.schwaar@battenberg.ch', 7, '[\"Monday\",\"Tuesday\",\"Thursday\",\"Friday\"]', NULL),
(87, 'Livio Nicola VOGT / VER', 'livio.vogt@battenberg.ch', 7, '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\"]', NULL),
(90, 'Lisa BLUMENTHAL / VER', 'lisa.blumenthal@battenberg.ch', 7, '[\"Tuesday\"]', NULL),
(95, 'Diogo DASILVA / MED', 'diogo.dasilva@battenberg.ch', 6, '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Friday\"]', NULL),
(96, 'Gabriel DUARTE /MED', 'gabriel.duarte@battenberg.ch', 6, '[\"Wednesday\",\"Thursday\",\"Friday\"]', NULL),
(100, 'Sam MPENDUBUNDI / MED', 'sam.mpendubundi@battenberg.ch', 6, '[\"Wednesday\",\"Thursday\",\"Friday\"]', NULL),
(101, 'Bruno ZUCCHETTI / MED', 'bruno.zucchetti@battenberg.ch', 6, '[\"Monday\",\"Thursday\",\"Friday\"]', NULL),
(102, 'Zuzanna GRZYB / VER', 'ariana.grzyb@battenberg.ch', 7, '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\"]', NULL),
(103, 'Cindy DOSSANTOS / MED', 'cindy.dossantos@battenberg.ch', 6, '[\"Monday\",\"Tuesday\"]', NULL),
(110, 'Killian VALLAT / MED', 'killian.vallat@battenberg.ch', 6, '[\"Monday\",\"Thursday\",\"Friday\"]', NULL),
(114, 'Immanuel Studer / MED', 'Immanuel.Studer@battenberg.ch', 6, '[\"Monday\",\"Tuesday\",\"Wednesday\"]', NULL),
(120, 'Aaron BLESS / INF', 'aaron.bless@battenberg.ch', 4, '[\"Monday\",\"Wednesday\",\"Thursday\",\"Friday\"]', NULL),
(121, 'Andrija DRACA / INF', 'andrija.draca@battenberg.ch', 4, '[\"Monday\",\"Tuesday\",\"Thursday\",\"Friday\"]', NULL),
(123, 'Nevio ROMANO INF', 'nevio.romano@battenberg.ch', 4, '[\"Monday\",\"Thursday\",\"Friday\"]', NULL),
(125, 'Grittideth WATANAKULA / INF', 'grittideth.watanakula@battenberg.ch', 4, '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\"]', NULL),
(127, 'Jessica PEREIRA / VER', 'jessica.pereira@battenberg.ch', 7, '[\"Wednesday\",\"Thursday\",\"Friday\"]', NULL),
(128, 'Inaz FALAKI / VER', 'inaz.falaki@battenberg.ch', 7, '[\"Tuesday\",\"Wednesday\",\"Thursday\"]', NULL),
(133, 'Kevin BONGARD / VER', 'kevin.bongard@battenberg.ch', 7, '[\"Wednesday\",\"Thursday\",\"Friday\"]', NULL),
(148, 'Rahel BALMER / VER', 'rahel.balmer@battenberg.ch', 7, '[\"Monday\",\"Tuesday\",\"Thursday\",\"Friday\"]', NULL),
(153, 'Joel MICHEL / VER', 'joel.michel@battenberg.ch', 7, '[\"Wednesday\",\"Thursday\",\"Friday\"]', NULL),
(158, 'Assia SAFRI / MED', 'assia.safri@battenberg.ch', 6, '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\"]', NULL),
(165, 'Joel RUBIN LENNY  / INF', 'joel.lenny@battenberg.ch', 4, '[\"Wednesday\",\"Thursday\",\"Friday\"]', NULL),
(167, 'Malte AISENBREY / INF', 'malte.aisenbrey@battenberg.ch', 4, '[\"Monday\",\"Thursday\",\"Friday\"]', NULL),
(178, 'Davide De Marco / MED', 'davide.demarco@gmail.com', 6, '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\"]', 0),
(179, 'Liora FUCHS / MED', 'liora.fuchs@battenberg.ch', 6, '[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\"]', 0);

-- --------------------------------------------------------

--
-- Structure de la table `vacation`
--

CREATE TABLE `vacation` (
  `id` int(11) UNSIGNED NOT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `vacation`
--

INSERT INTO `vacation` (`id`, `start`, `end`, `user_id`) VALUES
(127, '2024-07-22', '2024-07-26', 120),
(138, '2024-08-13', '2024-09-01', 120),
(139, '2024-08-08', '2024-08-15', 128),
(146, '2027-09-01', '2027-09-05', 4),
(147, '2024-06-02', '2024-08-01', 158),
(149, '2024-08-27', '2024-08-31', 87),
(150, '2024-08-28', '2024-08-31', 103),
(151, '2024-09-11', '2024-09-30', 121);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `addressee`
--
ALTER TABLE `addressee`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `group_task`
--
ALTER TABLE `group_task`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_18ba3a510a57e886d7f55b3057b27684eb2e9690` (`group_id`,`task_id`),
  ADD KEY `index_foreignkey_group_task_group` (`group_id`),
  ADD KEY `index_foreignkey_group_task_task` (`task_id`);

--
-- Index pour la table `mail`
--
ALTER TABLE `mail`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tasked`
--
ALTER TABLE `tasked`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_tasked_user` (`user_id`),
  ADD KEY `index_foreignkey_tasked_task` (`task_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_user_group` (`group_id`);

--
-- Index pour la table `vacation`
--
ALTER TABLE `vacation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_vacation_user` (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `addressee`
--
ALTER TABLE `addressee`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `group`
--
ALTER TABLE `group`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `group_task`
--
ALTER TABLE `group_task`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT pour la table `mail`
--
ALTER TABLE `mail`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `tasked`
--
ALTER TABLE `tasked`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT pour la table `vacation`
--
ALTER TABLE `vacation`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `group_task`
--
ALTER TABLE `group_task`
  ADD CONSTRAINT `c_fk_group_task_group_id` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `c_fk_group_task_task_id` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tasked`
--
ALTER TABLE `tasked`
  ADD CONSTRAINT `c_fk_tasked_task_id` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `c_fk_tasked_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `c_fk_user_group_id` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Contraintes pour la table `vacation`
--
ALTER TABLE `vacation`
  ADD CONSTRAINT `c_fk_vacation_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
