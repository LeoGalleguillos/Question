CREATE TABLE `question` (
    `question_id` int(10) unsigned auto_increment,
    `user_id` int(10) unsigned default null, #@todo Rename column to `created_user_id`
    `subject` varchar(255) not null,
    `message` text,
    `views` int(10) unsigned NOT NULL DEFAULT '0',
    `views_browser` int(10) unsigned NOT NULL DEFAULT '0',
    `views_not_bot_one_month` int(10) unsigned NOT NULL DEFAULT '0',
    `created_datetime` datetime NOT NULL,
    `created_name` varchar(255) default null, #@todo Rename column to `name`
    `created_ip` varchar(45) default null,
    `modified_datetime` DATETIME DEFAULT NULL,
    `modified_user_id` INT(10) UNSIGNED DEFAULT NULL,
    `modified_reason` varchar(255) DEFAULT NULL,
    `deleted_datetime` datetime default null,
    `deleted_user_id` int(10) default null,
    `deleted_reason` varchar(255) default null,
    PRIMARY KEY (`question_id`),
    KEY `user_id` (`user_id`),
    KEY `subject_deleted_datetime_views_browser` (`subject`, `deleted_datetime`, `views_browser`),
    KEY `created_datetime_deleted_datetime_views_browser` (`created_datetime`, `deleted_datetime`, `views_browser`),
    KEY `created_name_deleted_datetime_created_datetime` (`created_name`, `deleted_datetime`, `created_datetime`),
    KEY `created_name_deleted_datetime_views_browser` (`created_name`, `deleted_datetime`, `views_browser`),
    KEY `created_name_deleted_datetime_views_not_bot_one_month` (`created_name`, `deleted_datetime`, `views_not_bot_one_month`),
    KEY `created_ip_created_datetime` (`created_ip`, `created_datetime`),
    KEY `deleted_datetime_created_datetime` (`deleted_datetime`, `created_datetime`),
    KEY `deleted_user_id_deleted_datetime` (`deleted_user_id`, `deleted_datetime`),
    KEY `message_255` (`message`(255))
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
