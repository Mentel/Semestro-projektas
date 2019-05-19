-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 19, 2019 at 04:47 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `events`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(18, 'Viduje'),
(19, 'Lauke'),
(20, 'Technologijos'),
(21, 'Gamta'),
(22, 'Sportas'),
(23, 'Mokslas');

-- --------------------------------------------------------

--
-- Table structure for table `category_event`
--

DROP TABLE IF EXISTS `category_event`;
CREATE TABLE IF NOT EXISTS `category_event` (
  `category_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`event_id`),
  KEY `IDX_D39D45EE12469DE2` (`category_id`),
  KEY `IDX_D39D45EE71F7E88B` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_event`
--

INSERT INTO `category_event` (`category_id`, `event_id`) VALUES
(18, 52),
(18, 54),
(18, 56),
(18, 57),
(19, 51),
(19, 53),
(20, 52),
(20, 53),
(20, 55),
(20, 57),
(21, 51),
(22, 51),
(22, 55),
(23, 52),
(23, 56);

-- --------------------------------------------------------

--
-- Table structure for table `category_user`
--

DROP TABLE IF EXISTS `category_user`;
CREATE TABLE IF NOT EXISTS `category_user` (
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`user_id`),
  KEY `IDX_608AC0E12469DE2` (`category_id`),
  KEY `IDX_608AC0EA76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_user`
--

INSERT INTO `category_user` (`category_id`, `user_id`) VALUES
(18, 15),
(18, 17),
(19, 15),
(19, 17),
(20, 3),
(20, 17),
(21, 15),
(21, 17),
(22, 15),
(22, 17),
(23, 3),
(23, 17);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host_id` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `description` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3BAE0AA71FB8D185` (`host_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `host_id`, `address`, `date`, `description`, `name`, `price`) VALUES
(51, 3, 'Studentu 50 Kaunas', '2018-04-25 00:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut sem ante. Sed vehicula venenatis libero in semper. Sed tempus non augue id lobortis. Etiam consectetur quis ante quis dapibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla aliquam malesuada nibh, in congue mauris varius vel. Nullam eleifend dolor odio, dictum scelerisque orci posuere vitae. Maecenas quis vulputate purus. Cras interdum orci vel mollis pulvinar. In porttitor justo eget justo congue tristique. Aliquam ultricies rutrum diam. Ut fringilla pellentesque quam.\r\n\r\nNulla interdum, dolor maximus tempor scelerisque, nulla massa ornare mi, vel aliquam elit ligula vel magna. Nam ac accumsan mi. Proin convallis augue metus, eu lobortis risus eleifend eget. Pellentesque cursus vitae turpis ornare placerat. Donec consectetur tincidunt felis, eget ultricies libero tincidunt vitae. Vivamus leo dolor, mattis tempus fringilla nec, condimentum nec arcu. Nulla commodo dui quam, sed sollicitudin turpis pellentesque ac. Duis lectus urna, eleifend sed est id, egestas euismod quam. In id orci et velit convallis pellentesque eu at risus. Curabitur condimentum auctor nibh at gravida. In orci nibh, feugiat eget lacus at, sollicitudin lobortis eros. Duis enim est, tempus a ligula ut, sollicitudin maximus sapien.\r\n\r\nSed eget nisl non risus auctor fermentum. Nulla mattis egestas aliquet. Suspendisse condimentum tellus urna. Duis hendrerit semper est quis blandit. Ut ac tortor eget tortor auctor vestibulum eget at orci. Aliquam diam quam, aliquet quis ullamcorper nec, interdum ac lacus. Cras ut neque a elit vestibulum malesuada. Sed mollis molestie dui. Fusce eros dui, tincidunt eget nisl nec, lacinia luctus risus. Aliquam sed pharetra dolor.\r\n\r\nDuis a enim at est posuere accumsan. Mauris venenatis vehicula enim, sit amet tempor neque semper in. Morbi laoreet quam malesuada nunc fringilla, at sollicitudin ligula lacinia. Vivamus non scelerisque quam posuere.', 'Sportas gamtoje', 0),
(52, 3, 'Barsausko 59 Kaunas', '2019-05-14 00:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut sem ante. Sed vehicula venenatis libero in semper. Sed tempus non augue id lobortis. Etiam consectetur quis ante quis dapibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla aliquam malesuada nibh, in congue mauris varius vel. Nullam eleifend dolor odio, dictum scelerisque orci posuere vitae. Maecenas quis vulputate purus. Cras interdum orci vel mollis pulvinar. In porttitor justo eget justo congue tristique. Aliquam ultricies rutrum diam. Ut fringilla pellentesque quam.\r\n\r\nNulla interdum, dolor maximus tempor scelerisque, nulla massa ornare mi, vel aliquam elit ligula vel magna. Nam ac accumsan mi. Proin convallis augue metus, eu lobortis risus eleifend eget. Pellentesque cursus vitae turpis ornare placerat. Donec consectetur tincidunt felis, eget ultricies libero tincidunt vitae. Vivamus leo dolor, mattis tempus fringilla nec, condimentum nec arcu. Nulla commodo dui quam, sed sollicitudin turpis pellentesque ac. Duis lectus urna, eleifend sed est id, egestas euismod quam. In id orci et velit convallis pellentesque eu at risus. Curabitur condimentum auctor nibh at gravida. In orci nibh, feugiat eget lacus at, sollicitudin lobortis eros. Duis enim est, tempus a ligula ut, sollicitudin maximus sapien.\r\n\r\nSed eget nisl non risus auctor fermentum. Nulla mattis egestas aliquet. Suspendisse condimentum tellus urna. Duis hendrerit semper est quis blandit. Ut ac tortor eget tortor auctor vestibulum eget at orci. Aliquam diam quam, aliquet quis ullamcorper nec, interdum ac lacus. Cras ut neque a elit vestibulum malesuada. Sed mollis molestie dui. Fusce eros dui, tincidunt eget nisl nec, lacinia luctus risus. Aliquam sed pharetra dolor.\r\n\r\nDuis a enim at est posuere accumsan. Mauris venenatis vehicula enim, sit amet tempor neque semper in. Morbi laoreet quam malesuada nunc fringilla, at sollicitudin ligula lacinia. Vivamus non scelerisque quam posuere.', 'Susitikimas su mokslininku', 10),
(53, 3, 'Studentu 48 Kaunas', '2019-06-06 00:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut sem ante. Sed vehicula venenatis libero in semper. Sed tempus non augue id lobortis. Etiam consectetur quis ante quis dapibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla aliquam malesuada nibh, in congue mauris varius vel. Nullam eleifend dolor odio, dictum scelerisque orci posuere vitae. Maecenas quis vulputate purus. Cras interdum orci vel mollis pulvinar. In porttitor justo eget justo congue tristique. Aliquam ultricies rutrum diam. Ut fringilla pellentesque quam.\r\n\r\nNulla interdum, dolor maximus tempor scelerisque, nulla massa ornare mi, vel aliquam elit ligula vel magna. Nam ac accumsan mi. Proin convallis augue metus, eu lobortis risus eleifend eget. Pellentesque cursus vitae turpis ornare placerat. Donec consectetur tincidunt felis, eget ultricies libero tincidunt vitae. Vivamus leo dolor, mattis tempus fringilla nec, condimentum nec arcu. Nulla commodo dui quam, sed sollicitudin turpis pellentesque ac. Duis lectus urna, eleifend sed est id, egestas euismod quam. In id orci et velit convallis pellentesque eu at risus. Curabitur condimentum auctor nibh at gravida. In orci nibh, feugiat eget lacus at, sollicitudin lobortis eros. Duis enim est, tempus a ligula ut, sollicitudin maximus sapien.\r\n\r\nSed eget nisl non risus auctor fermentum. Nulla mattis egestas aliquet. Suspendisse condimentum tellus urna. Duis hendrerit semper est quis blandit. Ut ac tortor eget tortor auctor vestibulum eget at orci. Aliquam diam quam, aliquet quis ullamcorper nec, interdum ac lacus. Cras ut neque a elit vestibulum malesuada. Sed mollis molestie dui. Fusce eros dui, tincidunt eget nisl nec, lacinia luctus risus. Aliquam sed pharetra dolor.\r\n\r\nDuis a enim at est posuere accumsan. Mauris venenatis vehicula enim, sit amet tempor neque semper in. Morbi laoreet quam malesuada nunc fringilla, at sollicitudin ligula lacinia. Vivamus non scelerisque quam posuere.', 'Robotų demonstracija', 0),
(54, 3, 'Studentu 56 Kaunas', '2020-10-14 00:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut sem ante. Sed vehicula venenatis libero in semper. Sed tempus non augue id lobortis. Etiam consectetur quis ante quis dapibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla aliquam malesuada nibh, in congue mauris varius vel. Nullam eleifend dolor odio, dictum scelerisque orci posuere vitae. Maecenas quis vulputate purus. Cras interdum orci vel mollis pulvinar. In porttitor justo eget justo congue tristique. Aliquam ultricies rutrum diam. Ut fringilla pellentesque quam.\r\n\r\nNulla interdum, dolor maximus tempor scelerisque, nulla massa ornare mi, vel aliquam elit ligula vel magna. Nam ac accumsan mi. Proin convallis augue metus, eu lobortis risus eleifend eget. Pellentesque cursus vitae turpis ornare placerat. Donec consectetur tincidunt felis, eget ultricies libero tincidunt vitae. Vivamus leo dolor, mattis tempus fringilla nec, condimentum nec arcu. Nulla commodo dui quam, sed sollicitudin turpis pellentesque ac. Duis lectus urna, eleifend sed est id, egestas euismod quam. In id orci et velit convallis pellentesque eu at risus. Curabitur condimentum auctor nibh at gravida. In orci nibh, feugiat eget lacus at, sollicitudin lobortis eros. Duis enim est, tempus a ligula ut, sollicitudin maximus sapien.\r\n\r\nSed eget nisl non risus auctor fermentum. Nulla mattis egestas aliquet. Suspendisse condimentum tellus urna. Duis hendrerit semper est quis blandit. Ut ac tortor eget tortor auctor vestibulum eget at orci. Aliquam diam quam, aliquet quis ullamcorper nec, interdum ac lacus. Cras ut neque a elit vestibulum malesuada. Sed mollis molestie dui. Fusce eros dui, tincidunt eget nisl nec, lacinia luctus risus. Aliquam sed pharetra dolor.\r\n\r\nDuis a enim at est posuere accumsan. Mauris venenatis vehicula enim, sit amet tempor neque semper in. Morbi laoreet quam malesuada nunc fringilla, at sollicitudin ligula lacinia. Vivamus non scelerisque quam posuere.', 'Rudeninis susibūrimas', 20),
(55, 3, 'Studentu 67', '2018-09-23 00:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut sem ante. Sed vehicula venenatis libero in semper. Sed tempus non augue id lobortis. Etiam consectetur quis ante quis dapibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla aliquam malesuada nibh, in congue mauris varius vel. Nullam eleifend dolor odio, dictum scelerisque orci posuere vitae. Maecenas quis vulputate purus. Cras interdum orci vel mollis pulvinar. In porttitor justo eget justo congue tristique. Aliquam ultricies rutrum diam. Ut fringilla pellentesque quam.\r\n\r\nNulla interdum, dolor maximus tempor scelerisque, nulla massa ornare mi, vel aliquam elit ligula vel magna. Nam ac accumsan mi. Proin convallis augue metus, eu lobortis risus eleifend eget. Pellentesque cursus vitae turpis ornare placerat. Donec consectetur tincidunt felis, eget ultricies libero tincidunt vitae. Vivamus leo dolor, mattis tempus fringilla nec, condimentum nec arcu. Nulla commodo dui quam, sed sollicitudin turpis pellentesque ac. Duis lectus urna, eleifend sed est id, egestas euismod quam. In id orci et velit convallis pellentesque eu at risus. Curabitur condimentum auctor nibh at gravida. In orci nibh, feugiat eget lacus at, sollicitudin lobortis eros. Duis enim est, tempus a ligula ut, sollicitudin maximus sapien.\r\n\r\nSed eget nisl non risus auctor fermentum. Nulla mattis egestas aliquet. Suspendisse condimentum tellus urna. Duis hendrerit semper est quis blandit. Ut ac tortor eget tortor auctor vestibulum eget at orci. Aliquam diam quam, aliquet quis ullamcorper nec, interdum ac lacus. Cras ut neque a elit vestibulum malesuada. Sed mollis molestie dui. Fusce eros dui, tincidunt eget nisl nec, lacinia luctus risus. Aliquam sed pharetra dolor.\r\n\r\nDuis a enim at est posuere accumsan. Mauris venenatis vehicula enim, sit amet tempor neque semper in. Morbi laoreet quam malesuada nunc fringilla, at sollicitudin ligula lacinia. Vivamus non scelerisque quam posuere.', 'Susitikimas su dėstytojais', 0),
(56, 3, 'Studentu g. 50', '2019-07-22 00:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut sem ante. Sed vehicula venenatis libero in semper. Sed tempus non augue id lobortis. Etiam consectetur quis ante quis dapibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla aliquam malesuada nibh, in congue mauris varius vel. Nullam eleifend dolor odio, dictum scelerisque orci posuere vitae. Maecenas quis vulputate purus. Cras interdum orci vel mollis pulvinar. In porttitor justo eget justo congue tristique. Aliquam ultricies rutrum diam. Ut fringilla pellentesque quam.\r\n\r\nNulla interdum, dolor maximus tempor scelerisque, nulla massa ornare mi, vel aliquam elit ligula vel magna. Nam ac accumsan mi. Proin convallis augue metus, eu lobortis risus eleifend eget. Pellentesque cursus vitae turpis ornare placerat. Donec consectetur tincidunt felis, eget ultricies libero tincidunt vitae. Vivamus leo dolor, mattis tempus fringilla nec, condimentum nec arcu. Nulla commodo dui quam, sed sollicitudin turpis pellentesque ac. Duis lectus urna, eleifend sed est id, egestas euismod quam. In id orci et velit convallis pellentesque eu at risus. Curabitur condimentum auctor nibh at gravida. In orci nibh, feugiat eget lacus at, sollicitudin lobortis eros. Duis enim est, tempus a ligula ut, sollicitudin maximus sapien.\r\n\r\nSed eget nisl non risus auctor fermentum. Nulla mattis egestas aliquet. Suspendisse condimentum tellus urna. Duis hendrerit semper est quis blandit. Ut ac tortor eget tortor auctor vestibulum eget at orci. Aliquam diam quam, aliquet quis ullamcorper nec, interdum ac lacus. Cras ut neque a elit vestibulum malesuada. Sed mollis molestie dui. Fusce eros dui, tincidunt eget nisl nec, lacinia luctus risus. Aliquam sed pharetra dolor.\r\n\r\nDuis a enim at est posuere accumsan. Mauris venenatis vehicula enim, sit amet tempor neque semper in. Morbi laoreet quam malesuada nunc fringilla, at sollicitudin ligula lacinia. Vivamus non scelerisque quam posuere.', 'Žymaus žmogaus paskaita', 100),
(57, 3, 'Studentu 50', '2019-05-22 00:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut sem ante. Sed vehicula venenatis libero in semper. Sed tempus non augue id lobortis. Etiam consectetur quis ante quis dapibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla aliquam malesuada nibh, in congue mauris varius vel. Nullam eleifend dolor odio, dictum scelerisque orci posuere vitae. Maecenas quis vulputate purus. Cras interdum orci vel mollis pulvinar. In porttitor justo eget justo congue tristique. Aliquam ultricies rutrum diam. Ut fringilla pellentesque quam.\r\n\r\nNulla interdum, dolor maximus tempor scelerisque, nulla massa ornare mi, vel aliquam elit ligula vel magna. Nam ac accumsan mi. Proin convallis augue metus, eu lobortis risus eleifend eget. Pellentesque cursus vitae turpis ornare placerat. Donec consectetur tincidunt felis, eget ultricies libero tincidunt vitae. Vivamus leo dolor, mattis tempus fringilla nec, condimentum nec arcu. Nulla commodo dui quam, sed sollicitudin turpis pellentesque ac. Duis lectus urna, eleifend sed est id, egestas euismod quam. In id orci et velit convallis pellentesque eu at risus. Curabitur condimentum auctor nibh at gravida. In orci nibh, feugiat eget lacus at, sollicitudin lobortis eros. Duis enim est, tempus a ligula ut, sollicitudin maximus sapien.\r\n\r\nSed eget nisl non risus auctor fermentum. Nulla mattis egestas aliquet. Suspendisse condimentum tellus urna. Duis hendrerit semper est quis blandit. Ut ac tortor eget tortor auctor vestibulum eget at orci. Aliquam diam quam, aliquet quis ullamcorper nec, interdum ac lacus. Cras ut neque a elit vestibulum malesuada. Sed mollis molestie dui. Fusce eros dui, tincidunt eget nisl nec, lacinia luctus risus. Aliquam sed pharetra dolor.\r\n\r\nDuis a enim at est posuere accumsan. Mauris venenatis vehicula enim, sit amet tempor neque semper in. Morbi laoreet quam malesuada nunc fringilla, at sollicitudin ligula lacinia. Vivamus non scelerisque quam posuere.', 'Naujausių technologijų pristatymas', 2.5);

-- --------------------------------------------------------

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `verify` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `created_at`, `verify`) VALUES
(3, 'datadogprojektas@gmail.com', '[\"ROLE_USER\", \"ROLE_SUPERUSER\", \"ROLE_ADMIN\"]', '$argon2i$v=19$m=1024,t=2,p=2$V09CWmJXLk45RHhJaFZmcA$ZEGnHDtcP8HYYVD2SqYtkc697Lmpb0pmSjyp6jUh0/I', '2019-05-15 15:31:04', 'NULL'),
(15, 'user1@test.lt', '[\"ROLE_USER\"]', '$argon2i$v=19$m=1024,t=2,p=2$TkhqcG9vYS5vZmgyL2xZaA$cvgDol5sqGJu5F3D33HuK2B+go6wUsz2Q2Haq21MigM', '2019-05-19 16:24:45', 'NULL'),
(16, 'user2@test.lt', '[\"ROLE_USER\"]', '$argon2i$v=19$m=1024,t=2,p=2$L0suQjh6OGJQSzNEeDUxSw$I/dqs1AoJnPeg58L17FotXOCmJQCv6q+MFC3O/SNKaA', '2019-05-19 16:24:57', 'NULL'),
(17, 'user3@test.lt', '[\"ROLE_USER\"]', '$argon2i$v=19$m=1024,t=2,p=2$d0ZrUUx6ZjBKdTJKcHBGWA$3H4j3DPDq2awbv+OvGlfkchqbmIl/KRMiVD56G8X7is', '2019-05-19 16:25:07', 'NULL');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category_event`
--
ALTER TABLE `category_event`
  ADD CONSTRAINT `FK_D39D45EE12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D39D45EE71F7E88B` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `category_user`
--
ALTER TABLE `category_user`
  ADD CONSTRAINT `FK_608AC0E12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_608AC0EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `FK_3BAE0AA71FB8D185` FOREIGN KEY (`host_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
