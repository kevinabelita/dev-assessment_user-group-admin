DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`userid`),
  UNIQUE KEY `email` (`email`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `groupid` smallint(6) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(100) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`groupid`),
  UNIQUE KEY `groupname` (`groupname`)
) 
COLLATE='utf8_general_ci'
ENGINE=InnoDB;

INSERT INTO `groups` (`groupid`, `groupname`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(1, 'Super Admin', 1, '2024-12-04 00:00:00', 1, '2024-12-04 00:00:00'),
(2, 'Administrator', 1, '2024-12-04 00:00:00', 1, '2024-12-04 00:00:00'),
(3, 'Subscriber', 1, '2024-12-04 00:00:00', 1, '2024-12-04 00:00:00');

DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE `user_groups` (
  `usergroupid` smallint(6) NOT NULL AUTO_INCREMENT,
  `userid` smallint(6) NOT NULL,
  `groupid` smallint(6) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`usergroupid`)
) 
COLLATE='utf8_general_ci'
ENGINE=InnoDB;