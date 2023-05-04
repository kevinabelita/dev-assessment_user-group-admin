CREATE TABLE `users` (
	`userid` INT(11) NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(150) NOT NULL,
	`name` VARCHAR(50) NOT NULL,
	`phone` VARCHAR(50) NOT NULL,
	`created_by` INT(11) NOT NULL,
	`created_date` DATETIME NOT NULL,
	`updated_by` INT(11) NOT NULL,
	`updated_date` TIMESTAMP NOT NULL DEFAULT '',
	PRIMARY KEY (`userid`),
	UNIQUE INDEX `email` (`email`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;





CREATE TABLE `groups` (
	`groupid` SMALLINT(6) NOT NULL AUTO_INCREMENT,
	`groupname` VARCHAR(100) NOT NULL,
	`created_by` INT(11) NOT NULL,
	`created_date` DATETIME NOT NULL,
	`updated_by` INT(11) NOT NULL,
	`updated_date` TIMESTAMP NOT NULL DEFAULT '',
	PRIMARY KEY (`groupid`),
	UNIQUE INDEX `groupname` (`groupname`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
