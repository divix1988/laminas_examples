CREATE TABLE IF NOT EXISTS `pages` (
	`id` int(10) unsigned AUTO_INCREMENT NOT NULL,
	`name` varchar(40) CHARACTER SET utf8 NOT NULL,
	`url` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
	`parent_id` int(11) NOT NULL DEFAULT '0',
	`required` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `page_contents` (
	`id` int(10) unsigned AUTO_INCREMENT NOT NULL,
	`name` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `page_lang_contents` (
	`id` int(10) unsigned AUTO_INCREMENT NOT NULL,
	`lang` varchar(2) CHARACTER SET utf32 NOT NULL,
	`content` text CHARACTER SET utf8 NOT NULL,
	`page_content_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `page_metadata` (
	`id` int(10) unsigned AUTO_INCREMENT NOT NULL,
	`lang` varchar(3) CHARACTER SET latin1 NOT NULL,
	`title` varchar(100) NOT NULL,
	`description` varchar(100) NOT NULL,
	`keywords` varchar(150) NOT NULL,
	`page_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `page_to_contents` (
	`id` int(10) unsigned AUTO_INCREMENT NOT NULL,
	`page_id` int(11) NOT NULL,
	`content_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
--
-- Indexes for the tables
--
ALTER TABLE `pages`
ADD PRIMARY KEY (`id`), ADD KEY `parent_id` (`parent_id`);
ALTER TABLE `page_contents`
ADD PRIMARY KEY (`id`), ADD KEY `name` (`name`);
ALTER TABLE `page_lang_contents`
ADD PRIMARY KEY (`id`), ADD KEY `lang` (`lang`);
ALTER TABLE `page_metadata`
ADD PRIMARY KEY (`id`);
ALTER TABLE `page_to_contents`
ADD PRIMARY KEY (`id`), ADD KEY `page_id` (`page_id`,`content_id`);
