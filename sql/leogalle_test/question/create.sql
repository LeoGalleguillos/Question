CREATE TABLE `question` (
    `question_id` int(10) unsigned auto_increment,
    `user_id` int(10) unsigned default null,
    `name` varchar(255) default null,
    `subject` varchar(255) not null,
    `message` text,
    `ip` varchar(45) default null,
    `views` int(10) unsigned NOT NULL DEFAULT '0',
    `created` datetime not null,
    `created_name` varchar(255) default null,
    `created_ip` varchar(45) default null,
    `deleted` datetime default null,
    PRIMARY KEY (`question_id`),
    KEY `user_id` (`user_id`),
    KEY `ip` (`ip`),
    KEY `created_deleted` (`created`, `deleted`),
    KEY `created_name_deleted_created` (`created_name`, `deleted`, `created`),
    KEY `created_ip_created` (`created_ip`, `created`)
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
