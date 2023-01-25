CREATE TABLE `users` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`pseudo` TEXT NOT NULL COLLATE 'utf8mb3_general_ci',
	`pwd` TEXT NOT NULL COLLATE 'utf8mb3_general_ci',
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `UNIQUE` (`pseudo`) USING HASH
)
COLLATE='utf8mb3_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=4
;
