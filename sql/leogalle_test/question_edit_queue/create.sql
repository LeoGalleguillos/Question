CREATE TABLE `question_edit_queue` (
    `question_edit_queue_id` int(10) unsigned auto_increment,
    `question_id` int(10) unsigned not null,
    `user_id` int(10) unsigned default null,
    `name` varchar(255) default null,
    `subject` varchar(255) not null,
    `message` text,
    `ip` varchar(45) default null,
    `created` datetime not null,
    `reason` varchar(255) default null,
    `modified` datetime default null,
    `queue_status_id` tinyint(1) default 0,
    PRIMARY KEY (`question_edit_queue_id`)
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
