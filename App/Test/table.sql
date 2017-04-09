/*
* @Author: lerko
* @Date:   2017-04-06 19:12:11
* @Last Modified by:   ‘chenyingqiao’
* @Last Modified time: 2017-04-09 08:14:53
*/
show tables;

show create table access_token;
select * from access_token;
{
	drop table access_token;
	CREATE TABLE `access_token` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `access_token_id` varchar(255) DEFAULT '',
	  `client_id` varchar(45) DEFAULT NULL,
	  `expiry_time` datetime DEFAULT NULL,
	  `user_id` int(11) DEFAULT NULL,
	  `scope` varchar(45) DEFAULT NULL,
	  `revoke` tinyint(1) DEFAULT 1,
	  PRIMARY KEY (`id`),
	  UNIQUE KEY `id_UNIQUE` (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
}

show create table auth;
select * from auth;
{
	drop table auth;
	CREATE TABLE `auth` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `client_id` varchar(45) COLLATE utf8_bin DEFAULT NULL,
	  `expiry_time` datetime DEFAULT NULL,
	  `user_id` int(11) DEFAULT NULL,
	  `scope` int(11) DEFAULT NULL,
	  `revoke` tinyint(1) DEFAULT 0,
	  `redirect_url` text COLLATE utf8_bin,
	  PRIMARY KEY (`id`),
	  UNIQUE KEY `id_UNIQUE` (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
}

show create table blog;
select * from blog;

show create table cat;
select * from cat;

show create table client;
select * from client;
{
	drop table client;
	CREATE TABLE `client` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `name` varchar(45) DEFAULT NULL,
	  `redirect_url` text,
	  `secret` varchar(255) DEFAULT NULL,
	  `is_confidential` tinyint(1) DEFAULT NULL,
	  PRIMARY KEY (`id`),
	  UNIQUE KEY `id_UNIQUE` (`id`)
	) ENGINE=InnoDB auto_increment=1000001 DEFAULT CHARSET=utf8
}

show create table refresh_token;
select * from refresh_token;

show create table user;
select * from user;
{
	drop table user;
	CREATE TABLE user (
	  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	  `username` VARCHAR(45) NULL,
	  `password` VARCHAR(45) NULL,
	  `create_time` VARCHAR(45) NULL,
	  `update_time` VARCHAR(45) NULL,
	  `hard_image` VARCHAR(45) NULL,
	  `sex` TINYINT(1) NULL,
	  PRIMARY KEY (`id`),
	  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
	ENGINE = InnoDB
	DEFAULT CHARACTER SET = utf8
	COLLATE = utf8_bin
}

show create table user_operation_log;
select * from user_operation_log;


