-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+05:30';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `exams`;
CREATE TABLE `exams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `name` varchar(55) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deleted` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `exams` (`id`, `active`, `name`, `start_date`, `end_date`, `time`, `created`, `modified`, `deleted`) VALUES
(1,	1,	'General Studies - Paper 1',	'2021-03-22 00:00:00',	'2021-03-24 00:00:00',	60,	'2021-03-22 09:49:01',	'2021-03-23 06:36:45',	0),
(2,	1,	'Mathematics Level - 2',	'2021-03-24 10:00:00',	'2021-03-24 11:00:00',	30,	'2021-03-23 05:48:16',	'2021-03-23 06:37:51',	0),
(3,	1,	'Mathematics Level - II',	'2021-03-23 00:00:00',	'2021-03-24 00:00:00',	30,	'2021-03-23 06:33:03',	'2021-03-23 06:38:49',	0);

DROP TABLE IF EXISTS `exam_questions`;
CREATE TABLE `exam_questions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `exam_id` bigint(20) NOT NULL,
  `question_id` bigint(20) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `exam_questions` (`id`, `exam_id`, `question_id`, `sort`) VALUES
(10,	1,	5,	1616471116),
(11,	1,	4,	1616471120),
(16,	1,	8,	1616471134),
(22,	1,	10,	1616477712),
(23,	1,	9,	1616477717),
(26,	1,	7,	1616478213),
(27,	1,	2,	1616478218),
(28,	1,	12,	1616478358),
(30,	1,	1,	1616478363),
(31,	1,	3,	1616478364),
(33,	2,	7,	1616478530),
(34,	2,	8,	1616478533),
(35,	3,	8,	1616486077),
(36,	3,	6,	1616486080),
(37,	3,	4,	1616486083),
(38,	3,	3,	1616486085),
(39,	3,	2,	1616486086),
(40,	3,	1,	1616486088),
(41,	3,	11,	1616486092),
(42,	3,	12,	1616486093),
(43,	3,	9,	1616486095),
(44,	3,	7,	1616486097);

DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `type` varchar(55) NOT NULL,
  `answer` varchar(55) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `questions` (`id`, `name`, `type`, `answer`, `created`, `modified`, `deleted`) VALUES
(1,	'What is the capital of Telangana?',	'MultipleChoice-SingleAnswer',	'2',	'2021-03-21 12:38:20',	'2021-03-21 14:26:15',	0),
(2,	'Who is India\'s PM?',	'MultipleChoice-SingleAnswer',	'4',	'2021-03-21 13:54:55',	'2021-03-21 14:22:48',	0),
(3,	'What is India\'s national animal?',	'MultipleChoice-SingleAnswer',	'3',	'2021-03-21 13:57:35',	'2021-03-21 14:06:21',	0),
(4,	'Which group does king cobra belong to?',	'MultipleChoice-SingleAnswer',	'3',	'2021-03-21 14:05:54',	'2021-03-23 03:50:10',	0),
(5,	'What is the chemical name for water?',	'MultipleChoice-SingleAnswer',	'2',	'2021-03-23 02:34:01',	'2021-03-23 03:50:21',	0),
(6,	'Newton\'s third law is... Newton\'s third law is ...Newton\'s third law is...Newton\'s third law is...Newton\'s third law isNewton\'s third law isNewton\'s third law isNewton\'s third law isNewton\'s third law isNewton\'s third law isNewton\'s third law is',	'MultipleChoice-SingleAnswer',	'3',	'2021-03-23 02:36:14',	'2021-03-23 04:00:55',	0),
(7,	'What is 10+2 = ?',	'MultipleChoice-SingleAnswer',	'3',	'2021-03-23 02:36:53',	'2021-03-23 02:36:53',	0),
(8,	'What comes after in the following series 2, 4, 6, ...',	'MultipleChoice-SingleAnswer',	'1',	'2021-03-23 02:37:34',	'2021-03-23 03:50:18',	0),
(9,	'Which of following is essential for our survival',	'MultipleChoice-SingleAnswer',	'4',	'2021-03-23 02:38:57',	'2021-03-23 02:38:57',	0),
(10,	'How many legs does a bird have?',	'MultipleChoice-SingleAnswer',	'2',	'2021-03-23 02:40:32',	'2021-03-23 03:50:15',	0),
(11,	'What is sun?',	'MultipleChoice-SingleAnswer',	'3',	'2021-03-23 02:41:45',	'2021-03-23 03:50:12',	0),
(12,	'What is Sun composed of?',	'MultipleChoice-SingleAnswer',	'1',	'2021-03-23 02:42:52',	'2021-03-23 02:42:52',	0);

DROP TABLE IF EXISTS `question_options`;
CREATE TABLE `question_options` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `question_id` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `question_options` (`id`, `question_id`, `name`, `sort`) VALUES
(37,	3,	'Cow',	1),
(38,	3,	'Lion',	2),
(39,	3,	'Tiger',	3),
(40,	3,	'Peacock',	4),
(53,	4,	'Frogs',	1),
(54,	4,	'Crocodiles',	2),
(55,	4,	'Snakes',	3),
(56,	4,	'Lizards',	4),
(57,	2,	'Amitab Bachan',	1),
(58,	2,	'Sachin Tendulkar',	2),
(59,	2,	'K Chandrashekar Rao',	3),
(60,	2,	'Narendra Modi',	4),
(61,	1,	'Kurnool',	1),
(62,	1,	'Hyderabad',	2),
(63,	1,	'Amaravati',	3),
(64,	1,	'Delhi',	4),
(65,	5,	'H2SO4',	1),
(66,	5,	'H2O',	2),
(67,	5,	'CaCl3',	3),
(68,	5,	'None',	4),
(73,	7,	'11',	1),
(74,	7,	'13',	2),
(75,	7,	'12',	3),
(76,	7,	'3',	4),
(77,	8,	'8',	1),
(78,	8,	'7',	2),
(79,	8,	'10',	3),
(80,	8,	'5',	4),
(81,	9,	'Sulphuric Acid',	1),
(82,	9,	'Calcium Carbonate',	2),
(83,	9,	'Hydrogen',	3),
(84,	9,	'Oxygen',	4),
(85,	10,	'1',	1),
(86,	10,	'2',	2),
(87,	10,	'4',	3),
(88,	10,	'Birds doens\'t have legs',	4),
(89,	11,	'A planet',	1),
(90,	11,	'A galaxy',	2),
(91,	11,	'A star',	3),
(92,	11,	'A satellite',	4),
(93,	12,	'Hydrogen and Helium',	1),
(94,	12,	'Oxygen and Nitrogen',	2),
(95,	12,	'Carbon dioxide, Nitrogen and Iron',	3),
(96,	12,	'None',	4),
(97,	6,	'For every action there is no reaction',	1),
(98,	6,	'What goes up should come down',	2),
(99,	6,	'For every action there is equal and opposite reaction',	3),
(100,	6,	'E = MC Square',	4);

DROP TABLE IF EXISTS `question_tags`;
CREATE TABLE `question_tags` (
  `id` bigint(20) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `question_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 2021-03-23 08:01:55