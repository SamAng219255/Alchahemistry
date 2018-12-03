CREATE DATABASE alchahemistry;
use alchahemistry;

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(64) NOT NULL,
  `color` char(6) NOT NULL DEFAULT 'C0C0C0',
  `pending` text NOT NULL,
  `ip` varchar(45) NOT NULL,
  `laston` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prefix` varchar(16) NOT NULL DEFAULT '',
  `suffix` varchar(16) NOT NULL DEFAULT '',
  `permissions` int NOT NULL DEFAULT '0',
  `x` int NOT NULL DEFAULT '0',
  `y` int NOT NULL DEFAULT '0',
  `health` int NOT NULL DEFAULT '0',
  `xp` int NOT NULL DEFAULT '0',
  `zone` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `name` varchar(32) NOT NULL,
  `count` int NOT NULL,
  `new` int NOT NULL,
  `slot` int NOT NULL,
  `data` text NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `dungeon` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `x` int NOT NULL DEFAULT '0',
  `y` int NOT NULL DEFAULT '0',
  `z` int NOT NULL DEFAULT '0',
  `name` varchar(16) NOT NULL DEFAULT 'blank',
  `sprite` varchar(16) NOT NULL DEFAULT 'none',
  `data` text NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `base` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `x` int NOT NULL DEFAULT '0',
  `y` int NOT NULL DEFAULT '0',
  `z` int NOT NULL DEFAULT '0',
  `name` varchar(16) NOT NULL DEFAULT 'blank',
  `sprite` varchar(16) NOT NULL DEFAULT 'none',
  `data` text NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `battlefield` (
  `id` int NOT NULL AUTO_INCREMENT,
  `x` int NOT NULL DEFAULT '0',
  `y` int NOT NULL DEFAULT '0',
  `z` int NOT NULL DEFAULT '0',
  `name` varchar(16) NOT NULL DEFAULT 'blank',
  `sprite` varchar(16) NOT NULL DEFAULT 'none',
  `data` text NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

GRANT ALL PRIVILEGES ON `chat`.* TO `username`@`localhost` IDENTIFIED BY 'password';