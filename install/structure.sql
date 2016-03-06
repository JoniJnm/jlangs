SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `langs_keys` (
`id` int(11) NOT NULL,
  `id_project` int(11) NOT NULL,
  `hash` char(32) CHARACTER SET ascii NOT NULL,
  `default_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `langs_langs` (
`id` int(11) NOT NULL,
  `id_project` int(11) NOT NULL,
  `code` char(2) CHARACTER SET ascii NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `langs_projects` (
`id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `langs_values` (
  `id_lang` int(11) NOT NULL,
  `id_key` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `langs_keys`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_project` (`id_project`,`hash`);

ALTER TABLE `langs_langs`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_project` (`id_project`,`code`);

ALTER TABLE `langs_projects`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `langs_values`
 ADD UNIQUE KEY `id_lang_key` (`id_lang`,`id_key`), ADD KEY `id_key` (`id_key`);


ALTER TABLE `langs_keys`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `langs_langs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `langs_projects`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `langs_keys`
ADD CONSTRAINT `langs_keys_ibfk_1` FOREIGN KEY (`id_project`) REFERENCES `langs_projects` (`id`) ON DELETE CASCADE;

ALTER TABLE `langs_langs`
ADD CONSTRAINT `langs_langs_ibfk_1` FOREIGN KEY (`id_project`) REFERENCES `langs_projects` (`id`) ON DELETE CASCADE;

ALTER TABLE `langs_values`
ADD CONSTRAINT `langs_values_ibfk_1` FOREIGN KEY (`id_lang`) REFERENCES `langs_langs` (`id`),
ADD CONSTRAINT `langs_values_ibfk_2` FOREIGN KEY (`id_key`) REFERENCES `langs_keys` (`id`) ON DELETE CASCADE;
