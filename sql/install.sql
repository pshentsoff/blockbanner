-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 14 2013 г., 21:55
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `db_takzdorovo`
--

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_blockbanner_banners`
--

CREATE TABLE IF NOT EXISTS `prefix_blockbanner_banners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `url` varchar(256) NOT NULL,
  `url_title` varchar(256) NOT NULL,
  `image_path` varchar(256) NOT NULL,
  `image_url` varchar(256) NOT NULL,
  `image_alt` varchar(256) NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `visible` int(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `prefix_blockbanner_banners`
--

INSERT INTO `prefix_blockbanner_banners` (`id`, `name`, `url`, `url_title`, `image_path`, `image_url`, `image_alt`, `order`, `visible`) VALUES
(7, '90 лет роспотребнадзору', '/', '', '', '/uploads/images/banners/banner_online_rpn.png', '', 0, 1),
(8, 'Online', '', '', '', '/uploads/images/banners/banner_online_omc.png', '', 0, 1),
(9, 'Форум ', '', '', '', '/uploads/images/banners/banner_online.png', '', 0, 1),
(10, 'Горизонты', '', '', '', '/uploads/images/banners/gorizont.gif', '', 0, 1),
(11, 'Служба крови', '', '', '', '/uploads/images/banners/blood.png', '', 0, 1),
(12, 'Департамент здравоохранения', '', '', '', '/uploads/images/banners/gorzdrav.png', '', 0, 1),
(13, 'ОКБ№1', '', '', '', '/uploads/images/banners/okb1.png', '', 0, 1),
(14, 'ТФОМС', '', '', '', '/uploads/images/banners/tfoms.png', '', 0, 1),
(15, 'Покуаем тюменское', '', '', '', '/uploads/images/banners/buy_help.png', '', 0, 1),
(16, 'Центр гигиены', '', '', '', '/uploads/images/banners/gigena.jpeg', '', 0, 1),
(17, 'ТРМО', '', '', '', '/uploads/images/banners/trmo.jpg', '', 0, 1);

CREATE TABLE IF NOT EXISTS `prefix_blockbanner_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL COMMENT 'Короткое определяющее имя группы (лат. символы, цифры, знаки ''-'', ''_'')',
  `hook` varchar(256) NOT NULL,
  `template` varchar(256) NOT NULL,
  `visible` int(1) unsigned NOT NULL DEFAULT '0',
  `include_pages` text NOT NULL COMMENT 'Страницы на которых отображать группу. Оставить пустым если на всех.',
  `exclude_pages` text NOT NULL,
  `comments` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `name_2` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

INSERT INTO `prefix_blockbanner_groups` (`id`, `name`, `hook`, `template`, `visible`, `include_pages`, `exclude_pages`, `comments`) VALUES
(4, 'MainBanner', 'blockbanner_header', 'blocks/block.banner.tpl', 1, '', 'blog', ''),
(5, 'PortalFriends', 'blockbanner_leftside', 'blocks/block.banner.tpl', 1, '', '', '');

CREATE TABLE IF NOT EXISTS `prefix_blockbanner_groupsbanners` (
  `group_id` int(10) unsigned NOT NULL,
  `banner_id` int(10) unsigned NOT NULL,
  KEY `group_id` (`group_id`,`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `prefix_blockbanner_groupsbanners` (`group_id`, `banner_id`) VALUES
(4, 9),
(5, 7),
(5, 10),
(5, 11),
(5, 12),
(5, 13);
