-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Gegenereerd op: 22 feb 2017 om 10:27
-- Serverversie: 10.1.8-MariaDB
-- PHP-versie: 5.6.14


--
-- Database: cake_project
--
CREATE DATABASE IF NOT EXISTS cake_project DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE cake_project;

-- --------------------------------------------------------


DROP TABLE IF EXISTS projects_tags;
DROP TABLE IF EXISTS tags;
DROP TABLE IF EXISTS tasks;
DROP TABLE IF EXISTS projects;



--
-- Tabelstructuur voor tabel projects
--

CREATE TABLE IF NOT EXISTS projects (
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  parent_id int(10) UNSIGNED NOT NULL DEFAULT '0',
  lft INTEGER NOT NULL DEFAULT '0',
  rght INTEGER NOT NULL DEFAULT '0',
  title varchar(200) NOT NULL,
  is_archived BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (id),
  KEY idx_projects_lft (lft),
  KEY idx_projects_rght (rght),
  KEY idx_projects_parent_id (parent_id),
  KEY idx_projects_is_archived (is_archived)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel projects_tags
--

CREATE TABLE IF NOT EXISTS projects_tags (
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  project_id int(10) UNSIGNED NOT NULL,
  tag_id int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (id,project_id,tag_id),
  KEY fk_projects_tags_projects_idx (project_id),
  KEY fk_projects_tags_tags_idx (tag_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel tags
--

CREATE TABLE IF NOT EXISTS tags (
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  title varchar(100) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY title_UNIQUE (title)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel tasks
--

CREATE TABLE IF NOT EXISTS tasks (
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  parent_id int(10) UNSIGNED NOT NULL DEFAULT '0',
  lft INTEGER NOT NULL DEFAULT '0',
  rght INTEGER NOT NULL DEFAULT '0',
  project_id int(10) UNSIGNED NOT NULL,
  title varchar(100) NOT NULL,
  description text CHARACTER SET latin1,
  is_completed BOOLEAN NOT NULL DEFAULT FALSE,
  is_archived BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (id),
  KEY fk_tasks_projects_idx (project_id),
  KEY idx_tasks_lft (lft),
  KEY idx_tasks_rght (rght),
  KEY idx_tasks_parent_id (parent_id),
  KEY idx_tasks_project_id (project_id),
  KEY idx_tasks_is_archived (is_archived)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel projects_tags
--
ALTER TABLE projects_tags
  ADD CONSTRAINT fk_projects_tags_projects FOREIGN KEY (project_id) REFERENCES projects (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT fk_projects_tags_tags FOREIGN KEY (tag_id) REFERENCES tags (id) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel tasks
--
ALTER TABLE tasks
  ADD CONSTRAINT fk_tasks_projects FOREIGN KEY (project_id) REFERENCES projects (id) ON DELETE CASCADE ON UPDATE CASCADE;
