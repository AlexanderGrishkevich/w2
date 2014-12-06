-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Июл 16 2014 г., 22:20
-- Версия сервера: 5.5.34
-- Версия PHP: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `ardfo`
--

-- --------------------------------------------------------

--
-- Структура таблицы `attachments`
--

CREATE TABLE IF NOT EXISTS `attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `banner_url` varchar(200) NOT NULL,
  `discount` int(11) DEFAULT NULL,
  `title` varchar(25) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `region_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `cities`
--

INSERT INTO `cities` (`id`, `title`, `region_id`) VALUES
(1, 'Минский район', 2),
(2, 'Березинский район', 2),
(3, 'Борисовский район', 2),
(4, 'Вилейский район', 2),
(5, 'Воложинский район', 2),
(6, 'Дзержинский район', 2),
(7, 'Жодино', 2),
(8, 'Клецкий район', 2),
(9, 'Копыльский район', 2),
(10, 'Крупский район', 2),
(11, 'Логойский район', 2),
(12, 'Любанский район', 2),
(13, 'Молодечненский район', 2),
(14, 'Мядельский район', 2),
(15, 'Несвижский район', 2),
(16, 'Пуховичский район', 2),
(17, 'Слуцкий район', 2),
(18, 'Смолевичский район', 2),
(19, 'Солигорский район', 2),
(20, 'Стародорожский район', 2),
(21, 'Столбцовский район', 2),
(22, 'Узденский район', 2),
(23, 'Червенский район', 2),
(24, 'Брестский район', 3),
(25, 'Барановичский район', 3),
(26, 'Березовский район', 3),
(27, 'Ганцевичский район', 3),
(28, 'Дрогичинский район', 3),
(29, 'Жабинковский район', 3),
(30, 'Ивановский район', 3),
(31, 'Ивацевичский район', 3),
(32, 'Каменецкий район', 3),
(33, 'Кобринский район', 3),
(34, 'Лунинецкий район', 3),
(35, 'Ляховичский район', 3),
(36, 'Малоритский район', 3),
(37, 'Пинский район', 3),
(38, 'Пружанский район', 3),
(39, 'Столинский район', 3),
(56, 'Гомельский райнон', 4),
(57, 'Брагинский район', 4),
(58, 'Буда-Кошелёвский район', 4),
(59, 'Ветковский район', 4),
(60, 'Добрушский район', 4),
(61, 'Ельский район', 4),
(62, 'Житковичский район', 4),
(63, 'Жлобинский район', 4),
(64, 'Калинковичский район', 4),
(65, 'Кормянский район', 4),
(66, 'Лельчицкий район', 4),
(67, 'Лоевский район', 4),
(68, 'Мозырский район', 4),
(69, 'Наровлянский район', 4),
(70, 'Октябрьский район', 4),
(71, 'Петриковский район', 4),
(72, 'Речицкий район', 4),
(73, 'Рогачёвский район', 4),
(74, 'Светлогорский район', 4),
(75, 'Хойникский район', 4),
(76, 'Чечерский район', 4),
(77, 'Гродненский райнон', 5),
(78, 'Берестовицкий район', 5),
(79, 'Волковысский район', 5),
(80, 'Вороновский район', 5),
(81, 'Дятловский район', 5),
(82, 'Зельвенский район', 5),
(83, 'Ивьевский район', 5),
(84, 'Лидский район', 5),
(85, 'Мостовский район', 5),
(86, 'Новогрудский район', 5),
(87, 'Островецкий район', 5),
(88, 'Ошмянский район', 5),
(89, 'Свислочский район', 5),
(90, 'Слонимский район', 5),
(91, 'Сморгонский район', 5),
(92, 'Щучинский район', 5),
(93, 'Белыничский район', 6),
(94, 'Бобруйский район', 6),
(95, 'Быховский район', 6),
(96, 'Глусский район', 6),
(97, 'Горецкий район', 6),
(98, 'Дрибинский район', 6),
(99, 'Кировский район', 6),
(100, 'Климовичский район', 6),
(101, 'Кличевский район', 6),
(102, 'Краснопольский район', 6),
(103, 'Кричевский район', 6),
(104, 'Круглянский район', 6),
(105, 'Костюковичский район', 6),
(106, 'Мстиславский район', 6),
(107, 'Осиповичский район', 6),
(108, 'Славгородский район', 6),
(109, 'Хотимский район', 6),
(110, 'Чаусский район', 6),
(111, 'Чериковский район', 6),
(112, 'Шкловский район', 6),
(113, 'Витебский район', 7),
(114, 'Браславский район', 7),
(115, 'Верхнедвинский район', 7),
(116, 'Глубокский район', 7),
(117, 'Городокский район', 7),
(118, 'Докшицкий район', 7),
(119, 'Дубровенский район', 7),
(120, 'Лепельский район', 7),
(121, 'Лиозненский район', 7),
(122, 'Миорский район', 7),
(123, 'Новополоцк', 7),
(124, 'Оршанский район', 7),
(125, 'Полоцкий район', 7),
(126, 'Поставский район', 7),
(127, 'Россонский район', 7),
(128, 'Сенненский район', 7),
(129, 'Толочинский район', 7),
(130, 'Ушачский район', 7),
(131, 'Чашникский район', 7),
(132, 'Шарковщинский район', 7),
(133, 'Шумилинский район', 7),
(134, 'Минск', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `text` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `countries`
--

INSERT INTO `countries` (`id`, `title`) VALUES
(1, 'Беларусь');

-- --------------------------------------------------------

--
-- Структура таблицы `dialogs`
--

CREATE TABLE IF NOT EXISTS `dialogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `text` longtext COLLATE utf8_unicode_ci NOT NULL,
  `is_new` tinyint(1) NOT NULL DEFAULT '1',
  `create_date` datetime NOT NULL,
  `deleted_by_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Структура таблицы `favorites`
--

CREATE TABLE IF NOT EXISTS `favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `feedbacks`
--

CREATE TABLE IF NOT EXISTS `feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `userdata` text NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `feedbacks`
--

CREATE TABLE IF NOT EXISTS `forgetpassword` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `code` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(70) COLLATE utf8_unicode_ci,
  `text` longtext COLLATE utf8_unicode_ci,
  `price` int(11) DEFAULT NULL,
  `chaffer` longtext COLLATE utf8_unicode_ci,
  `tags` longtext COLLATE utf8_unicode_ci,
  `is_active` tinyint(1) DEFAULT '0',
  `create_date` datetime DEFAULT NULL,
  `off_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Структура таблицы `regions`
--

CREATE TABLE IF NOT EXISTS `regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `country_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `regions`
--

INSERT INTO `regions` (`id`, `title`, `country_id`) VALUES
(1, 'Минск', 1),
(2, 'Минская область', 1),
(3, 'Брестская область', 1),
(4, 'Гомельская область', 1),
(5, 'Гродненская область', 1),
(6, 'Могилевская область', 1),
(7, 'Витебская область', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `uploads`
--

CREATE TABLE IF NOT EXISTS `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `filename` longtext COLLATE utf8_unicode_ci NOT NULL,
  `filepath` longtext COLLATE utf8_unicode_ci NOT NULL,
  `full_filename` longtext COLLATE utf8_unicode_ci NOT NULL,
  `type` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `reg_type` varchar(50) DEFAULT NULL,
  `org_name` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `region` varchar(50) DEFAULT NULL,
  `zip` varchar(50) DEFAULT NULL,
  `street` varchar(50) DEFAULT NULL,
  `house` varchar(50) DEFAULT NULL,
  `office` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `unp` varchar(50) DEFAULT NULL,
  `egr_org` varchar(50) DEFAULT NULL,
  `egr_num` varchar(50) DEFAULT NULL,
  `egr_date` varchar(50) DEFAULT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `bank_code` varchar(50) DEFAULT NULL,
  `bank_address` varchar(50) DEFAULT NULL,
  `bank_acc` varchar(50) DEFAULT NULL,
  `create_date` varchar(50) DEFAULT NULL,
  `off_date` varchar(50) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


-- --------------------------------------------------------

--
-- Структура таблицы `mainbanners`
--

CREATE TABLE IF NOT EXISTS `mainbanners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `banner_url` varchar(200) DEFAULT NULL,
  `count_likes` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `mainbanners`
--

INSERT INTO `mainbanners` (`id`, `user_id`, `banner_url`, `count_likes`, `type`) VALUES
(1, 0, 'public/uploads/banners/mainBanners/individual.png', 150, 'Человек доверия'),
(2, 0, 'public/uploads/banners/mainBanners/legal.png', 250, 'Марка доверия');

-- --------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
