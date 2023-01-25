CREATE TABLE `messages` (
	`id` INT(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
	`msg` TEXT NOT NULL COLLATE 'utf8mb3_general_ci',
	`author` TEXT NOT NULL COLLATE 'utf8mb3_general_ci',
	`show` TINYINT(1) NOT NULL DEFAULT '1',
	`createdAt` TIMESTAMP NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb3_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=175
;
