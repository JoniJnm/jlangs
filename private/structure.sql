SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `langs_bundles` (
`id` int(11) NOT NULL,
  `name` varchar(63) CHARACTER SET ascii NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `langs_keys` (
`id` int(11) NOT NULL,
  `id_bundle` int(11) NOT NULL,
  `name` varchar(63) CHARACTER SET ascii NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `langs_langs` (
`id` int(11) NOT NULL,
  `code` char(2) CHARACTER SET ascii NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `langs_values` (
  `id_lang` int(11) NOT NULL,
  `id_key` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `langs_bundles`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `langs_keys`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_bundle_name` (`id_bundle`,`name`);

ALTER TABLE `langs_langs`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `code` (`code`);

ALTER TABLE `langs_values`
 ADD UNIQUE KEY `id_lang_key` (`id_lang`,`id_key`), ADD KEY `id_key` (`id_key`);


ALTER TABLE `langs_bundles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `langs_keys`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `langs_langs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `langs_keys`
ADD CONSTRAINT `langs_keys_ibfk_1` FOREIGN KEY (`id_bundle`) REFERENCES `langs_bundles` (`id`) ON DELETE CASCADE;

ALTER TABLE `langs_values`
ADD CONSTRAINT `langs_values_ibfk_2` FOREIGN KEY (`id_key`) REFERENCES `langs_keys` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `langs_values_ibfk_1` FOREIGN KEY (`id_lang`) REFERENCES `langs_langs` (`id`);
