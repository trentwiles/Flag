-- Installer for Flag, run this before using Flag for the first time
-- DO NOT RUN THIS TWICE!

-- DROP DATABASE IF EXISTS `flag`;

CREATE DATABASE `flag`;

USE `flag`;

CREATE TABLE `actions` (
  `username` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `id` varchar(30) NOT NULL,
  `epoch` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `admins` (
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `bans` (
  `username` varchar(100) NOT NULL,
  `reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `comments` (
  `username` varchar(255) NOT NULL,
  `comment` mediumtext NOT NULL,
  `epoch` int(11) NOT NULL,
  `id` varchar(100) NOT NULL,
  `comment_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `resets` (
  `token` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `stat` (
  `id` varchar(255) NOT NULL,
  `views` int(255) NOT NULL,
  `likes` int(255) NOT NULL,
  `dislikes` int(255) NOT NULL,
  `comments` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `signup_time` int(30) NOT NULL,
  `id` varchar(30) NOT NULL,
  `ip` varchar(200) NOT NULL,
  `bio` mediumtext NOT NULL,
  `pfp` varchar(255) NOT NULL,
  `comments` int(1) NOT NULL,
  `announce` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `videos` (
  `v_title` varchar(150) NOT NULL,
  `v_desc` mediumtext NOT NULL,
  `v_size` int(40) NOT NULL,
  `v_url` varchar(255) NOT NULL,
  `v_id` varchar(10) NOT NULL,
  `v_len` int(10) NOT NULL,
  `v_uploader` varchar(100) NOT NULL,
  `v_thumb` varchar(255) NOT NULL,
  `v_time` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;