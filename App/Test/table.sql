/*
* @Author: lerko
* @Date:   2017-04-06 19:12:11
* @Last Modified by:   ‘chenyingqiao’
* @Last Modified time: 2017-04-23 21:59:22
*/
show tables;


show create table user_operation_log;
select * from user_operation_log;

show create table blog;
delete from blog where id=-1;
delete from blog where title is null;
select id,uid,title,visit_count,create_time from blog;
select `blog`.`id`,`blog`.`uid`,`blog`.`markdown`,`blog`.`title`,`blog`.`discreption`,`blog`.`content`,`blog`.`create_time`,`blog`.`update_time`,`blog`.`cat_id`,`blog`.`visit_count`,`blog`.`tag_id` from blog order by blog.visit_count asc limit 0,10;
{
truncate table blog;
delete from blog where `blog`.`title` = 'sdfsdf';
	drop table blog;
	CREATE TABLE IF NOT EXISTS `blog`.`blog` (
	  `id` INT NOT NULL AUTO_INCREMENT,
	  `uid` INT NOT NULL DEFAULT 0,
	  `markdown` TEXT NULL,
	  `title` VARCHAR(45) NULL,
	  `discreption` VARCHAR(45) NULL,
	  `content` TEXT NULL,
	  `create_time` VARCHAR(45) NULL,
	  `update_time` VARCHAR(45) NULL,
	  `cat_id` VARCHAR(45) NULL,
	  `visit_count` INT(11) DEFAULT 0,
	  `tag_id` INT(11) DEFAULT 0,
	  `like` INT(11) DEFAULT 0,
	  PRIMARY KEY (`id`),
	  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
	  INDEX `title_SERCHER` USING BTREE (`title` ASC) )
	ENGINE = InnoDB
	DEFAULT CHARACTER SET = utf8

	insert into blog (title,discreption,content,create_time,update_time,cat_id) values ('test', 'tesetesets', '<h1>teset</h1>', '', '', '1');
);
}

show create table cat;
select * from cat;
insert into cat values (1,"test",1),(2,"test",1),(3,"test",1);

--关联图片和博客的表
show create table image_blog_ref;
select * from image_blog_ref;
{
	CREATE TABLE IF NOT EXISTS `blog`.`image_blog_ref` (
	  `id` INT(11) NOT NULL AUTO_INCREMENT,
	  `blog_id` INT(11) NULL,
	  `image_id` INT(11) NULL,
	  PRIMARY KEY (`id`))
	ENGINE = InnoDB
	DEFAULT CHARACTER SET = utf8
	COLLATE = utf8_bin
}

show create table blog_like;
select * from blog_like;
{
	drop table blog_like;
	CREATE TABLE IF NOT EXISTS `blog`.`blog_like` (
	  `id` INT(11) NOT NULL AUTO_INCREMENT,
	  `uid` INT(11) NULL,
	  `article_id` VARCHAR(45) NULL,
	  PRIMARY KEY (`id`))
	ENGINE = InnoDB
	DEFAULT CHARACTER SET = utf8
	COLLATE = utf8_bin
}

show create table user;
truncate table user;
select * from user;
{
	delete from user where username is null;
	drop table user;
	CREATE TABLE user (
	  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	  `username` VARCHAR(45) NULL,
	  `password` VARCHAR(255) NULL,
	  `create_time` VARCHAR(45) NULL,
	  `update_time` VARCHAR(45) NULL,
	  `role` INT(3) DEFAULT 1,
	  `head_image` TEXT NULL,
	  `sex` TINYINT(1) NULL,
	  PRIMARY KEY (`id`),
	  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
	ENGINE = InnoDB
	DEFAULT CHARACTER SET = utf8
	COLLATE = utf8_bin
}

show create table comment;
select * from comment;
{
	drop table comment;
	CREATE TABLE IF NOT EXISTS `blog`.`comment` (
	  `id` INT NOT NULL AUTO_INCREMENT,
	  `content` VARCHAR(45) NULL,
	  `uid` VARCHAR(45) NULL,
	  `blog_id` INT(11) DEFAULT 0,
	  `ref_comment_id` VARCHAR(45) NULL COMMENT '关联的评论',
	  `create_time` VARCHAR(45) NULL,
	  `update_time` VARCHAR(45) NULL,
	  PRIMARY KEY (`id`),
	  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
	ENGINE = InnoDB
	DEFAULT CHARACTER SET = utf8
}

-- 图片存储中心
show create table image_warehouse;
select * from image_warehouse;
{
	CREATE TABLE IF NOT EXISTS `blog`.`image_warehouse` (
	  `id` INT NOT NULL AUTO_INCREMENT,
	  `image_path` VARCHAR(255) NULL,
	  `image_cut_path` VARCHAR(45) NULL,
	  PRIMARY KEY (`id`))
	ENGINE = InnoDB
	DEFAULT CHARACTER SET = utf8
	COLLATE = utf8_bin
}

{
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

	show create table access_token;
	select * from access_token;
	truncate table access_token;
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
}
