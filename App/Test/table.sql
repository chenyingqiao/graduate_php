/*
* @Author: lerko
* @Date:   2017-04-06 19:12:11
* @Last Modified by:   lerko
* @Last Modified time: 2017-04-06 20:01:43
*/
show tables;

show create table access_token;
select * from access_token;
{
	drop table access_token;
	CREATE TABLE `access_token` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `client_id` varchar(45) DEFAULT NULL,
	  `expiry_time` datetime DEFAULT NULL,
	  `user_id` int(11) DEFAULT NULL,
	  `scope` int(11) DEFAULT NULL,
	  `revoke` tinyint(1) DEFAULT 1,
	  PRIMARY KEY (`id`),
	  UNIQUE KEY `id_UNIQUE` (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
}

show create table auth;
select * from auth;

show create table blog;
select * from blog;

show create table cat;
select * from cat;

show create table client;
select * from client;

show create table refresh_token;
select * from refresh_token;

show create table user;
select * from user;

show create table user_operation_log;
select * from user_operation_log;

